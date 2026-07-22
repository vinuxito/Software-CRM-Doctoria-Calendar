<?php
class Resource {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getResources(){
        $this->db->query('SELECT * FROM clinic_resources ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function addResource($data){
        $this->db->query('INSERT INTO clinic_resources (name, type, status) VALUES (:name, :type, :status)');
        $this->db->bind(':name', trim($data['name']));
        $this->db->bind(':type', $data['type'] ?? 'cubiculo');
        $this->db->bind(':status', $data['status'] ?? 'available');
        return $this->db->execute();
    }

    public function updateStatus($id, $status){
        $this->db->query('UPDATE clinic_resources SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', (int)$id);
        return $this->db->execute();
    }
}
