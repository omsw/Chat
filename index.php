<!DOCTYPE html>
<html>
  <head>
	  <title>WebSockets with HTML5</title>
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">

	  <style type="text/css">
	  	*,
*:before,
*:after {
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
}

html {
	font-family: Helvetica, Arial, sans-serif;
	font-size: 100%;
	background: #333;
}

#page-wrapper {
	width: 650px;
	background: #FFF;
	padding: 1em;
	margin: 1em auto;
	border-top: 5px solid #69c773;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.8);
}

h1 {
	margin-top: 0;
}

#status {
	font-size: 0.9rem;
	margin-bottom: 1rem;
}

.open {
	color: green;
}

.closed {
	color: red;
}

ul {
	list-style: none;
	margin: 0;
	padding: 0;
	font-size: 0.95rem;
}

ul li {
	padding: 0.5rem 0.75rem;
	border-bottom: 1px solid #EEE;
}

ul li:first-child {
	border-top: 1px solid #EEE;
}

ul li span {
	display: inline-block;
	width: 90px;
	font-weight: bold;
	color: #999;
	font-size: 0.7rem;
	text-transform: uppercase;
	letter-spacing: 1px;
}

.sent {
	background-color: #F7F7F7;
}

.received {}

#form-msg {
	margin-top: 1.5rem;
}

input[type="text"] {
	width: 75%;
	padding: 0.5rem;
	font-size: 1rem;
	border: 1px solid #D9D9D9;
	border-radius: 3px;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1);
	margin-bottom: 1rem;
}

button {
	display: inline-block;
	border-radius: 3px;
	border: none;
	font-size: 0.9rem;
	padding: 0.6rem 1em;
	color: white;
	margin: 0 0.25rem;
	text-align: center;
	background: #BABABA;
	border-bottom: 1px solid #999;
}

button[type="submit"] {
	background: #86b32d;
	border-bottom: 1px solid #5d7d1f;
}

button:hover {
	opacity: 0.75;
	cursor: pointer;
}
	  </style>
	 
  </head>
  <body>
	  <div id="page-wrapper">
		  <h1>WebSockets</h1>

		  <div id="status">Conected to the app <span id="url"></span></div>

		  <ul id="messages"></ul>

		  
			  <div id="msgt"><ul id="friendsList"></ul></div>
			  <input type="text" name="msg" id="msg" placeholder="Write your msg here!"/>
			  <button type="button" onclick="sendText()">Send msg</button>

	  </div>
	  <script>

	  	var url = 'ws://localhost:8080';

	  	var conn = new WebSocket(url);
		conn.onopen = function(e) {
			document.getElementById('url').innerHTML= url;
		    console.log("Connection established!");
		};

		conn.onmessage = function(e) {
			var msg = JSON.parse(e.data);
			var ul = document.getElementById("friendsList");
			var li = document.createElement('li');
		    li.appendChild(document.createTextNode(msg.text));
		    ul.appendChild(li);
			
		};

		// Send text to all users through the server
		function sendText() {
		  // Construct a msg object containing the data the server needs to process the message from the chat client.
		  var msg = {
		    type: "message",
		    text: document.getElementById("msg").value,
		    date: Date.now()
		  };

		  // Send the msg object as a JSON-formatted string.
		  conn.send(JSON.stringify(msg));
		  
		  // Blank the text input element, ready to receive the next line of text from the user.
		  document.getElementById("msg").value = "";
		} 
	  	
	  </script>
  </body>
</html>