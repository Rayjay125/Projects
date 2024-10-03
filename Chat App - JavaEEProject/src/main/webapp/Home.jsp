<%-- 
    Document   : Home
    Created on : 26 Aug 2024, 16:50:40
    Author     : HP Pavilion 15
--%>

<%@page import="Beans.User"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <style>
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
            align-items: center;

            width: 300px;
            height: 600px;
        }
        
        .centralized-div{
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-bar {
            display: flex;
            flex-direction: column;
            align-items: center;

            width: 100%;
            height: 200px;
            margin-bottom: 50px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;

            background-color: blue;
            color: white;
        }

        .profile-picture {
            height: 70px;
            width: 60px;
            border-radius: 50%;
            margin-top: 40px;

            object-fit: cover;
        }

        .profile-bar-text {
            display: flex;
            flex-direction: column;
            align-items: center;

            height: 100px;
            margin-top: 20px;
        }

        .profile-bar-text p {
            margin: 2px;
        }

        .greeting-text {
            font-weight: bold;
            font-size: 15px;
        }

        .message-text {
            font-size: 13px;
        }

        .link-button {
            border-radius: 8px;
            border: solid 3px rgba(166, 166, 166, 0.266);
            height: 50px;
            width: 240px;
            margin-top: 20px;
            padding-left: 15px;

            background-color: white;
            text-align: left;
        }

        .link-button:hover {
            cursor: pointer;
        }

        #newChat {
            border: none;
            padding: 8px 16px;
            margin-top: 30px;
            border-radius: 20px;

            background-color: rgb(20, 180, 233);
            color: white;
            font-size: 12px;
        }

        #newChat:hover {
            cursor: pointer;
        }
    </style>

    <script>
        function toConversations(){
            location.assign('Conversations.html');
        }
        
        function toBeImplemented(){
            alert("To be implemented!");
        }
        
        function contactToChat(contact){
            var contactUsername = contact.name;
            var currentUser = document.getElementById('currentUser').value;
            const participants = [contactUsername, currentUser];
            
            participants = participants.sort();
            participants = participants.toString();
            
            document.getElementById("room").setAttribute("value", participants);
            document.getElementById("contactUsername").setAttribute("value", contactUsername);
        }
    </script>
    
    <form action="Chat2.jsp" method="Post">
        <input type="hidden" id="room">
        <input type="hidden" id="contactUsername">
    </form>
    
    <%
        User user = (User) session.getAttribute("currentUser");
    %>

    <div class="fullscreen">
        <div class="phone-screen">
            <div class="profile-bar">
                <img class="profile-picture" src="img/blank-profile-pic.jpg">
                <div class="profile-bar-text">
                    <p class="greeting-text">Hi, <%= user.getUsername() %></p>
                    <!-- <p> class="message-text">You have 3 new messages!</p> -->
                </div>
            </div>
            <div class="centralized-div">
                <button class="link-button" id="toConversations" name="toConversations" onclick="toConversations()">Conversations</button>
                <form action="HomeServlet" method="Get">
                    <button class="link-button" id="toContacts" name="toContacts">Contacts</button>
                </form>
                <button class="link-button" id="toMemories" name="toMemories" onclick="toBeImplemented()">Memories</button>
                <form action="HomeServlet" method="Get">
                    <button id="newChat" name="newChat">NEW CHAT</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
