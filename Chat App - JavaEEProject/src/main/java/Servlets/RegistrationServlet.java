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
@WebServlet(urlPatterns = {"/RegistrationServlet"})
public class RegistrationServlet extends HttpServlet {
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
        out.println("<title>RegistrationServlet</title>");
        out.println("</head>");
        out.println("<body>");
        
        
        User user;
        user = dao.loginUser(username, "");
        if (user != null) {
            out.println("<script>alert('Username already exists! Register with a different Username!');</script>");
            out.println("<script>location.replace('Registration.html');</script>"); // Reload page
            return;
        }
        
        user = new User();
        user.setUsername(username);
        user.setPassword(password);
        dao.registerUser(user);
        out.println("<script>alert('Registration was successful!');</script>");
        out.println("<script>location.replace('Login.html');</script>"); // Redirect back to home page
        
        out.println("</body>");
        out.println("</html>");

        // Close the PrintWriter
        out.close();
    }
}
