<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente Clínico Digital - <?php echo htmlspecialchars($data['patient']->name ?? 'Paciente'); ?></title>
    <style>
        @media print {
            body { background: #fff !important; font-size: 11pt; }
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
        }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1e293b; margin: 0; padding: 24px; line-height: 1.5; }
        .header-table { width: 100%; border-bottom: 2px solid #00a29a; padding-bottom: 12px; margin-bottom: 20px; }
        .header-title { font-size: 20px; font-weight: bold; color: #00a29a; text-transform: uppercase; }
        .section-box { border: 1px solid #cbd5e1; border-radius: 6px; padding: 14px; margin-bottom: 16px; background: #fafafa; }
        .section-header { font-size: 14px; font-weight: bold; color: #0f766e; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 10px; text-transform: uppercase; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .label { font-weight: bold; color: #475569; font-size: 11px; }
        .val { color: #0f172a; font-size: 13px; }
        .signature-block { margin-top: 50px; text-align: center; display: flex; justify-content: space-around; }
        .sig-line { border-top: 1px solid #475569; width: 220px; text-align: center; padding-top: 6px; font-size: 11px; color: #475569; }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print();" style="background: #00a29a; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer;">
            <i class="fas fa-print"></i> Imprimir / Guardar como PDF
        </button>
    </div>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td>
                <div class="header-title">Doctoria CRM — Ficha Clínica Digital</div>
                <div style="font-size: 12px; color: #64748b;">Clínica de Fisioterapia y Rehabilitación Física</div>
            </td>
            <td style="text-align: right; font-size: 11px; color: #64748b;">
                Fecha de Emisión: <?php echo date('d/m/Y H:i'); ?><br>
                Expediente N°: EXP-<?php echo sprintf('%05d', $data['expediente']->id ?? 1); ?>
            </td>
        </tr>
    </table>

    <!-- Section 1: Patient Details -->
    <div class="section-box">
        <div class="section-header">1. Ficha del Paciente</div>
        <div class="grid-2">
            <div><span class="label">Nombre:</span> <span class="val"><?php echo htmlspecialchars($data['patient']->name ?? ''); ?></span></div>
            <div><span class="label">Teléfono:</span> <span class="val"><?php echo htmlspecialchars($data['patient']->phone ?? 'N/A'); ?></span></div>
            <div><span class="label">Ocupación:</span> <span class="val"><?php echo htmlspecialchars($data['patient']->ocupacion ?? 'N/A'); ?></span></div>
            <div><span class="label">Fecha de Nacimiento:</span> <span class="val"><?php echo htmlspecialchars($data['patient']->fecha_nacimiento ?? 'N/A'); ?></span></div>
        </div>
    </div>

    <!-- Section 2: Pain & Evaluation -->
    <div class="section-box">
        <div class="section-header">2. Exploración y Evaluación del Dolor (Escala EVA)</div>
        <div class="grid-2">
            <div><span class="label">Intensidad Dolor EVA:</span> <span class="val" style="font-weight: bold; color: #dc2626;"><?php echo ($data['expediente']->eva_dolor ?? 'N/A'); ?> / 10</span></div>
            <div><span class="label">Notas de Diagnóstico:</span> <span class="val"><?php echo htmlspecialchars($data['expediente']->notas_generales ?? 'Sin observaciones adicionales'); ?></span></div>
        </div>
    </div>

    <!-- Section 3: Gait & Tinetti Scale -->
    <div class="section-box">
        <div class="section-header">3. Evaluación de Marcha y Equilibrio (Tinetti)</div>
        <div class="grid-2">
            <div><span class="label">Puntuación Total Tinetti:</span> <span class="val" style="font-weight: bold; color: #00a29a;"><?php echo ($data['marcha']->total_general ?? 'N/A'); ?> / 28 pts</span></div>
            <div><span class="label">Riesgo Funcional:</span> <span class="val"><?php echo (($data['marcha']->total_general ?? 28) < 19) ? 'Alto Riesgo de Caídas' : 'Movilidad Normal / Riesgo Bajo'; ?></span></div>
        </div>
    </div>

    <!-- Signature -->
    <div class="signature-block">
        <div class="sig-line">
            Firma del Fisioterapeuta / Médico<br>
            Cédula Profesional: ___________
        </div>
        <div class="sig-line">
            Firma de Conformidad del Paciente
        </div>
    </div>
</body>
</html>
