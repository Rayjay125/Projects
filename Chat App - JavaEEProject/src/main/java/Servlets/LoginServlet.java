package Servlets;



/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/Servlet.java to edit this template
 */


import java.io.IOException;
import java.io.PrintWriter;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import Beans.*;
import jakarta.ejb.EJB;



/**
 *
 * @author HP Pavilion 15
 */
@WebServlet(name = "LoginServlet", urlPatterns = {"/LoginServlet"})
public class LoginServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    @EJB
    private UserDao dao;
    
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        
        // Get username and password
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        
        // Writing HTML and Javascript content
        PrintWriter out = response.getWriter();
        
        out.println("<!DOCTYPE html>");
        out.println("<html>");
        out.println("<head>");
        out.println("<title>LoginServlet</title>");
        out.println("</head>");
        out.println("<body>");

        
        //Get user info from database using UserDao
        User user = new User();
        user = dao.loginUser(username, password);
        if (user == null){
            // User does not exist
            out.println("<script>alert('User does not exist!');</script>");
            out.println("<script>location.replace('Login.html');</script>"); // Redirect back to login page
            return;
        }
        
        String dbUsername = user.getUsername();
        String dbPassword = user.getPassword();
        
        
        // Compare login details with user details from database
        if (username.equals(dbUsername) && password.equals(dbPassword)) {
            // Successful login
            HttpSession session = request.getSession();
            session.setAttribute("currentUser", user);
            out.println("<script>alert('Login successful!');</script>");
            out.println("<script>location.replace('Home.jsp');</script>"); // Redirect to home page

        } else {
            // Failed login
            out.println("<script>alert('Invalid login details');</script>");
            out.println("<script>location.replace('Login.html');</script>"); // Redirect back to login page
        }
        
        out.println("</body>");
        out.println("</html>");

        // Close the PrintWriter
        out.close();

    }
 
}

