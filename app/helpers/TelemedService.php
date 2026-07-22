<?php
class TelemedService {
    public static function generateRoomToken($appointmentId) {
        $raw = $appointmentId . '_' . microtime(true) . '_' . bin2hex(random_bytes(16));
        return hash('sha256', $raw);
    }

    public static function buildPatientJoinUrl($token) {
        return URLROOT . '/telemed/join/' . $token;
    }

    public static function buildWhatsAppMessage($patientName, $doctorName, $token) {
        $url = self::buildPatientJoinUrl($token);
        return "Hola " . $patientName . ", tu videoconsulta con " . $doctorName . " está lista. Únete aquí: " . $url;
    }

    public static function validateRoomToken($token) {
        $cleanToken = preg_replace('/[^a-f0-9]/', '', strtolower(trim((string)$token)));
        if (strlen($cleanToken) !== 64) {
            return false;
        }
        return true;
    }
}
