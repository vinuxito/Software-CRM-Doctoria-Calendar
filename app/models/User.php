<?php
class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // Register User
    public function register($data){
        $this->db->query('INSERT INTO users (name, email, phone, password, role) VALUES(:name, :email, :phone, :password, :role)');
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Login User
    public function login($email, $password){
        $this->db->query('SELECT * FROM users WHERE email = :email AND is_deleted = 0');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($row){
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)){
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email AND is_deleted = 0');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    // Get User by ID
    public function getUserById($id){
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function getAllUsers(){
        $this->db->query('SELECT id, name, email, phone, role, created_at FROM users WHERE is_deleted = 0 ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getUsersByRole($role){
        $this->db->query('SELECT id, name, email, phone, role, created_at FROM users WHERE role = :role AND is_deleted = 0 ORDER BY created_at DESC');
        $this->db->bind(':role', $role);
        return $this->db->resultSet();
    }

    public function updateUser($data){
        if (!empty($data['password'])) {
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone, role = :role, password = :password WHERE id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone, role = :role WHERE id = :id');
        }
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':role', $data['role']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($id){
        $this->db->query('UPDATE users SET is_deleted = 1 WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email AND is_deleted = 0');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
}
