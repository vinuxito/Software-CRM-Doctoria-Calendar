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

    public function loadExpedienteData($patientId) {
        $draft = $this->getOrCreateDraft($patientId);
        $expedienteId = $draft->id;

        // Fetch patient master data
        $this->db->query('SELECT id, name, email, phone, ocupacion, fecha_nacimiento, sexo, estado_civil, domicilio, tel, cel, familiar_responsable, familiar_tel, familiar_cel FROM users WHERE id = :id');
        $this->db->bind(':id', $patientId);
        $patient = $this->db->single();

        // Fetch antecedents
        $this->db->query('SELECT * FROM antecedentes WHERE expediente_id = :expediente_id');
        $this->db->bind(':expediente_id', $expedienteId);
        $antecedentes = $this->db->resultSet();

        // Fetch exploracion
        $this->db->query('SELECT * FROM exploraciones WHERE expediente_id = :expediente_id');
        $this->db->bind(':expediente_id', $expedienteId);
        $exploracion = $this->db->single();
        if (!$exploracion) {
            $this->db->query('INSERT INTO exploraciones (expediente_id) VALUES (:expediente_id)');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->execute();
            $this->db->query('SELECT * FROM exploraciones WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $exploracion = $this->db->single();
        }

        // Fetch cicatriz
        $this->db->query('SELECT * FROM cicatrices WHERE expediente_id = :expediente_id');
        $this->db->bind(':expediente_id', $expedienteId);
        $cicatriz = $this->db->single();
        if (!$cicatriz) {
            $this->db->query('INSERT INTO cicatrices (expediente_id) VALUES (:expediente_id)');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->execute();
            $this->db->query('SELECT * FROM cicatrices WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $cicatriz = $this->db->single();
        }

        // Fetch padecimiento
        $this->db->query('SELECT * FROM padecimientos WHERE expediente_id = :expediente_id');
        $this->db->bind(':expediente_id', $expedienteId);
        $padecimiento = $this->db->single();
        if (!$padecimiento) {
            $this->db->query('INSERT INTO padecimientos (expediente_id) VALUES (:expediente_id)');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->execute();
            $this->db->query('SELECT * FROM padecimientos WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $padecimiento = $this->db->single();
        }

        // Fetch problemas
        $this->db->query('SELECT * FROM problemas WHERE expediente_id = :expediente_id');
        $this->db->bind(':expediente_id', $expedienteId);
        $problemas = $this->db->resultSet();

        // Fetch plan_sesiones
        $this->db->query('SELECT * FROM plan_sesiones WHERE expediente_id = :expediente_id ORDER BY orden ASC');
        $this->db->bind(':expediente_id', $expedienteId);
        $plan_sesiones = $this->db->resultSet();

        // Fetch marcha
        $this->db->query('SELECT * FROM marchas WHERE expediente_id = :expediente_id');
        $this->db->bind(':expediente_id', $expedienteId);
        $marcha = $this->db->single();
        if (!$marcha) {
            $this->db->query('INSERT INTO marchas (expediente_id) VALUES (:expediente_id)');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->execute();
            $this->db->query('SELECT * FROM marchas WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $marcha = $this->db->single();
        }

        // Fetch dolor_puntos (interactive body map)
        $this->db->query('SELECT * FROM dolor_puntos WHERE expediente_id = :expediente_id');
        $this->db->bind(':expediente_id', $expedienteId);
        $dolor_puntos = $this->db->resultSet();

        return [
            'expediente' => $draft,
            'patient' => $patient,
            'antecedentes' => $antecedentes,
            'exploracion' => $exploracion,
            'cicatriz' => $cicatriz,
            'padecimiento' => $padecimiento,
            'problemas' => $problemas,
            'plan_sesiones' => $plan_sesiones,
            'marcha' => $marcha,
            'dolor_puntos' => $dolor_puntos
        ];
    }

    public function saveExpedienteData($patientId, $data) {
        $draft = $this->getOrCreateDraft($patientId);
        $expedienteId = $draft->id;

        // 1. Update patient master data (users table)
        $this->db->query('UPDATE users SET 
            name = :name, 
            ocupacion = :ocupacion, 
            fecha_nacimiento = :fecha_nacimiento, 
            sexo = :sexo, 
            estado_civil = :estado_civil, 
            domicilio = :domicilio, 
            phone = :phone,
            tel = :tel, 
            cel = :cel, 
            familiar_responsable = :familiar_responsable, 
            familiar_tel = :familiar_tel, 
            familiar_cel = :familiar_cel 
            WHERE id = :id');
        $this->db->bind(':id', $patientId);
        $this->db->bind(':name', $data['patient']['name'] ?? '');
        $this->db->bind(':ocupacion', $data['patient']['ocupacion'] ?? null);
        $this->db->bind(':fecha_nacimiento', !empty($data['patient']['fecha_nacimiento']) ? $data['patient']['fecha_nacimiento'] : null);
        $this->db->bind(':sexo', !empty($data['patient']['sexo']) ? $data['patient']['sexo'] : null);
        $this->db->bind(':estado_civil', !empty($data['patient']['estado_civil']) ? $data['patient']['estado_civil'] : null);
        $this->db->bind(':domicilio', $data['patient']['domicilio'] ?? null);
        $this->db->bind(':phone', $data['patient']['phone'] ?? '');
        $this->db->bind(':tel', $data['patient']['tel'] ?? null);
        $this->db->bind(':cel', $data['patient']['cel'] ?? null);
        $this->db->bind(':familiar_responsable', $data['patient']['familiar_responsable'] ?? null);
        $this->db->bind(':familiar_tel', $data['patient']['familiar_tel'] ?? null);
        $this->db->bind(':familiar_cel', $data['patient']['familiar_cel'] ?? null);
        $this->db->execute();

        // 2. Save expediente main values
        $this->db->query('UPDATE expedientes SET 
            eva_dolor = :eva_dolor, 
            notas_generales = :notas_generales, 
            notas_plan = :notas_plan 
            WHERE id = :id');
        $this->db->bind(':id', $expedienteId);
        $this->db->bind(':eva_dolor', isset($data['expediente']['eva_dolor']) && $data['expediente']['eva_dolor'] !== '' ? (int)$data['expediente']['eva_dolor'] : null);
        $this->db->bind(':notas_generales', $data['expediente']['notas_generales'] ?? null);
        $this->db->bind(':notas_plan', $data['expediente']['notas_plan'] ?? null);
        $this->db->execute();

        // 3. Save Antecedentes (if provided)
        if (isset($data['antecedentes']) && is_array($data['antecedentes'])) {
            foreach ($data['antecedentes'] as $ant) {
                $this->db->query('INSERT INTO antecedentes (expediente_id, grupo, item_key, valor, especificacion) 
                    VALUES (:expediente_id, :grupo, :item_key, :valor, :especificacion) 
                    ON DUPLICATE KEY UPDATE valor = VALUES(valor), especificacion = VALUES(especificacion)');
                $this->db->bind(':expediente_id', $expedienteId);
                $this->db->bind(':grupo', $ant['grupo']);
                $this->db->bind(':item_key', $ant['item_key']);
                $this->db->bind(':valor', $ant['valor'] ?? 'null');
                $this->db->bind(':especificacion', $ant['especificacion'] ?? null);
                $this->db->execute();
            }
        }

        // 4. Save Exploracion (if provided)
        if (isset($data['exploracion'])) {
            $this->db->query('UPDATE exploraciones SET 
                estatura_cm = :estatura_cm, 
                peso_kg = :peso_kg, 
                fc = :fc, 
                fr = :fr, 
                ta = :ta, 
                arcos_movimiento = :arcos_movimiento, 
                fuerza_muscular = :fuerza_muscular, 
                marcha_descriptiva = :marcha_descriptiva, 
                reflejos = :reflejos, 
                sensibilidad = :sensibilidad, 
                lenguaje_orientacion = :lenguaje_orientacion, 
                otros = :otros 
                WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->bind(':estatura_cm', !empty($data['exploracion']['estatura_cm']) ? (int)$data['exploracion']['estatura_cm'] : null);
            $this->db->bind(':peso_kg', !empty($data['exploracion']['peso_kg']) ? (float)$data['exploracion']['peso_kg'] : null);
            $this->db->bind(':fc', !empty($data['exploracion']['fc']) ? (int)$data['exploracion']['fc'] : null);
            $this->db->bind(':fr', !empty($data['exploracion']['fr']) ? (int)$data['exploracion']['fr'] : null);
            $this->db->bind(':ta', $data['exploracion']['ta'] ?? null);
            $this->db->bind(':arcos_movimiento', $data['exploracion']['arcos_movimiento'] ?? null);
            $this->db->bind(':fuerza_muscular', $data['exploracion']['fuerza_muscular'] ?? null);
            $this->db->bind(':marcha_descriptiva', $data['exploracion']['marcha_descriptiva'] ?? null);
            $this->db->bind(':reflejos', $data['exploracion']['reflejos'] ?? null);
            $this->db->bind(':sensibilidad', $data['exploracion']['sensibilidad'] ?? null);
            $this->db->bind(':lenguaje_orientacion', $data['exploracion']['lenguaje_orientacion'] ?? null);
            $this->db->bind(':otros', $data['exploracion']['otros'] ?? null);
            $this->db->execute();
        }

        // 5. Save Cicatriz (if provided)
        if (isset($data['cicatriz'])) {
            $this->db->query('UPDATE cicatrices SET 
                presenta = :presenta, 
                sitio = :sitio, 
                queloide = :queloide, 
                retractil = :retractil, 
                abierta = :abierta, 
                con_adherencia = :con_adherencia, 
                hipertrofica = :hipertrofica 
                WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->bind(':presenta', (int)($data['cicatriz']['presenta'] ?? 0));
            $this->db->bind(':sitio', $data['cicatriz']['sitio'] ?? null);
            $this->db->bind(':queloide', $data['cicatriz']['queloide'] ?? 'null');
            $this->db->bind(':retractil', $data['cicatriz']['retractil'] ?? 'null');
            $this->db->bind(':abierta', $data['cicatriz']['abierta'] ?? 'null');
            $this->db->bind(':con_adherencia', $data['cicatriz']['con_adherencia'] ?? 'null');
            $this->db->bind(':hipertrofica', $data['cicatriz']['hipertrofica'] ?? 'null');
            $this->db->execute();
        }

        // 6. Save Padecimiento (if provided)
        if (isset($data['padecimiento'])) {
            $this->db->query('UPDATE padecimientos SET 
                motivo_consulta = :motivo_consulta, 
                inicio = :inicio, 
                evolucion = :evolucion, 
                estudios = :estudios, 
                tratamientos_previos = :tratamientos_previos 
                WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->bind(':motivo_consulta', $data['padecimiento']['motivo_consulta'] ?? null);
            $this->db->bind(':inicio', $data['padecimiento']['inicio'] ?? null);
            $this->db->bind(':evolucion', $data['padecimiento']['evolucion'] ?? null);
            $this->db->bind(':estudios', $data['padecimiento']['estudios'] ?? null);
            $this->db->bind(':tratamientos_previos', $data['padecimiento']['tratamientos_previos'] ?? null);
            $this->db->execute();
        }

        // 7. Save Problemas (if provided)
        if (isset($data['problemas']) && is_array($data['problemas'])) {
            foreach ($data['problemas'] as $prob) {
                $this->db->query('INSERT INTO problemas (expediente_id, item_key, severidad, nota) 
                    VALUES (:expediente_id, :item_key, :severidad, :nota) 
                    ON DUPLICATE KEY UPDATE severidad = VALUES(severidad), nota = VALUES(nota)');
                $this->db->bind(':expediente_id', $expedienteId);
                $this->db->bind(':item_key', $prob['item_key']);
                $this->db->bind(':severidad', $prob['severidad'] ?? 'null');
                $this->db->bind(':nota', $prob['nota'] ?? null);
                $this->db->execute();
            }
        }

        // 8. Save Plan Sesiones (if provided)
        if (isset($data['plan_sesiones']) && is_array($data['plan_sesiones'])) {
            $this->db->query('DELETE FROM plan_sesiones WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->execute();

            foreach ($data['plan_sesiones'] as $i => $ses) {
                if (empty($ses['fecha']) && empty($ses['indicaciones'])) {
                    continue;
                }
                $this->db->query('INSERT INTO plan_sesiones (expediente_id, fecha, indicaciones, orden) 
                    VALUES (:expediente_id, :fecha, :indicaciones, :orden)');
                $this->db->bind(':expediente_id', $expedienteId);
                $this->db->bind(':fecha', !empty($ses['fecha']) ? $ses['fecha'] : null);
                $this->db->bind(':indicaciones', $ses['indicaciones'] ?? null);
                $this->db->bind(':orden', $i);
                $this->db->execute();
            }
        }

        // 9. Save Marcha (if provided)
        if (isset($data['marcha'])) {
            $total_marcha = 0;
            $gait_fields = [
                'inicio_marcha', 'paso_pd_longitud', 'paso_pd_altura', 
                'paso_pi_longitud', 'paso_pi_altura', 'simetria_paso', 
                'continuidad_pasos', 'trayectoria', 'tronco', 'postura_marcha'
            ];
            foreach ($gait_fields as $fld) {
                if (isset($data['marcha'][$fld]) && $data['marcha'][$fld] !== '') {
                    $total_marcha += (int)$data['marcha'][$fld];
                }
            }
            $total_balance_manual = isset($data['marcha']['total_balance_manual']) && $data['marcha']['total_balance_manual'] !== '' ? (int)$data['marcha']['total_balance_manual'] : 0;
            $total_general = $total_marcha + $total_balance_manual;

            $this->db->query('UPDATE marchas SET 
                libre = :libre, 
                claudicante = :claudicante, 
                con_ayuda = :con_ayuda, 
                espasticas = :espasticas, 
                ataxica = :ataxica, 
                otros = :otros, 
                otros_spec = :otros_spec, 
                observaciones = :observaciones, 
                inicio_marcha = :inicio_marcha, 
                paso_pd_longitud = :paso_pd_longitud, 
                paso_pd_altura = :paso_pd_altura, 
                paso_pi_longitud = :paso_pi_longitud, 
                paso_pi_altura = :paso_pi_altura, 
                simetria_paso = :simetria_paso, 
                continuidad_pasos = :continuidad_pasos, 
                trayectoria = :trayectoria, 
                tronco = :tronco, 
                postura_marcha = :postura_marcha, 
                total_balance_manual = :total_balance_manual, 
                total_marcha = :total_marcha, 
                total_general = :total_general 
                WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->bind(':libre', (int)($data['marcha']['libre'] ?? 0));
            $this->db->bind(':claudicante', (int)($data['marcha']['claudicante'] ?? 0));
            $this->db->bind(':con_ayuda', (int)($data['marcha']['con_ayuda'] ?? 0));
            $this->db->bind(':espasticas', (int)($data['marcha']['espasticas'] ?? 0));
            $this->db->bind(':ataxica', (int)($data['marcha']['ataxica'] ?? 0));
            $this->db->bind(':otros', (int)($data['marcha']['otros'] ?? 0));
            $this->db->bind(':otros_spec', $data['marcha']['otros_spec'] ?? null);
            $this->db->bind(':observaciones', $data['marcha']['observaciones'] ?? null);
            
            foreach ($gait_fields as $fld) {
                $this->db->bind(':' . $fld, isset($data['marcha'][$fld]) && $data['marcha'][$fld] !== '' ? (int)$data['marcha'][$fld] : null);
            }
            
            $this->db->bind(':total_balance_manual', $total_balance_manual);
            $this->db->bind(':total_marcha', $total_marcha);
            $this->db->bind(':total_general', $total_general);
            $this->db->execute();
        }

        // Save dolor_puntos (interactive body map pins)
        if (isset($data['dolor_puntos']) && is_array($data['dolor_puntos'])) {
            $this->db->query('DELETE FROM dolor_puntos WHERE expediente_id = :expediente_id');
            $this->db->bind(':expediente_id', $expedienteId);
            $this->db->execute();

            foreach ($data['dolor_puntos'] as $p) {
                if (empty($p['region'])) continue;
                $this->db->query('INSERT INTO dolor_puntos (expediente_id, region, vista, eva_nivel, tipo_dolor, notas, pos_x, pos_y) VALUES (:expediente_id, :region, :vista, :eva_nivel, :tipo_dolor, :notas, :pos_x, :pos_y)');
                $this->db->bind(':expediente_id', $expedienteId);
                $this->db->bind(':region', $p['region'] ?? 'zona');
                $this->db->bind(':vista', $p['vista'] ?? 'anterior');
                $this->db->bind(':eva_nivel', (int)($p['eva_nivel'] ?? 5));
                $this->db->bind(':tipo_dolor', $p['tipo_dolor'] ?? 'sordo');
                $this->db->bind(':notas', $p['notas'] ?? null);
                $this->db->bind(':pos_x', (float)($p['pos_x'] ?? 50.0));
                $this->db->bind(':pos_y', (float)($p['pos_y'] ?? 50.0));
                $this->db->execute();
            }
        }

        return true;
    }

    public function getPatientProgressHistory($patientId){
        $this->db->query('
            SELECT 
                e.id AS expediente_id,
                e.eva_dolor,
                e.created_at,
                m.total_general AS tinetti_score,
                (SELECT COUNT(*) FROM plan_sesiones ps WHERE ps.expediente_id = e.id) AS sesiones_totales
            FROM expedientes e
            LEFT JOIN marchas m ON m.expediente_id = e.id
            WHERE e.patient_id = :patient_id
            ORDER BY e.created_at ASC
        ');
        $this->db->bind(':patient_id', (int)$patientId);
        return $this->db->resultSet();
    }
}
