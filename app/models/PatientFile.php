<?php
class PatientFile {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getOrCreateFile($patientId){
        $this->db->query('SELECT * FROM patient_files WHERE patient_id = :patient_id');
        $this->db->bind(':patient_id', $patientId);
        $row = $this->db->single();

        if ($row) {
            return $row;
        }

        // Create default record if none exists
        $this->db->query('INSERT INTO patient_files (patient_id) VALUES (:patient_id)');
        $this->db->bind(':patient_id', $patientId);
        if ($this->db->execute()) {
            $this->db->query('SELECT * FROM patient_files WHERE patient_id = :patient_id');
            $this->db->bind(':patient_id', $patientId);
            return $this->db->single();
        }
        return null;
    }

    public function updateFile($data){
        $this->db->query('UPDATE patient_files SET 
            dob = :dob, 
            address = :address, 
            blood_type = :blood_type, 
            allergies = :allergies, 
            medical_history = :medical_history, 
            medications = :medications, 
            clinical_notes = :clinical_notes 
            WHERE patient_id = :patient_id');

        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':dob', !empty($data['dob']) ? $data['dob'] : null);
        $this->db->bind(':address', !empty($data['address']) ? $data['address'] : null);
        $this->db->bind(':blood_type', !empty($data['blood_type']) ? $data['blood_type'] : null);
        $this->db->bind(':allergies', !empty($data['allergies']) ? $data['allergies'] : null);
        $this->db->bind(':medical_history', !empty($data['medical_history']) ? $data['medical_history'] : null);
        $this->db->bind(':medications', !empty($data['medications']) ? $data['medications'] : null);
        $this->db->bind(':clinical_notes', !empty($data['clinical_notes']) ? $data['clinical_notes'] : null);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}
