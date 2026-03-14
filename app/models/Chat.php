<?php
class Chat {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getContacts($currentUserId){
        $this->db->query('
            SELECT 
                u.id,
                u.name,
                u.role,
                u.email,
                (
                    SELECT m.message
                    FROM chat_messages m
                    WHERE (m.sender_id = u.id AND m.receiver_id = :current_user_id)
                       OR (m.sender_id = :current_user_id AND m.receiver_id = u.id)
                    ORDER BY m.created_at DESC
                    LIMIT 1
                ) AS last_message
            FROM users u
            WHERE u.id != :current_user_id
            ORDER BY u.role, u.name
        ');
        $this->db->bind(':current_user_id', (int)$currentUserId);
        return $this->db->resultSet();
    }

    public function getConversation($currentUserId, $withUserId){
        $this->db->query('
            SELECT 
                m.*,
                sender.name AS sender_name
            FROM chat_messages m
            INNER JOIN users sender ON sender.id = m.sender_id
            WHERE 
                (m.sender_id = :current_user_id AND m.receiver_id = :with_user_id)
                OR
                (m.sender_id = :with_user_id AND m.receiver_id = :current_user_id)
            ORDER BY m.created_at ASC
        ');
        $this->db->bind(':current_user_id', (int)$currentUserId);
        $this->db->bind(':with_user_id', (int)$withUserId);
        return $this->db->resultSet();
    }

    public function sendMessage($senderId, $receiverId, $message){
        $this->db->query('
            INSERT INTO chat_messages (sender_id, receiver_id, message)
            VALUES (:sender_id, :receiver_id, :message)
        ');
        $this->db->bind(':sender_id', (int)$senderId);
        $this->db->bind(':receiver_id', (int)$receiverId);
        $this->db->bind(':message', $message);
        return $this->db->execute();
    }
}
