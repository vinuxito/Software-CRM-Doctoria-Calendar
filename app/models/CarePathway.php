<?php
class CarePathway {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getPathways(){
        $this->db->query('SELECT * FROM care_pathways ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function addPathway($name, $conditionType, $durationDays = 14){
        $this->db->query('INSERT INTO care_pathways (name, condition_type, duration_days) VALUES (:name, :condition_type, :duration_days)');
        $this->db->bind(':name', trim($name));
        $this->db->bind(':condition_type', trim($conditionType));
        $this->db->bind(':duration_days', (int)$durationDays);
        return $this->db->execute();
    }

    public function assignPathwayToPatient($patientId, $pathwayId, $startDate = null){
        if(!$startDate) $startDate = date('Y-m-d');

        $this->db->query('INSERT INTO patient_prescriptions (patient_id, pathway_id, start_date, status) VALUES (:patient_id, :pathway_id, :start_date, "active")');
        $this->db->bind(':patient_id', (int)$patientId);
        $this->db->bind(':pathway_id', (int)$pathwayId);
        $this->db->bind(':start_date', $startDate);
        return $this->db->execute();
    }

    public function getPatientPrescriptions($patientId){
        $this->db->query('
            SELECT 
                p.*,
                cp.name AS pathway_name,
                cp.condition_type,
                cp.duration_days
            FROM patient_prescriptions p
            JOIN care_pathways cp ON cp.id = p.pathway_id
            WHERE p.patient_id = :patient_id
            ORDER BY p.created_at DESC
        ');
        $this->db->bind(':patient_id', (int)$patientId);
        return $this->db->resultSet();
    }
}
