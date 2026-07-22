<?php
class Invoice {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getFiscalProfile($patientId){
        $this->db->query('SELECT * FROM patient_fiscal_profiles WHERE patient_id = :patient_id');
        $this->db->bind(':patient_id', (int)$patientId);
        return $this->db->single();
    }

    public function saveFiscalProfile($data){
        $existing = $this->getFiscalProfile($data['patient_id']);
        if ($existing) {
            $this->db->query('UPDATE patient_fiscal_profiles SET 
                rfc = :rfc, 
                razon_social = :razon_social, 
                codigo_postal = :codigo_postal, 
                regimen_fiscal = :regimen_fiscal, 
                uso_cfdi = :uso_cfdi, 
                email_cfdi = :email_cfdi 
                WHERE patient_id = :patient_id');
        } else {
            $this->db->query('INSERT INTO patient_fiscal_profiles 
                (patient_id, rfc, razon_social, codigo_postal, regimen_fiscal, uso_cfdi, email_cfdi) 
                VALUES 
                (:patient_id, :rfc, :razon_social, :codigo_postal, :regimen_fiscal, :uso_cfdi, :email_cfdi)');
        }
        $this->db->bind(':patient_id', (int)$data['patient_id']);
        $this->db->bind(':rfc', strtoupper(trim($data['rfc'])));
        $this->db->bind(':razon_social', trim($data['razon_social']));
        $this->db->bind(':codigo_postal', trim($data['codigo_postal']));
        $this->db->bind(':regimen_fiscal', $data['regimen_fiscal'] ?? '605');
        $this->db->bind(':uso_cfdi', $data['uso_cfdi'] ?? 'D01');
        $this->db->bind(':email_cfdi', trim($data['email_cfdi'] ?? ''));

        return $this->db->execute();
    }

    public function createInvoice($data){
        $this->db->query('SELECT MAX(folio) AS max_folio FROM cfdi_invoices');
        $row = $this->db->single();
        $nextFolio = ($row && $row->max_folio) ? ((int)$row->max_folio + 1) : 1001;

        $uuidSAT = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $this->db->query('INSERT INTO cfdi_invoices 
            (appointment_id, patient_id, folio_fiscal, serie, folio, subtotal, iva, total, status) 
            VALUES 
            (:appointment_id, :patient_id, :folio_fiscal, "F", :folio, :subtotal, :iva, :total, "stamped")');
        $this->db->bind(':appointment_id', isset($data['appointment_id']) ? (int)$data['appointment_id'] : null);
        $this->db->bind(':patient_id', (int)$data['patient_id']);
        $this->db->bind(':folio_fiscal', $uuidSAT);
        $this->db->bind(':folio', $nextFolio);
        $this->db->bind(':subtotal', (float)$data['subtotal']);
        $this->db->bind(':iva', (float)($data['iva'] ?? 0.00));
        $this->db->bind(':total', (float)$data['total']);

        if ($this->db->execute()) {
            return [
                'id' => $this->db->lastInsertId(),
                'folio' => $nextFolio,
                'uuid' => $uuidSAT
            ];
        }
        return false;
    }

    public function getInvoices(){
        $this->db->query('
            SELECT 
                i.*, 
                p.name AS patient_name,
                f.rfc,
                f.razon_social
            FROM cfdi_invoices i
            LEFT JOIN users p ON p.id = i.patient_id
            LEFT JOIN patient_fiscal_profiles f ON f.patient_id = i.patient_id
            ORDER BY i.created_at DESC
        ');
        return $this->db->resultSet();
    }
}
