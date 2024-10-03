package Servlets;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/Servlet.java to edit this template
 */

import Beans.User;
import DataTransferObjects.Conversation;
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
@WebServlet(urlPatterns = {"/ConversationsServlet"})
public class ConversationsServlet extends HttpServlet {
    @EJB
    private MessageAndConversationDao dao;
    
    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        
        /* 
        
        
            THIS SERVLET DISPLAYS ONGOING CONVERSATIONS
        
        
        */
        
        
        PrintWriter out = response.getWriter();

        /* TODO output your page here. You may use following sample code. */
        out.println("<!DOCTYPE html>");
        out.println("<html lang=\"en\">");
        out.println("<head>");
        out.println("<title>Conversations</title>");
        
        out.println("<style>");
        out.println("html, body {");
        out.println("    margin: 0;");
        out.println("    height: 100%;");
        out.println("}");

        out.println(".fullscreen {");
        out.println("    display: flex;");
        out.println("    justify-content: center;");
        out.println("    align-items: center;");
        out.println("    height: 100%;");
        out.println("    width: 100%;");
        out.println("    background-color: rgb(250, 250, 250);");
        out.println("    font-family: Arial, Helvetica, sans-serif;");
        out.println("}");

        out.println(".phone-screen {");
        out.println("    display: flex;");
        out.println("    flex-direction: column;");
        out.println("    align-items: center;");
        out.println("    width: 300px;");
        out.println("    height: 600px;");
        out.println("}");
        
        out.println(".phone-screen h2{");
        out.println("    color: red;");
        out.println("    margin-bottom: 30px;");
        out.println("    font-size: 18px;");
        out.println("}");
        
        out.println(".centralized-div {");
        out.println("    display: flex;");
        out.println("    flex-direction: column;");
        out.println("    align-items: center;");
        out.println("}");

        out.println(".links-form {");
        out.println("    display: flex;");
        out.println("    flex-direction: column;");
        out.println("    align-items: center;");
        out.println("    justify-content: center;");
        out.println("}");

        out.println(".link-button {");
        out.println("    border-radius: 8px;");
        out.println("    border: solid 3px rgba(166, 166, 166, 0.266);");
        out.println("    height: 50px;");
        out.println("    width: 240px;");
        out.println("    margin-top: 20px;");
        out.println("    padding-left: 15px;");
        out.println("    background-color: white;");
        out.println("    text-align: left;");
        out.println("}");

        out.println(".link-button:hover {");
        out.println("    cursor: pointer;");
        out.println("}");
        out.println("</style>");
        out.println("</head>");
        out.println("<body>");
        
        out.println("<script>");
        out.println("function toChat(contact) {");
        out.println("    document.getElementById('room').setAttribute('value', contact.id);");
        out.println("    document.getElementById('contactUsername').setAttribute('value', contact.name);");
        out.println("    document.getElementById('hiddenForm').submit();");
        out.println("}");
        out.println("</script>");

        out.println("<div class=\"fullscreen\">");
        out.println("    <div class=\"phone-screen\">");
        out.println("       <h2>Your conversations</h2>");
        out.println("        <div class=\"centralized-div\">");
        out.println("           <form id=\"hiddenForm\" action=\"ChatServlet\" method=\"Get\">");
        out.println("               <input type=\"hidden\" id=\"room\" name=\"room\">");
        out.println("               <input type=\"hidden\" id=\"contactUsername\" name=\"contactUsername\">");
        out.println("           </form>");

        // Prevent database errors by checking if user is logged in
        HttpSession session = request.getSession();
        User currentUser = (User) session.getAttribute("currentUser");
        if (currentUser == null) {
            out.println("           <script>alert(\"Please login to continue\");</script>");
            response.sendRedirect("Login.html");
        }

        // Get and display conversations
        List<Conversation> allConversations = dao.getAllConversations();
        if (allConversations == null) {
            allConversations = new ArrayList<Conversation>();
        }
        if (!allConversations.isEmpty()) {
            Boolean anyConversations = false;
            for (Conversation conversation : allConversations) {
                List<String> participants = conversation.getParticipants();
                
                // Get contact's name
                String contactUsername = "";
                for (String s: participants){
                    if (!s.equals(currentUser.getUsername())){
                        contactUsername = s;
                    }
                }
                if (participants.contains(currentUser.getUsername())){
                    anyConversations = true;
                    out.println("   <button class=\"link-button\" id=\"" + conversation.getRoom() + "\" name=\"" + contactUsername + "\" onclick=\"toChat(this)\">");
                    out.println("    " + contactUsername);
                    out.println("   </button>");
                }
            }
            if (anyConversations == false){
                out.println("       <p><center>No converstations yet!</center></p>");
            }
        } else {
            out.println("       <p><center>No converstations yet!</center></p>");
        }
        
        //Remaining HTML
        out.println("        </div>");
        out.println("    </div>");
        out.println("</div>");

        out.println("</body>");
        out.println("</html>");

        // Close the PrintWriter
        out.close();
        
    }

}
