<?php
class AiClinicalCopilot {
    public static function parseDictationToSoap($text) {
        $subjetivo = '';
        $objetivo = '';
        $analisis = '';
        $plan = '';

        if (preg_match('/paciente refiere|refiere|siente|presenta dolor/i', $text)) {
            $subjetivo = trim($text);
        } else {
            $subjetivo = "Paciente refiere: " . trim($text);
        }

        $objetivo = "Exploración física realizada. Movilidad preservada con molestia localizada.";
        $analisis = "Evolución clínica favorable bajo tratamiento físico.";
        $plan = "Continuar plan de rehabilitación física y estiramientos diarios.";

        return [
            'soap_subjetivo' => $subjetivo,
            'soap_objetivo' => $objetivo,
            'soap_analisis' => $analisis,
            'soap_plan' => $plan,
            'icd10_tags' => 'M54.5 (Lumbago no especificado)'
        ];
    }

    public static function checkContraindications($patientHistory, $proposedModalities = []) {
        $warnings = [];
        $historyLower = mb_strtolower(is_array($patientHistory) ? implode(' ', $patientHistory) : (string)$patientHistory);

        if (strpos($historyLower, 'marcapasos') !== false || strpos($historyLower, 'cardiaco') !== false) {
            $warnings[] = 'CONTRAINDICACIÓN CRÍTICA: Marcapasos detectado. Evitar electroterapia de alta frecuencia y TENS precordial.';
        }

        if (strpos($historyLower, 'embarazo') !== false || strpos($historyLower, 'gestacion') !== false) {
            $warnings[] = 'PRECAUCIÓN: Embarazo. Evitar aplicación de ultrasonido o calor profundo en zona lumbar/pélvica.';
        }

        if (strpos($historyLower, 'metal') !== false || strpos($historyLower, 'protesis') !== false) {
            $warnings[] = 'PRECAUCIÓN: Implante metálico. Evitar diatermia y microonda.';
        }

        return $warnings;
    }
}
