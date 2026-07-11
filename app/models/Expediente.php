<?php
class Expediente {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getOrCreateDraft($patientId) {
        $this->db->query('SELECT * FROM expedientes WHERE patient_id = :patient_id AND status = "draft" ORDER BY created_at DESC LIMIT 1');
        $this->db->bind(':patient_id', $patientId);
        $draft = $this->db->single();

        if ($draft) {
            return $draft;
        }

        // Create new draft
        $this->db->query('INSERT INTO expedientes (patient_id, status) VALUES (:patient_id, "draft")');
        $this->db->bind(':patient_id', $patientId);
        if ($this->db->execute()) {
            $this->db->query('SELECT * FROM expedientes WHERE patient_id = :patient_id AND status = "draft" ORDER BY created_at DESC LIMIT 1');
            $this->db->bind(':patient_id', $patientId);
            return $this->db->single();
        }
        return null;
    }
}
