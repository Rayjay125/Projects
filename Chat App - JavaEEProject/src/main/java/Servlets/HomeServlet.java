package Servlets;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/Servlet.java to edit this template
 */

import Beans.*;
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
import java.util.Comparator;
import java.util.List;

/**
 *
 * @author HP Pavilion 15
 */
@WebServlet(urlPatterns = {"/HomeServlet"})
public class HomeServlet extends HttpServlet {
    @EJB
    private UserDao dao;
    
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        
        /* 
        
        
            THIS SERVLET DISPLAYS CONTACTS FROM THE HOME PAGE
        
        
        */

        
        // Using PrintWriter to generate the contact page from the home page
        PrintWriter out = response.getWriter();
        
        out.println("<!DOCTYPE html>");
        out.println("<html lang=\"en\">");
        out.println("<head>");
        out.println("<title>Contacts</title>");
        
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
        out.println("function contactToChat(contact) {");
        out.println("    var contactUsername = contact.name;");
        out.println("    var currentUser = document.getElementById('currentUser').value;");
        out.println("    var participants = [contactUsername, currentUser];");
        out.println("    participants.sort();");
        out.println("    var participantsStr = participants.join(',');");
        out.println("    document.getElementById('room').setAttribute('value', participantsStr);");
        out.println("    document.getElementById('contactUsername').setAttribute('value', contactUsername);");
        out.println("    document.getElementById('hiddenForm').submit();");
        out.println("}");
        out.println("</script>");

        out.println("<div class=\"fullscreen\">");
        out.println("    <div class=\"phone-screen\">");
        out.println("       <h2>Your contacts</h2>");
        out.println("        <div class=\"centralized-div\">");
        
        //Submit hiddenForm to chat servlet to conditionally create a new conversation
        out.println("           <form id=\"hiddenForm\" action=\"ChatServlet\" method=\"Get\">");
        out.println("               <input type=\"hidden\" id=\"room\" name=\"room\">");
        out.println("               <input type=\"hidden\" id=\"contactUsername\" name=\"contactUsername\">");
        out.println("           </form>");
        
        // Print contacts
        HttpSession session = request.getSession();
        User currentUser = (User) session.getAttribute("currentUser");
        if (currentUser != null) {
            out.println("           <input type=\"hidden\" id=\"currentUser\" value=\"" + currentUser.getUsername() + "\">");
        } else {
            out.println("           <p>Error: No current user found.</p>");
        }

        List<User> userList = dao.getAllUsers();
        if (userList == null) {
            userList = new ArrayList<User>();
        }
        if (!userList.isEmpty()) {
            for (User user : userList) {
                if (user.getUsername() != currentUser.getUsername()){
                    out.println("   <button class=\"link-button\" id=\"user_" + user.getId() + "\" name=\"" + user.getUsername() + "\" onclick=\"contactToChat(this)\">");
                    out.println("    " + user.getUsername());
                    out.println("   </button>");
                    //out.println("   <p>current user: " + currentUser.getUsername() + "</p>");  //FOR TROUBLESHOOTING
                }
            }
        } else {
            out.println("   <p><center>No contacts yet!</center></p>");
            out.println("   <p><center>Create new users to have more contacts!</center></p>");
        }

        out.println("        </div>");
        out.println("    </div>");
        out.println("</div>");

        out.println("</body>");
        out.println("</html>");

        // Close the PrintWriter
        out.close();
    }


}
