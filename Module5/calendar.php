<?php
    ini_set("session.cookie_httponly", 1);
    session_start();
	if (isset($_SESSION['user_id'])) { 
		$_SESSION['loggedin'] = true;
	}
	else {
		$_SESSION['loggedin'] = false;
	}
    date_default_timezone_set('America/Chicago');
    $today = "'".date('Y\-m\-d')."'";
    $_SESSION['token'] = substr(md5(rand()), 0, 10);
?>
<!DOCTYPE html>

<html>
<head>
    <title>Calendar</title>
    <meta charset="utf-8"/>
    <link href='fullcalendar.css' rel='stylesheet' />
    <link href='fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='lib/moment.min.js'></script>
    <script src='lib/jquery.min.js'></script>
    <script src='fullcalendar.min.js'></script>
    <style>
        body {
            margin: 40px 10px;
            padding: 0;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
            font-size: 14px;
        }
    
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
    
    <script>
        
        $(document).ready(function() {

            var calendar = $('#calendar').fullCalendar({
                
                editable: <?php
                    if ($_SESSION['loggedin']) echo 'true'; else echo 'false';
                ?>,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                
                defaultDate: <?php echo $today;?>,
                
                eventLimit: true, // allow "more" link when too many events
                allDayDefault: false,
                allDaySlot: false,
                events: 'events.php',
                    
                
                // Convert the allDay from string to boolean
                eventRender: function(event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                
                selectable: <?php
                    if ($_SESSION['loggedin']) echo 'true'; else echo 'false';
                ?>,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                
                    if (title) {
                        var start = $.fullCalendar.moment(start).format();
                        var end = $.fullCalendar.moment(end).format();
                        $.ajax({
                            url: 'add_events.php',
                            data: 'title='+ title+'&start='+ start +'&end='+ end,
                            type: "POST",
                            success: function(json) {
                            alert('Added Successfully');
                            }
                            });
                            calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end
                            },
                            true // make the event "stick"
                            );
                    }
                calendar.fullCalendar('unselect');
                },
                             
                editable: <?php
                    if ($_SESSION['loggedin']) echo 'true'; else echo 'false';
                ?>,
                
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.moment(event.start).format();
                    var end = $.fullCalendar.moment(event.end).format();
                    $.ajax({
                        url: 'update_events.php',
                        data: 'title='+event.title+'&start='+start+'&end='+end+'&id='+event.id,
                        type: "POST",
                        success: function(json) {
                        alert("Updated Successfully");
                        }
                    });
                },
                
                eventResize: function(event, delta) {
                    var start = $.fullCalendar.moment(event.start).format();
                    var end = $.fullCalendar.moment(event.end).format();
                    $.ajax({
                        url: 'update_events.php',
                        data: 'title='+event.title+'&start='+start+'&end='+end+'&id='+event.id,
                        type: "POST",
                        success: function(json) {
                        alert("Updated Successfully");
                        }
                    });
             
                },
                
                eventDragStop: function(event,jsEvent) {

                    var trashEl = jQuery('#calendarTrash');
                    var ofs = trashEl.offset();
                
                    var x1 = ofs.left;
                    var x2 = ofs.left + trashEl.outerWidth(true);
                    var y1 = ofs.top;
                    var y2 = ofs.top + trashEl.outerHeight(true);
                
                    if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
                        jsEvent.pageY>= y1 && jsEvent.pageY <= y2) {
                        $.ajax({
                        type: "POST",
                        url: "delete_events.php",
                        data: "&id=" + event.id
                    	});
                        calendar.fullCalendar('removeEvents', event.id);
                    }
                }
                
                });
		
        });
    </script>    
</head>

<body>
    <h3>
		<?php
			if ($_SESSION['loggedin']) {
				echo "Welcome ".htmlentities($_SESSION['user_id'])."!
				<br><span><a href='logout.php'>Logout</a></span>";
			}
			else { 
				echo "Welcome!<br><span><a href='signin.php'>Log in</a></span><br><span><a href='signup.php'>Create an account</a></span>";
			}
		?>
	</h3>
    <?php
        if ($_SESSION['loggedin']) echo "<div id='calendarTrash' class='calendar-trash'><img src='trash.png' alt='trash' height='64' width='64'></div>";
    ?>
    <div id='calendar'></div>
</body>
</html>
