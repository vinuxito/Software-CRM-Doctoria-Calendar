<?php
class Clinic {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getClinics(){
        $this->db->query('SELECT * FROM clinics ORDER BY id ASC');
        return $this->db->resultSet();
    }

    public function getClinicById($id){
        $this->db->query('SELECT * FROM clinics WHERE id = :id');
        $this->db->bind(':id', (int)$id);
        return $this->db->single();
    }

    public function addClinic($data){
        $this->db->query('INSERT INTO clinics (name, code, address, phone) VALUES (:name, :code, :address, :phone)');
        $this->db->bind(':name', trim($data['name']));
        $this->db->bind(':code', strtoupper(trim($data['code'])));
        $this->db->bind(':address', trim($data['address'] ?? ''));
        $this->db->bind(':phone', trim($data['phone'] ?? ''));
        return $this->db->execute();
    }
}
