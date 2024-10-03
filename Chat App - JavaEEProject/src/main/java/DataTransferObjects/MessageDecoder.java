package DataTransferObjects;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */


import jakarta.ejb.EJB;
import jakarta.json.Json;
import jakarta.json.JsonObject;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;
import jakarta.websocket.DecodeException;
import jakarta.websocket.Decoder;
import jakarta.websocket.EndpointConfig;
import java.io.StringReader;

/**
 *
 * @author aadik
 */
public class MessageDecoder implements Decoder.Text<Message> {
    @EJB
    private MessageAndConversationDao dao;
    
    @Override
    public void init(final EndpointConfig config) {
        // Initialization logic
    }

    @Override
    public void destroy() {
        // Destruction logic
    }
    
    @Override
    public Message decode(final String textMessage) throws DecodeException {
        Message chatMessage = new Message();
        JsonObject obj = Json.createReader(new StringReader(textMessage)).readObject();
        chatMessage.setContent(obj.getString("message"));
        chatMessage.setUsername(obj.getString("sender"));
        chatMessage.setTime(obj.getString("time"));
        chatMessage.setDate(obj.getString("date"));
        chatMessage.setRoom(obj.getString("room"));
        
        try {
            dao.storeMessage(chatMessage);
        } catch (Exception e) {
            e.printStackTrace();
        }
        
        return chatMessage;
    }

    @Override
    public boolean willDecode(final String s) {
        return (s != null);
    }
}
