<?php
class Payment {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getTransactions($clinicId = 1){
        $this->db->query('
            SELECT 
                t.*,
                p.name AS patient_name,
                d.name AS doctor_name
            FROM financial_transactions t
            LEFT JOIN users p ON p.id = t.patient_id
            LEFT JOIN users d ON d.id = t.doctor_id
            ORDER BY t.created_at DESC
        ');
        return $this->db->resultSet();
    }

    public function recordTransaction($data){
        $amount = max(0.0, (float)($data['amount'] ?? 0));
        $rawCommissionRate = isset($data['commission_rate']) ? (float)$data['commission_rate'] : 50.0;
        $commissionRate = max(0.0, min(100.0, $rawCommissionRate));
        
        $doctorCommission = round($amount * ($commissionRate / 100.0), 2);
        $clinicNet = round($amount - $doctorCommission, 2);

        $this->db->query('
            INSERT INTO financial_transactions 
            (appointment_id, patient_id, doctor_id, amount, doctor_commission_amount, clinic_net_amount, payment_method, payment_status, transaction_ref)
            VALUES
            (:appointment_id, :patient_id, :doctor_id, :amount, :doctor_commission_amount, :clinic_net_amount, :payment_method, :payment_status, :transaction_ref)
        ');
        $this->db->bind(':appointment_id', !empty($data['appointment_id']) ? (int)$data['appointment_id'] : null);
        $this->db->bind(':patient_id', (int)$data['patient_id']);
        $this->db->bind(':doctor_id', (int)$data['doctor_id']);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':doctor_commission_amount', $doctorCommission);
        $this->db->bind(':clinic_net_amount', $clinicNet);
        $this->db->bind(':payment_method', $data['payment_method'] ?? 'cash');
        $this->db->bind(':payment_status', $data['payment_status'] ?? 'paid');
        $this->db->bind(':transaction_ref', $data['transaction_ref'] ?? null);

        return $this->db->execute();
    }

    public function getFinancialSummary(){
        $this->db->query('
            SELECT 
                SUM(amount) AS total_revenue,
                SUM(doctor_commission_amount) AS total_commissions,
                SUM(clinic_net_amount) AS total_net_income,
                COUNT(id) AS transaction_count
            FROM financial_transactions
            WHERE payment_status = "paid"
        ');
        return $this->db->single();
    }
}
