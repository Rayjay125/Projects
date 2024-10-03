package Servlets;

import DataTransferObjects.*;
import jakarta.ejb.EJB;
import java.io.IOException;
import java.util.logging.Level;
import java.util.logging.Logger;

import jakarta.websocket.EncodeException;
import jakarta.websocket.OnMessage;
import jakarta.websocket.OnOpen;
import jakarta.websocket.Session;
import jakarta.websocket.server.PathParam;
import jakarta.websocket.server.ServerEndpoint;

@ServerEndpoint(value = "/chat/{room}", encoders = MessageEncoder.class, decoders = MessageDecoder.class)
public class ChatEndpoint {
    private final Logger log = Logger.getLogger(getClass().getName());

    @OnOpen
    public void open(final Session session, @PathParam("room") final String room) {
        log.log(Level.INFO, "Session opened and bound to room: {}", room);
        session.getUserProperties().put("room", room);
    }

    @OnMessage
    public void onMessage(final Session session, final Message chatMessage) throws IOException, EncodeException {
        String room = (String) session.getUserProperties().get("room");
        for (Session s : session.getOpenSessions()) {
            if (s.isOpen() && room.equals(s.getUserProperties().get("room"))) {
                s.getBasicRemote().sendObject(chatMessage);
            }
        }
    }
}
