// initialize our faux database
var data = {
  "posts": [{"title":"Some cheer event", "link": "http://reddit.com/r/all", "uid": "1", "comments": [] }],
  "users": []
};
/*
var MongoClient = require('mongodb').MongoClient;
var assert = require('assert');
var ObjectId = require('mongodb').ObjectID;
var url = 'mongodb://localhost:27017/test';
*/





// GET

exports.posts = function (req, res) {
  var posts = [];
  data.posts.forEach(function (post, i) {
    posts.push({
      id: i,
      uid: post.uid,
      title: post.title,
      link: post.link,
      comments: { }
    });
  });
  res.json({
    posts: posts
  });
};

exports.comment = function (req, res) {
  var id = req.params.id;
  if (id >= 0 && id < data.posts.length) {
    res.json({
      post: data.posts[id]
    });
  } else {
    res.json(false);
  }
};

// POST
exports.addPost = function (req, res) {
  data.posts.push(req.body);
  res.json(req.body);
};

exports.addComment = function(req, res) {
  var id = req.params.id;
  data.posts[id].comments.push(req.body)
  res.json(req.body);
}

// PUT
exports.editPost = function (req, res) {
  var id = req.params.id;

  if (id >= 0 && id < data.posts.length) {
    data.posts[id] = req.body;
    res.json(true);
  } else {
    res.json(false);
  }
};

exports.editComment = function (req, res) {
  var id = req.params.id;
  var cid = req.params.cid;

  if (id >= 0 && id < data.posts.length) {
    data.posts[id].comments[cid] = req.body;
    res.json(true);
  } else {
    res.json(false);
  }
};

// DELETE
exports.deletePost = function (req, res) {
  var id = req.params.id;

  if (id >= 0 && id < data.posts.length) {
    data.posts.splice(id, 1);
    res.json(true);
  } else {
    res.json(false);
  }
};

exports.deleteComment = function (req, res) {
  var id = req.params.id;
  var cid = req.params.cid;

  if (id >= 0 && id < data.posts.length) {
    data.posts[id].comments.splice(cid, 1);
    res.json(true);
  } else {
    res.json(false);
  }
};
