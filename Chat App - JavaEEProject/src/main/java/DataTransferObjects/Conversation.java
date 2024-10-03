/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package DataTransferObjects;

import java.util.ArrayList;
import java.util.List;
import DataTransferObjects.Message;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;
import java.io.Serializable;

/**
 *
 * @author HP Pavilion 15
 */
@Entity
@Table(name = "conversations")
public class Conversation implements Serializable{
    
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    
    private List<Message> conversation = new ArrayList<Message>();
    private String firstContact;
    private List<String> participants;
    private String room;
    
    //Constructors
    public Conversation(){
        
    }
    public Conversation(String room, String firstContact, List<String> participants){
        this.room = room;
        this.firstContact = firstContact;
        this.participants = participants;
    }
    
    
    // Getters and Setters
    public List<Message> getConversation() {
        return conversation;
    }

    public void setConversation(List<Message> conversation) {
        this.conversation = conversation;
    }

    public String getFirstContact() {
        return firstContact;
    }

    public void setFirstContact(String firstContact) {
        this.firstContact = firstContact;
    }

    public List<String> getParticipants() {
        return participants;
    }

    public void setParticipants(List<String> participants) {
        this.participants = participants;
    }

    public String getRoom() {
        return room;
    }

    public void setRoom(String room) {
        this.room = room;
    }
    
    
    // Other methods
    public void addMessage(Message message){
        conversation.add(message);
    }
    
    public void addParticipant(String contactUsername) {
        participants.add(contactUsername);
    }
}
