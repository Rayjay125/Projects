/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/Servlet.java to edit this template
 */
package Servlets;

import Beans.User;
import DataTransferObjects.Conversation;
import DataTransferObjects.Message;
import DataTransferObjects.MessageAndConversationDao;
import jakarta.ejb.EJB;
import java.io.IOException;
import java.io.PrintWriter;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;
import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author HP Pavilion 15
 */
@WebServlet(name = "ChatServlet", urlPatterns = {"/ChatServlet"})
public class ChatServlet extends HttpServlet {
    @EJB
    private MessageAndConversationDao dao;
    
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        response.setContentType("text/html");
        
        /* 
        
        
            THIS SERVLET GETS INFORMATION FROM THE CONTACT PAGE AND CONDITIONALLY CREATES A NEW CONVERSATION
        
        
        */
        
        // Get information from request and conditionally create a new converstaion
        HttpSession session = request.getSession();
        User currUser = (User) session.getAttribute("currentUser");
        String currentUser = currUser.getUsername();
        
        String room = request.getParameter("room");
        String contactUsername = request.getParameter("contactUsername");
        
        
        Conversation conversation;
        // Ensure this servlet has been requested with a contact
        if (contactUsername != null){
            try{
                conversation = dao.getConversation(room);

                // If there is no existing conversation with the same participants
                if (conversation == null) {
                    try{
                        List<String> participants = new ArrayList<String>();
                        participants.add(currentUser);
                        participants.add(contactUsername);

                        conversation = new Conversation(room, contactUsername, participants);
                        dao.storeConversation(conversation);
                        
                        request.setAttribute("room", room);
                        request.setAttribute("participants", participants);
                        request.getRequestDispatcher("Chat.jsp").forward(request, response);
                    } catch (Exception e){
                        e.printStackTrace();
                    }
                    
                // If the conversation already exists
                } else {
                    List<Message> oldMessages = dao.getMessages(room);
                    request.setAttribute("oldMessages", oldMessages);
                    
                    request.setAttribute("room", room);
                    request.setAttribute("participants", conversation.getParticipants());
                    request.getRequestDispatcher("Chat.jsp").forward(request, response);
                }
            } catch (Exception e){
                e.printStackTrace();
            }
        }
        
    }

}
