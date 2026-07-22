<?php
class WhatsAppService {
    public static function generateReminderUrl($phone, $patientName, $doctorName, $startDateTime, $token) {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (empty($cleanPhone)) {
            $cleanPhone = '5215500000000'; // Default fallback format
        }

        $formattedDate = date('d/m/Y', strtotime($startDateTime));
        $formattedTime = date('H:i', strtotime($startDateTime));

        $confirmUrl = URLROOT . '/dashboard/confirmAppointment/' . $token;

        $msg = "Hola {$patientName}, te saludamos de Doctoria CRM. Te recordamos tu cita de fisioterapia el {$formattedDate} a las {$formattedTime} con el {$doctorName}.\n\nPor favor confirma tu asistencia dando click aquí:\n{$confirmUrl}";

        return "https://wa.me/{$cleanPhone}?text=" . urlencode($msg);
    }
}
