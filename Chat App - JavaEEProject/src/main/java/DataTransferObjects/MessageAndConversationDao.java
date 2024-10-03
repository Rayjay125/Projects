/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/J2EE/EJB40/StatelessEjbClass.java to edit this template
 */
package DataTransferObjects;

import DataTransferObjects.Message;
import jakarta.ejb.Stateless;
import jakarta.ejb.LocalBean;
import jakarta.persistence.EntityManager;
import jakarta.persistence.PersistenceContext;
import jakarta.persistence.Query;
import java.util.List;

/**
 *
 * @author HP Pavilion 15
 */
@Stateless
@LocalBean
public class MessageAndConversationDao {
    @PersistenceContext(unitName = "UserPersistenceUnit")
    private EntityManager em;
    
    public void storeMessage(Message message){
        try {
            em.persist(message);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    
    public List<Message> getMessages(String room) {
        try {
            Query query = em.createQuery("SELECT m FROM Message m WHERE m.room = :room", Message.class);
            query.setParameter("room", room);
            return (List<Message>) query.getResultList();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }
    
    public void deleteAllMessages(){
        try{
            Query query = em.createQuery("DELETE FROM Messages m", Message.class);
            return;
        } catch (Exception e){
            e.printStackTrace();
        }
    }
    
    public void storeConversation(Conversation conversation){
        try {
            em.persist(conversation);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    
    public Conversation getConversation(String room) {
        try {
            Query query = em.createQuery("SELECT c FROM Conversation c WHERE c.room = :room", Conversation.class);
            query.setParameter("room", room);
            return (Conversation) query.getSingleResult();
        } catch (Exception e){
            e.printStackTrace();
        }
        return null;
    }
    
    public List<Conversation> getAllConversations() {
        try {
            Query query = em.createQuery("SELECT c FROM Conversation c", Conversation.class);
            return (List<Conversation>) query.getResultList();
        } catch (Exception e){
            e.printStackTrace();
        }
        return null;
    }
    
    public void deleteConversation(String room){
        try{
            // Delete all related messages first
            Query query = em.createQuery("DELETE FROM Message m WHERE m.room = :room", Message.class);
            query.setParameter("room", room);
            
            // Delete conversation
            Query query2 = em.createQuery("DELETE FROM Conversation c WHERE c.room = :room", Conversation.class);
            query.setParameter("room", room);
            return;
        } catch (Exception e){
            e.printStackTrace();
        }
    }
    
    public void deleteAllConversations(){
        try{
            deleteAllMessages();
            Query query = em.createQuery("DELETE FROM Conversation c", Conversation.class);
            return;
        } catch (Exception e){
            e.printStackTrace();
        }
    }
}
