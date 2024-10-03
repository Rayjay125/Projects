/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Beans;

import jakarta.ejb.Stateless;
import jakarta.persistence.*;
import java.util.ArrayList;
import java.util.List;

@Stateless
public class UserDao {
    @PersistenceContext(unitName = "UserPersistenceUnit")
    
    private EntityManager em;
    
    public void registerUser(User user) {
        try {
            em.persist(user);
        } catch (Exception e){
            e.printStackTrace();
        }
    }

    public User loginUser(String username, String password) {
        try {
            Query query = em.createQuery("SELECT u FROM User u WHERE u.username = :username", User.class);
            query.setParameter("username", username);
            return (User) query.getSingleResult();
        } catch (NoResultException e) {
            return null;
        }
    }
    
    public List<User> getAllUsers() {
        try {
            Query query = em.createQuery("SELECT u FROM User u", User.class);
            return (List<User>) query.getResultList();
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
    
}

