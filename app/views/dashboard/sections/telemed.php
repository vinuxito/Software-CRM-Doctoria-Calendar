<div class="crm-content-container" style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2 style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0;">
                <i class="fas fa-video" style="color: #ef4444; margin-right: 8px;"></i> Sala de Videoconsulta Médica en Vivo
            </h2>
            <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0 0;">Telemedicina cifrada punto a punto con acceso simultáneo al expediente clínico</p>
        </div>
        <span class="status-chip status-approved" style="background: #fee2e2; color: #dc2626; border-color: #fca5a5; font-size: 12px; padding: 6px 14px; font-weight: 700;">
            <i class="fas fa-circle" style="font-size: 8px; margin-right: 6px; color: #dc2626;"></i> EN VIVO
        </span>
    </div>

    <!-- Split Screen Telemedicine Layout -->
    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; min-height: 520px;">
        <!-- Left: WebRTC Video Stream Canvas -->
        <div style="background: #0f172a; border-radius: 16px; display: flex; flex-direction: column; justify-content: space-between; padding: 20px; color: #fff; position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; z-index: 2;">
                <span style="background: rgba(0,0,0,0.6); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                    <i class="fas fa-user-check" style="color: #10b981; margin-right: 6px;"></i> Paciente Conectado
                </span>
                <span style="background: rgba(0,0,0,0.6); padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                    Token: <code style="color: #38bdf8;"><?php echo substr($data['room_token'] ?? '', 0, 12); ?>...</code>
                </span>
            </div>

            <!-- Video Stream Placeholder / Simulated WebRTC Frame -->
            <div style="margin: auto; text-align: center; color: #94a3b8;">
                <i class="fas fa-user-nurse" style="font-size: 64px; color: var(--brand-primary); margin-bottom: 16px; display: block;"></i>
                <div style="font-size: 16px; font-weight: 600; color: #f8fafc;">Transmisión WebRTC Encriptada HD</div>
                <div style="font-size: 12px; margin-top: 6px;">Cámara y Micrófono Activos (DTLS-SRTP)</div>
            </div>

            <!-- Telemed Control Bar -->
            <div style="display: flex; justify-content: center; gap: 16px; z-index: 2;">
                <button type="button" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; font-size: 16px;">
                    <i class="fas fa-microphone"></i>
                </button>
                <button type="button" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; font-size: 16px;">
                    <i class="fas fa-video"></i>
                </button>
                <button type="button" onclick="alert('Enlace de invitación copiado: <?php echo htmlspecialchars($data['join_url'] ?? ''); ?>');" style="background: var(--brand-primary); border: none; color: #fff; padding: 0 16px; border-radius: 22px; cursor: pointer; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-link"></i> Copiar Enlace Paciente
                </button>
                <button type="button" onclick="window.location.href='<?php echo URLROOT; ?>/dashboard/calendar';" style="background: #ef4444; border: none; color: #fff; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; font-size: 16px;">
                    <i class="fas fa-phone-slash"></i>
                </button>
            </div>
        </div>

        <!-- Right: Live Consultation Clinical Record -->
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 16px; padding: 20px; display: flex; flex-direction: column; gap: 16px; box-shadow: var(--shadow-sm);">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: var(--text-primary); border-bottom: 1px solid var(--border-light); padding-bottom: 10px;">
                <i class="fas fa-notes-medical" style="color: var(--brand-primary);"></i> Expediente & Notas SOAP en Vivo
            </h4>
            <div>
                <label style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Subjetivo (Refiere Paciente)</label>
                <textarea style="width: 100%; height: 70px; padding: 8px; border-radius: 8px; border: 1px solid var(--border-default); font-size: 12px; margin-top: 4px;" placeholder="Dictado o notas de lo expuesto por el paciente..."></textarea>
            </div>
            <div>
                <label style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Objetivo (Observaciones de Videollamada)</label>
                <textarea style="width: 100%; height: 70px; padding: 8px; border-radius: 8px; border: 1px solid var(--border-default); font-size: 12px; margin-top: 4px;" placeholder="Evaluación visual de postura, arcos de movimiento..."></textarea>
            </div>
            <div>
                <label style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Plan de Tratamiento a Distancia</label>
                <textarea style="width: 100%; height: 70px; padding: 8px; border-radius: 8px; border: 1px solid var(--border-default); font-size: 12px; margin-top: 4px;" placeholder="Indicaciones de estiramientos, hielo/calor..."></textarea>
            </div>
            <button type="button" onclick="alert('Notas de teleconsulta guardadas en expediente.');" style="background: var(--brand-primary); color: #fff; border: none; padding: 10px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: auto;">
                <i class="fas fa-save"></i> Guardar Ficha Telemedicina
            </button>
        </div>
    </div>
</div>
