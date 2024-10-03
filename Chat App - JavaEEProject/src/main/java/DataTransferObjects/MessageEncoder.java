package DataTransferObjects;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */


import jakarta.json.Json;
import jakarta.websocket.EncodeException;
import jakarta.websocket.Encoder;
import jakarta.websocket.EndpointConfig;
import java.math.BigDecimal;

public class MessageEncoder implements Encoder.Text<Message> {
    @Override
    public void init(final EndpointConfig config) {
        // Initialization logic
    }

    @Override
    public void destroy() {
        // Destruction logic
    }

    @Override
    public String encode(final Message chatMessage) throws EncodeException {
        return Json.createObjectBuilder()
                .add("message", chatMessage.getContent())
                .add("sender", chatMessage.getUsername())
                .add("time", chatMessage.getTime())
                .add("date", chatMessage.getDate())
                .add("room", chatMessage.getRoom())
                .build()
                .toString();
    }
}

