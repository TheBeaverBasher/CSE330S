var express = require('express'),
    app = express(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server),
    mongoose = require('mongoose'),  
    roomObject = new Array();
    
    roomObject[0] =
        {
            admin: null,
            name: "Main Lobby",
            users: [],
            privt: 0,
            allowedUsers: [],
            bannedUsers: []
        };
    
server.listen(3456)

mongoose.connect('mongodb://localhost/chat', function(err){
    if(err){
        console.log(err);
    } else {
        console.log('Database connection successful!');
    }
});

var chatSchema = mongoose.Schema({
   user: String,
   message: String,
   created: {type: Date, default: Date.now},
   room: Number
});

var chatModel = mongoose.model('Message', chatSchema);

app.get('/', function(req,res){
    res.sendFile(__dirname + '/chat.html');
});

io.sockets.on('connection', function(socket){
    
    var query = chatModel.find({room: socket.room});
    query.sort('-created').exec(function(err, docs){
        if (err) throw err;
        console.log('Retrieving old messages!');
        socket.emit('load old messages', docs);
    });
    
    socket.on('new user', function(data, callback){
        var bool = true;
        for (var i = 0; i < roomObject.length; i++) {
            if (roomObject[i].users.indexOf(data) != -1) {
                callback(false);
                bool = false;
                break;
            }
        }
        if (bool) {
            callback(true);
            socket.username = data.trim();
            socket.room = 0;
            roomObject[socket.room].users.push(socket.username);
            updateUsers();
            updateRooms();
            io.sockets.emit('current room', roomObject[socket.room].name);
        }
        
    });
    
    socket.on('change room', function(data,callback){
        if (roomObject[data].privt) {
            if ($.inArray(socket.username, roomObject[data].allowedUsers) != -1) {
                socket.room = data;
                io.sockets.emit('current room', roomObject[socket.room].name)
                updateUsers();
                callback(true);
            } else {
                callback(false);
            }
            
        } else if ($.inArray(socket.username, roomObject[data].bannedUsers) != -1) {
            callback(false);
        } else {
            socket.room = data;
            io.sockets.emit('current room', roomObject[socket.room].name)
            updateUsers();
        }
    });
    
    socket.on('new room', function(data, callback){
        var bool = true;
        for (var i = 0; i < roomObject.length; i++) {
            if (data.trim() == roomObject[i].name) {
                callback(false);
                bool = false;
                break;
            }
        }
        if (bool) {
            callback(true);
            roomObject.push({
                admin: socket.username,
                name: data.trim(),
                users: [socket.username],
                privt: 0,
                allowedUsers: [socket.username],
                bannedUsers: []
            });
            socket.room = roomObject.length - 1;
            updateRooms();
            updateUsers();
            io.sockets.emit('current room', roomObject[socket.room].name);
        }
    });
    
    function updateUsers() {
        io.sockets.emit('usernames', roomObject[socket.room].users);
    }
    
    function updateRooms() {
        io.sockets.emit('roomnames', roomObject);
    }
    
    socket.on('disconnect', function(data){
        if (!socket.username) return;
        roomObject[socket.room].users.splice(roomObject[socket.room].users.indexOf(socket.username),1);
        for (var i = 0; i < roomObject.length; i++) {
            if (roomObject[i].admin == socket.username) {
                delete roomObject[i];
                chatModel.find({room: i}).remove().exec();
            }
        }
        updateUsers();
        updateRooms();
    });
    
    socket.on('send message', function(data){
        var msg = data.trim();
        if (msg.substring(0,5)==='/ban ') {
            if (socket.username == roomObject[socket.room].admin) {
                roomObject[socket.room].bannedUsers.push(msg.substring(5));
            }
        } else if (msg.substring(0,4)==='/prv') {
            if (socket.username == roomObject[socket.room].admin) {
                roomObject[socket.room].privt = 1;
            }
        } else if (msg.substring(0,4)==='/pub') {
            if (socket.username == roomObject[socket.room].admin) {
                roomObject[socket.room].privt = 0;
            }
        } else if (msg.substring(0,5)==='/alw ') {
            if (socket.username == roomObject[socket.room].admin) {
                roomObject[socket.room].allowedUsers.push(msg.substring(5));
            }
        } else if (msg.substring(0,5)==='/rmb ') {
            if (socket.username == roomObject[socket.room].admin) {
                roomObject[socket.room].bannedUsers.splice(roomObject[socket.room].bannedUsers.indexOf(msg.substring(5)),1);
            }
        } else if (msg.substring(0,5)==='/rma ') {
            if (socket.username == roomObject[socket.room].admin) {
                roomObject[socket.room].bannedUsers.splice(roomObject[socket.room].allowedUsers.indexOf(msg.substring(5)),1);
            }
        } else {
            var newMsg = new chatModel({
            message: msg,
            user: socket.username,
            room: socket.room
            });
            newMsg.save(function(err){
                if (err) throw err;
                io.sockets.emit('new message', {
                    message: msg,
                    user: socket.username,
                    room: socket.room
                });    
            });  
        }
    });
});

