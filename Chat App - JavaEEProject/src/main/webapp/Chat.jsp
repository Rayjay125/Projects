<%@page import="java.time.LocalDate"%>
<%@page import="java.time.format.DateTimeFormatter"%>
<%@page import="java.util.ArrayList"%>
<%@page import="java.util.List"%>
<%@page import="Beans.User"%>
<%@page import="DataTransferObjects.Message"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chat Application</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            .received { font-weight: bold; }
            .user { background-color: #337ab7; color: white; padding: 5px; }
            .message { background-color: #f7f7f7; padding: 5px; }
            
            html, body {
                margin: 0;
                height: 100%;
            }

            button:hover {
                cursor: pointer;
            }

            .fullscreen {
                display: flex;
                justify-content: center;
                align-items: center;

                height: 100%;
                width: 100%;

                background-color: rgb(250, 250, 250);
                font-family: Arial, Helvetica, sans-serif;
            }

            .phone-screen {
                display: flex;
                flex-direction: column;
                align-items: left;

                position: relative;
                width: 300px;
                height: 600px;
            }

            /* --- Chat --- */
            .goHome {
                border: none;
                background-color: rgb(250, 250, 250);
                text-decoration: underline;
            }
            .room-name {
                margin-left: 4px;
                color: rgb(68, 180, 217);
                text-align: left;
                font-size: 16px;
            }

            .chat-container {
                height: 490px;
                max-height: 490px;
                width: 100%;
                overflow-y: scroll;
            }

            .message-container {
                display: flex;
                flex-direction: row;
                margin-top: 20px;
            }

            .contact-profile-picture-div,
            .user-profile-picture-div {
                display: flex;
                flex-direction: row;
                align-items: end;
                justify-content: center;

                width: 17%;
            }

            .contact-profile-picture,
            .user-profile-picture {
                width: 40px;
                height: 40px;
                border-radius: 50%;

                object-fit: cover;
            }

            .contact-message-body,
            .user-message-body {
                width: 70%;
                min-height: 50px;
                position: relative;
            }

            .user-message,
            .contact-message {
                position: relative;
                z-index: 120;
                border-radius: 10px;
                margin: 0 0 25px 0;
                padding: 7px;

                font-size: 13px;
            }

            .user-message-time,
            .contact-message-time{
                margin: 0;
                position: absolute;
                bottom: 0;

                font-size: 14px;
            }

            /* User only */
            .user-message-body {
                margin-right: 13%;
            }

            .user-message {
                background-color: blue;
                color: white;
                padding: 10px;
                min-height: 15px;
            }

            .user-message-time{
                right: 0;
                color: grey;
            }

            /* Contact only */
            .contact-message-body {
                margin-left: 13%;
            }

            .contact-message {
                background-color: rgb(220, 220, 220);
                padding: 10px;
                min-height: 15px;
            }

            .contact-message-time{
                left: 0;
                color: grey;
            }

            /* Speech bubbles */

            .user-speech-bubble1,
            .contact-speech-bubble1 {
                display: flex;

                z-index: 100;
                position: absolute;
                bottom: 15px;

                height: 40px;
                width: 40px;
            }

            .user-speech-bubble2,
            .contact-speech-bubble2 {
                z-index: 101;
                height: 30px;
                width: 20px;
                background-color: rgb(250, 250, 250);
            }

            .user-speech-bubble1 {
                align-items: end;
                justify-content: start;
                left: 0;
                border-bottom-right-radius: 70%;
                border-top-left-radius: 100%;
                background-color: blue;
            }

            .user-speech-bubble2 {
                border-bottom-right-radius: 100%;
            }

            .contact-speech-bubble1 {
                align-items: end;
                justify-content: end;
                right: 0;
                border-bottom-left-radius: 70%;
                border-top-right-radius: 100%;
                background-color: rgb(220, 220, 220);
            }

            .contact-speech-bubble2 {
                border-bottom-left-radius: 100%;
            }

            /* new message */

            .new-message-container {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-around;

                box-shadow: 0.5px -0.5px 5px 1px rgba(0,0,0,0.15);
                width: 100%;
                height: 60px;
                margin-top: 10px;

                background-color: white;
            }

            .new-message {
                width: 230px;
                height: 35px;
                border: solid 1px grey;
                border-radius: 20px;
                padding-left: 15px;

                text-align: left;
                color: black;
            }

            #sendMessage {
                border-radius: 19px;
                border: solid 1px grey;
                width: 45px;
                height: 38px;
                background-color: lightblue;
                color: rgb(80, 80, 80);
                font-size: 10px;
            }

            #sendMessage:hover {
                cursor: pointer;
            }
        </style>

    </head>

    <body>
        <script>
            var ws;
            var serviceLocation = "ws://localhost:8080/JavaEEProject/chat/";
            var $username;
            var $message;
            
            
            function getCurrentTime() {
                var now = new Date();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';

                hours = hours % 12;
                hours = hours ? hours : 12; // midnight is '12'
                minutes = minutes < 10 ? '0' + minutes : minutes;

                var currentTime = hours + ':' + minutes + ' ' + ampm;
                return currentTime;
            }
            
            function getCurrentDate(){
                var today = new Date();
                var day = today.getDate();
                var month = today.getMonth() + 1; // Add 1 because months are zero-based
                var year = today.getFullYear();

                var currentDate = day + '/' + month + '/' + year;
                return currentDate;
            }

            function onMessageReceived(evt) {
                var msg = JSON.parse(evt.data);
                var messageLine;
                var chatContainer = document.getElementById('chatContainer');

                if (msg.sender === document.getElementById('username').value) {
                    messageLine = `
                        <div class="message-container">
                            <div class="user-profile-picture-div">
                                <img class="user-profile-picture" src="img/blank-profile-pic.jpg">
                            </div>
                            <div class="user-message-body">
                                <p class="user-message">` + msg.message + `</p>
                                <div class="user-speech-bubble1">
                                    <div class="user-speech-bubble2"></div>
                                </div>
                                <p class="user-message-time">` + getCurrentTime() + `</p>
                            </div>
                        </div>
                    `;
                } else {
                    messageLine = `
                        <div class="message-container">
                            <div class="contact-message-body">
                                <p class="contact-message">` + msg.message + `</p>
                                <div class="contact-speech-bubble1">
                                    <div class="contact-speech-bubble2"></div>
                                </div>
                                <p class="contact-message-time">` + getCurrentTime() + `</p>
                            </div>
                            <div class="contact-profile-picture-div">
                                <img class="contact-profile-picture" src="img/blank-profile-pic.jpg">
                            </div>
                        </div>
                    `;
                }

                chatContainer.insertAdjacentHTML('beforeend', messageLine);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
            
            function sendMessage() {
                // Don't send empty messages
                if ($message.val() != ""){
                    var msg = '{"message":"' + $message.val() + '", "sender":"' + $username.val() + '", "time":"' + getCurrentTime() + '", "date":"' + getCurrentDate() + '", "room":"' + document.getElementById("room").value + '", "received":""}';
                    ws.send(msg);
                    $message.val('').focus();
                } else {
                    alert("Type a message");
                }
            }

            function connectToChatserver() {
                room = document.getElementById("room").value;
                ws = new WebSocket(serviceLocation + room);
                ws.onmessage = onMessageReceived;
            }
            
            function leaveChat() {
                //ws.close();
                location.assign("Home.jsp");
            }

            $(document).ready(function() {
                $username = $('#username');
                $message = $('#messageInput');
                
                connectToChatserver();
                $message.focus();

                $('#do-chat').submit(function(evt) {
                    evt.preventDefault();
                    sendMessage();
                });
            });
            
            
            function clickSend(event) {
                if (event.key === "Enter") {
                    document.getElementById('sendMessage').click();
                }
            }
        </script>
        
        
        <% 
            // Conditionally prompt user to login
            User user = new User();
            String currentUser = "";
            try {
                user = (User) session.getAttribute("currentUser");
                currentUser = user.getUsername();
            } catch (Exception e) {
        %>
                <script>
                    alert("Please login to continue");
                    location.replace("Login.html");
                </script>
        <%
            }

            //Get contact's username
            List<String> participants = (List<String>) request.getAttribute("participants");
            String contactUsername = "";
            for (String s: participants){
                if (!s.equals(currentUser)){
                    contactUsername = s;
                }
            }
        %>
        
        
        <input type="hidden" id="username" value="<%= currentUser %>">
        <input type="hidden" id="room" value="<%= request.getParameter("room")%>">
        <div class="fullscreen">
            <div class="phone-screen">
                <button class="goHome" onclick="leaveChat()">Home</button>
                <h2 class="room-name"><center><%= contactUsername %></center></h2>
                <div class="chat-container" id="chatContainer">
                    <%
                        // If conversation exists, load previous messages
                        List<Message> oldMessages;
                        oldMessages = (List<Message>) request.getAttribute("oldMessages");
                        try{
                            if (oldMessages.isEmpty()){
                                oldMessages = new ArrayList<>();
                            } else {

                                // Printing the date
                                String date = "";
                                for (Message message: oldMessages) {
                                    // For oldest stored message
                                    if(date == ""){
                                        date = message.getDate();
                                        %> 
                                            <p><center> <%= date %> </center></p>
                                        <%

                                    // For subsequent messages
                                    } else {
                                        String newDate = message.getDate();
                                        if (!newDate.equals(date)){
                                            date = newDate;
                                            %> 
                                                <p><center> <%= date %> </center></p>
                                            <%
                                        }
                                    }

                                    // Printing user's message
                                    if (currentUser.equals(message.getUsername())){       
                        %>
                                        <div class="message-container">
                                            <div class="user-profile-picture-div">
                                                <img class="user-profile-picture" src="img/blank-profile-pic.jpg">
                                            </div>
                                            <div class="user-message-body">
                                                <p class="user-message"><%= message.getContent() %></p>
                                                <div class="user-speech-bubble1">
                                                    <div class="user-speech-bubble2"></div>
                                                </div>
                                                <p class="user-message-time"><%= message.getTime() %></p>
                                            </div>
                                        </div>
                        <%
                                    // Printing contact's message
                                    } else {
                        %>
                                        <div class="message-container">
                                            <div class="contact-message-body">
                                                <p class="contact-message"><%= message.getContent() %></p>
                                                <div class="contact-speech-bubble1">
                                                    <div class="contact-speech-bubble2"></div>
                                                </div>
                                                <p class="contact-message-time"><%= message.getTime() %></p>
                                            </div>
                                            <div class="contact-profile-picture-div">
                                                <img class="contact-profile-picture" src="img/blank-profile-pic.jpg">
                                            </div>
                                        </div>
                        <%
                                    }
                                }
                            }
                        }catch (Exception e){
                            e.printStackTrace();
                        }
                        
                    %>
                </div>
                <div class="new-message-container">
                    <input class="new-message" type="text" placeholder="Type a message..." id="messageInput" name="messageInput" onkeypress="clickSend(event)">
                    <button id="sendMessage" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </body>
</html>
