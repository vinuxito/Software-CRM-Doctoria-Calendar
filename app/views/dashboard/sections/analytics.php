<div class="crm-content-container" style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0;">
                <i class="fas fa-chart-pie" style="color: var(--brand-primary); margin-right: 8px;"></i> Analítica de Rehabilitación y Progreso Clínico
            </h2>
            <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0 0;">Seguimiento longitudinal de la escala de dolor EVA, movilidad Tinetti y cumplimiento de tratamiento</p>
        </div>
        <select id="analytics-patient-select" onchange="window.location.href='<?php echo URLROOT; ?>/dashboard/analytics?patient_id=' + this.value;" style="padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border-default); font-weight: 600;">
            <?php foreach (($data['patients'] ?? []) as $p) : ?>
                <option value="<?php echo $p->id; ?>" <?php echo (isset($data['selected_patient_id']) && (int)$data['selected_patient_id'] === (int)$p->id) ? 'selected' : ''; ?>>
                    Paciente: <?php echo htmlspecialchars($p->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Analytics Dashboard Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 20px;">
        <!-- EVA Pain Reduction Curve -->
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 12px; padding: 20px; box-shadow: var(--shadow-sm);">
            <h4 style="font-size: 15px; font-weight: 700; color: var(--text-primary); margin-top: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-heartbeat" style="color: #ef4444;"></i> Curva de Dolor EVA (1 - 10)
            </h4>
            <div style="height: 220px; display: flex; align-items: flex-end; gap: 20px; padding: 20px 10px 10px 10px; border-bottom: 2px solid #e2e8f0; background: #fafafa; border-radius: 8px;">
                <?php 
                $history = $data['progress_history'] ?? [];
                if (empty($history)) {
                    echo '<div style="width: 100%; text-align: center; color: #94a3b8; font-size: 13px;">No hay evaluaciones previas registradas para este paciente.</div>';
                } else {
                    foreach ($history as $idx => $item) {
                        $eva = $item->eva_dolor !== null ? (int)$item->eva_dolor : 5;
                        $heightPct = ($eva / 10) * 100;
                        $barColor = $eva >= 7 ? '#ef4444' : ($eva >= 4 ? '#f59e0b' : '#3b82f6');
                        echo '<div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px;">' .
                             '<span style="font-size: 11px; font-weight: 700; color: ' . $barColor . ';">EVA ' . $eva . '</span>' .
                             '<div style="width: 100%; max-width: 36px; height: ' . $heightPct . '%; background: ' . $barColor . '; border-radius: 6px 6px 0 0; transition: height 0.3s;"></div>' .
                             '<span style="font-size: 10px; color: #64748b;">Sesión ' . ($idx + 1) . '</span>' .
                             '</div>';
                    }
                }
                ?>
            </div>
        </div>

        <!-- Tinetti Mobility Progress -->
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 12px; padding: 20px; box-shadow: var(--shadow-sm);">
            <h4 style="font-size: 15px; font-weight: 700; color: var(--text-primary); margin-top: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-walking" style="color: var(--brand-primary);"></i> Escala de Movilidad Tinetti
            </h4>
            <div style="height: 220px; display: flex; flex-direction: column; justify-content: center; gap: 16px; padding: 10px;">
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px;">
                        <span>Puntuación Reciente</span>
                        <span style="color: var(--brand-primary); font-weight: 700;">
                            <?php 
                            $lastTinetti = !empty($history) ? (end($history)->tinetti_score ?? 0) : 0;
                            echo $lastTinetti . ' / 28 pts';
                            ?>
                        </span>
                    </div>
                    <div style="height: 14px; background: #e2e8f0; border-radius: 7px; overflow: hidden;">
                        <div style="height: 100%; width: <?php echo min(100, ($lastTinetti / 28) * 100); ?>%; background: var(--brand-primary); border-radius: 7px;"></div>
                    </div>
                </div>

                <div style="background: #f8fafc; border-radius: 8px; padding: 12px; font-size: 12px; color: var(--text-secondary);">
                    <strong>Evaluación de Riesgo:</strong><br>
                    <?php if ($lastTinetti < 19) : ?>
                        <span style="color: #dc2626; font-weight: 700;">Alto Riesgo de Caídas (&lt; 19 pts)</span> — Se recomienda enfatizar entrenamiento de equilibrio estático/dinámico.
                    <?php elseif ($lastTinetti <= 24) : ?>
                        <span style="color: #d97706; font-weight: 700;">Riesgo Moderado (19 - 24 pts)</span> — Continuar plan de fortalecimiento de marcha.
                    <?php else : ?>
                        <span style="color: #16a34a; font-weight: 700;">Riesgo Bajo / Normal (&gt; 24 pts)</span> — Excelente estabilidad funcional.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
