<?php
class Appointment {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAppointments(){
        $this->db->query('
            SELECT 
                a.*,
                doctor.name AS doctor_name,
                doctor.phone AS doctor_phone,
                patient.name AS patient_name,
                patient.phone AS patient_phone,
                creator.name AS created_by_name
            FROM appointments a
            LEFT JOIN users doctor ON doctor.id = a.doctor_id
            LEFT JOIN users patient ON patient.id = a.patient_id
            LEFT JOIN users creator ON creator.id = a.created_by
            ORDER BY a.start_date ASC
        ');
        return $this->db->resultSet();
    }

    public function getAppointmentsForUser($userId, $role){
        if($role === 'admin'){
            return $this->getAppointments();
        }

        if($role === 'medico'){
            $this->db->query('
                SELECT 
                    a.*,
                    doctor.name AS doctor_name,
                    doctor.phone AS doctor_phone,
                    patient.name AS patient_name,
                    patient.phone AS patient_phone,
                    creator.name AS created_by_name
                FROM appointments a
                LEFT JOIN users doctor ON doctor.id = a.doctor_id
                LEFT JOIN users patient ON patient.id = a.patient_id
                LEFT JOIN users creator ON creator.id = a.created_by
                WHERE a.doctor_id = :user_id OR a.created_by = :user_id
                ORDER BY a.start_date ASC
            ');
            $this->db->bind(':user_id', $userId);
            return $this->db->resultSet();
        }

        $this->db->query('
            SELECT 
                a.*,
                doctor.name AS doctor_name,
                doctor.phone AS doctor_phone,
                patient.name AS patient_name,
                patient.phone AS patient_phone,
                creator.name AS created_by_name
            FROM appointments a
            LEFT JOIN users doctor ON doctor.id = a.doctor_id
            LEFT JOIN users patient ON patient.id = a.patient_id
            LEFT JOIN users creator ON creator.id = a.created_by
            WHERE a.patient_id = :user_id OR a.created_by = :user_id
            ORDER BY a.start_date ASC
        ');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function addAppointment($data){
        $this->db->query('
            INSERT INTO appointments 
            (user_id, title, doctor_id, patient_id, created_by, start_date, end_date, contact_phone, description, status, source_channel) 
            VALUES
            (:user_id, :title, :doctor_id, :patient_id, :created_by, :start_date, :end_date, :contact_phone, :description, :status, :source_channel)
        ');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':created_by', $data['created_by']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':end_date', $data['end_date']);
        $this->db->bind(':contact_phone', $data['contact_phone']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':source_channel', $data['source_channel']);

        return $this->db->execute();
    }

    public function updateStatus($appointmentId, $status){
        $this->db->query('UPDATE appointments SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', (int)$appointmentId);
        return $this->db->execute();
    }

    public function updateAppointment($data){
        $this->db->query('
            UPDATE appointments SET
                title = :title,
                doctor_id = :doctor_id,
                patient_id = :patient_id,
                user_id = :user_id,
                start_date = :start_date,
                end_date = :end_date,
                contact_phone = :contact_phone,
                description = :description,
                status = :status
            WHERE id = :id
        ');
        $this->db->bind(':id', (int)$data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':doctor_id', (int)$data['doctor_id']);
        $this->db->bind(':patient_id', (int)$data['patient_id']);
        $this->db->bind(':user_id', (int)$data['patient_id']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':end_date', $data['end_date']);
        $this->db->bind(':contact_phone', $data['contact_phone']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']);
        return $this->db->execute();
    }

    public function deleteAppointment($id){
        $this->db->query('DELETE FROM appointments WHERE id = :id');
        $this->db->bind(':id', (int)$id);
        return $this->db->execute();
    }

    public function getPendingAppointments(){
        $this->db->query('
            SELECT 
                a.*,
                doctor.name AS doctor_name,
                doctor.phone AS doctor_phone,
                patient.name AS patient_name,
                patient.phone AS patient_phone
            FROM appointments a
            LEFT JOIN users doctor ON doctor.id = a.doctor_id
            LEFT JOIN users patient ON patient.id = a.patient_id
            WHERE a.status = "pending"
            ORDER BY a.start_date ASC
        ');
        return $this->db->resultSet();
    }

    public function getRejectedAppointments(){
        $this->db->query('
            SELECT 
                a.*,
                doctor.name AS doctor_name,
                doctor.phone AS doctor_phone,
                patient.name AS patient_name,
                patient.phone AS patient_phone
            FROM appointments a
            LEFT JOIN users doctor ON doctor.id = a.doctor_id
            LEFT JOIN users patient ON patient.id = a.patient_id
            WHERE a.status = "rejected"
            ORDER BY a.start_date DESC
        ');
        return $this->db->resultSet();
    }

    public function getReportByMonth($year){
        $this->db->query('
            SELECT 
                MONTH(start_date) AS month_num,
                COUNT(*) AS total,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) AS approved,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) AS pending
            FROM appointments
            WHERE YEAR(start_date) = :year
            GROUP BY MONTH(start_date)
            ORDER BY MONTH(start_date)
        ');
        $this->db->bind(':year', (int)$year);
        return $this->db->resultSet();
    }

    public function getSummaryCounts(){
        $this->db->query('
            SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) AS approved,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) AS rejected
            FROM appointments
        ');
        return $this->db->single();
    }
}
