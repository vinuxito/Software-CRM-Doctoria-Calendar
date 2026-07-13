<header class="toolbar">
    <div class="tol-left"><div class="date-title"><span>Gestión de Expedientes</span></div></div>
    <div class="tol-right">
        <div class="panel-search-wrap">
            <i class="fas fa-search"></i>
            <input id="patient-live-search" type="text" placeholder="Buscar paciente...">
        </div>
    </div>
</header>
<section class="crm-content">
    <div class="settings-card">
        <h3>Expedientes Clínicos (Fichas Digitales)</h3>
        <?php if (empty($data['patients'])) : ?>
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-notes-medical"></i></div>
                <h4>No hay expedientes clínicos</h4>
                <p>Los expedientes se crean automáticamente cuando se registran pacientes en el sistema.</p>
            </div>
        <?php else : ?>
            <table class="report-table crud-table" id="patients-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Grupo Sanguíneo</th><th>Dirección</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($data['patients'] ?? []) as $p) : ?>
                        <?php $record = $p->clinical_record; ?>
                        <tr class="crud-record-row">
                            <td>#<?php echo (int)$p->id; ?></td>
                            <td><strong><?php echo htmlspecialchars($p->name); ?></strong></td>
                            <td><?php echo htmlspecialchars($p->email); ?></td>
                            <td><?php echo htmlspecialchars($p->phone ?? 'N/A'); ?></td>
                            <td>
                                <?php if (!empty($record->blood_type)) : ?>
                                    <span class="status-chip status-approved" style="background:#cfe2ff; color:#084298; border:1px solid #b6d4fe;"><?php echo htmlspecialchars($record->blood_type); ?></span>
                                <?php else : ?>
                                    <span class="status-chip status-pending">No definido</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($record->address ?? 'N/A'); ?></td>
                            <td>
                                <button class="btn-agendar btn-view-patient-file" 
                                        data-id="<?php echo (int)$p->id; ?>"
                                        data-name="<?php echo htmlspecialchars($p->name); ?>"
                                        data-email="<?php echo htmlspecialchars($p->email); ?>"
                                        data-phone="<?php echo htmlspecialchars($p->phone ?? ''); ?>"
                                        data-dob="<?php echo htmlspecialchars($record->dob ?? ''); ?>"
                                        data-address="<?php echo htmlspecialchars($record->address ?? ''); ?>"
                                        data-blood_type="<?php echo htmlspecialchars($record->blood_type ?? ''); ?>"
                                        data-allergies="<?php echo htmlspecialchars($record->allergies ?? ''); ?>"
                                        data-medical_history="<?php echo htmlspecialchars($record->medical_history ?? ''); ?>"
                                        data-medications="<?php echo htmlspecialchars($record->medications ?? ''); ?>"
                                        data-clinical_notes="<?php echo htmlspecialchars($record->clinical_notes ?? ''); ?>"><i class="fas fa-file-medical"></i> Abrir Expediente</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
      <!-- Modal for Patient Clinical File -->
    <div id="patient-file-modal" class="calendar-modal-overlay">

        <div class="calendar-modal-card" style="max-width: 950px; width: 95%;">
            <div class="calendar-modal-head">
                <h3>Expediente Clínico Digital</h3>
                <span id="wizard-autosave-status" style="font-size: 11px; color: #888; margin-left: 15px; display: inline-flex; align-items: center; gap: 6px;">
                    <span id="autosave-glow-dot" class="autosave-glow-dot"></span>
                    <span id="autosave-text"></span>
                </span>
                <span id="wizard-offline-banner" style="display: none; background: #dc3545; color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; margin-left: 10px; align-items: center;">SIN CONEXIÓN</span>
                <button type="button" id="patient-file-modal-close" class="calendar-modal-close">×</button>
            </div>
            <form id="wizard-form" class="calendar-modal-form" onsubmit="event.preventDefault();">
                <!-- Navigation Steps Progress Bar -->
                <div class="wizard-steps-progress">
                    <span class="wizard-step-indicator active" data-step="1">1. Datos Personales</span>
                    <span class="wizard-step-indicator" data-step="2">2. Antecedentes</span>
                    <span class="wizard-step-indicator" data-step="3">3. Exploración</span>
                    <span class="wizard-step-indicator" data-step="4">4. Plan Tratamiento</span>
                    <span class="wizard-step-indicator" data-step="5">5. Marcha & Tinetti</span>
                </div>

                <!-- Warnings Indicator -->
                <div id="wizard-warning-badge" class="warning-badge-alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Contraindicación posible: verificar modalidades de electroterapia / agentes físicos</span>
                </div>

                <!-- STEP 1: Datos del Paciente -->
                <div class="wizard-step-content active" id="step-content-1">
                    <h4 style="margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 5px; color: #333;"><i class="fas fa-user"></i> Datos del Paciente</h4>
                    <div class="form-grid-2">
                        <div>
                            <label>Nombre *</label>
                            <input type="text" id="patient-name" required placeholder="Nombre completo">
                        </div>
                        <div>
                            <label>Ocupación</label>
                            <input type="text" id="patient-ocupacion" placeholder="Profesión / Oficio">
                        </div>
                    </div>
                    <div class="form-grid-3">
                        <div>
                            <label>Fecha de Nacimiento</label>
                            <input type="date" id="patient-fecha-nacimiento">
                        </div>
                        <div>
                            <label>Edad</label>
                            <input type="text" id="patient-edad" readonly style="background: #f1f3f5;" placeholder="Auto-calculada">
                        </div>
                        <div>
                            <label>Sexo</label>
                            <select id="patient-sexo" style="display:none;">
                                <option value="">Seleccione...</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <div class="option-chips-container" data-target="patient-sexo">
                                <button type="button" class="option-chip" data-value="Femenino">Femenino</button>
                                <button type="button" class="option-chip" data-value="Masculino">Masculino</button>
                                <button type="button" class="option-chip" data-value="Otro">Otro</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-grid-2">
                        <div>
                            <label>Estado Civil</label>
                            <select id="patient-estado-civil" style="display:none;">
                                <option value="">Seleccione...</option>
                                <option value="Soltero(a)">Soltero(a)</option>
                                <option value="Casado(a)">Casado(a)</option>
                                <option value="Union libre">Unión libre</option>
                                <option value="Divorciado(a)">Divorciado(a)</option>
                                <option value="Viudo(a)">Viudo(a)</option>
                            </select>
                            <div class="option-chips-container" data-target="patient-estado-civil">
                                <button type="button" class="option-chip" data-value="Soltero(a)">Soltero(a)</button>
                                <button type="button" class="option-chip" data-value="Casado(a)">Casado(a)</button>
                                <button type="button" class="option-chip" data-value="Union libre">Unión libre</button>
                                <button type="button" class="option-chip" data-value="Divorciado(a)">Divorciado(a)</button>
                                <button type="button" class="option-chip" data-value="Viudo(a)">Viudo(a)</button>
                            </div>
                        </div>
                        <div>
                            <label>Domicilio</label>
                            <input type="text" id="patient-domicilio" placeholder="Dirección de residencia">
                        </div>
                    </div>
                    <div class="form-grid-2">
                        <div>
                            <label>Teléfono (Fijo)</label>
                            <input type="text" id="patient-tel" placeholder="10 dígitos">
                        </div>
                        <div>
                            <label>Celular</label>
                            <input type="text" id="patient-cel" placeholder="10 dígitos">
                        </div>
                    </div>
                    <div class="form-grid-2" style="margin-top: 15px; border-top: 1px dashed #eee; padding-top: 10px;">
                        <div>
                            <label>Familiar Responsable</label>
                            <input type="text" id="patient-familiar-responsable" placeholder="Contacto de emergencia">
                        </div>
                        <div>
                            <label>Tel/Cel Familiar</label>
                            <input type="text" id="patient-familiar-tel-cel" placeholder="Teléfono de contacto">
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Antecedentes -->
                <div class="wizard-step-content" id="step-content-2">
                    <h4 style="margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 5px; color: #333;"><i class="fas fa-history"></i> Antecedentes Heredofamiliares y Personales</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <!-- Group A: Patológicos -->
                        <div>
                            <h5 style="color: #a83232; margin-bottom: 10px; border-bottom: 1px solid #f8d7da; padding-bottom: 3px;">Grupo A: Patológicos y Heredofamiliares</h5>
                            <div id="antecedentes-grupo-a" style="display: flex; flex-direction: column; gap: 10px;">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>
                        <!-- Group B: No Patológicos -->
                        <div>
                            <h5 style="color: #0f5132; margin-bottom: 10px; border-bottom: 1px solid #d1e7dd; padding-bottom: 3px;">Grupo B: No Patológicos y Salud</h5>
                            <div id="antecedentes-grupo-b" style="display: flex; flex-direction: column; gap: 10px;">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Exploración y Valoración -->
                <div class="wizard-step-content" id="step-content-3">
                    <h4 style="margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 5px; color: #333;"><i class="fas fa-stethoscope"></i> Exploración Física y Funcional</h4>
                    
                    <div class="form-grid-3">
                        <div>
                            <label>Estatura (cm)</label>
                            <input type="number" id="exploracion-estatura" placeholder="cm">
                        </div>
                        <div>
                            <label>Peso (kg)</label>
                            <input type="number" step="0.1" id="exploracion-peso" placeholder="kg">
                        </div>
                        <div>
                            <label>T/A (Tensión Arterial)</label>
                            <input type="text" id="exploracion-ta" placeholder="###/### mmHg">
                        </div>
                    </div>

                    <!-- BMI (IMC) Visual Gauge -->
                    <div class="imc-gauge-container" id="imc-gauge-block" style="display: none; margin-top: 15px; background: #fff; border: 1.5px solid var(--border-gray); border-radius: 10px; padding: 15px; box-sizing: border-box;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 13px; font-weight: bold; color: var(--slate-text);">Análisis de Masa Corporal (IMC)</span>
                            <span id="imc-value-badge" style="font-size: 12px; font-weight: bold; padding: 4px 10px; border-radius: 6px; background: var(--bg-light-gray); color: var(--slate-text);">--</span>
                        </div>
                        <div class="imc-track" style="position: relative; height: 16px; border-radius: 8px; background: linear-gradient(to right, #63B3ED 0%, #63B3ED 30%, #48BB78 30%, #48BB78 60%, #ECC94B 60%, #ECC94B 80%, #F56565 80%); overflow: visible;">
                            <div id="imc-gauge-needle" style="position: absolute; top: -4px; left: 0%; width: 4px; height: 24px; background: var(--slate-text); border-radius: 2px; transition: left 0.3s ease-out; box-shadow: 0 0 4px rgba(0,0,0,0.3);">
                                <div style="position: absolute; top: -6px; left: -4px; border-left: 6px solid transparent; border-right: 6px solid transparent; border-top: 6px solid var(--slate-text);"></div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 10px; font-weight: 600; color: var(--slate-muted); margin-top: 6px;">
                            <span>Bajo (< 18.5)</span>
                            <span>Normal (18.5 - 24.9)</span>
                            <span>Sobrepeso (25 - 29.9)</span>
                            <span>Obeso (>= 30)</span>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label>F/C (Frecuencia Cardíaca - lpm)</label>
                            <input type="number" id="exploracion-fc" placeholder="lpm">
                        </div>
                        <div>
                            <label>F/R (Frecuencia Respiratoria - rpm)</label>
                            <input type="number" id="exploracion-fr" placeholder="rpm">
                        </div>
                    </div>

                    <div class="form-grid-2" style="margin-top: 10px;">
                        <div>
                            <label>Arcos de Movimiento</label>
                            <textarea id="exploracion-arcos" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;" placeholder="Valoración de movilidad articular"></textarea>
                        </div>
                        <div>
                            <label>Fuerza Muscular</label>
                            <textarea id="exploracion-fuerza" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;" placeholder="Escala de Daniels 0-5..."></textarea>
                        </div>
                    </div>

                    <!-- Cicatriz Quirúrgica -->
                    <div style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 6px; padding: 12px; margin-top: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <strong style="font-size: 13px; color: #333;">¿Presenta Cicatriz Quirúrgica?</strong>
                            <div class="segmented-control" id="cicatriz-master-control">
                                <button type="button" class="segmented-btn" data-val="1">Sí</button>
                                <button type="button" class="segmented-btn" data-val="0">No</button>
                            </div>
                        </div>
                        <div id="cicatriz-details-container" style="display: none; margin-top: 10px; border-top: 1px dashed #ddd; padding-top: 10px;">
                            <div style="margin-bottom: 8px;">
                                <label>Sitio / Localización</label>
                                <input type="text" id="cicatriz-sitio" placeholder="Ej. Rodilla derecha" style="width: 100%;">
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px;">
                                <label style="display: flex; align-items: center; gap: 5px; font-weight: normal; font-size: 12px; cursor: pointer;">
                                    <input type="checkbox" id="cicatriz-queloide" value="si"> Queloide
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px; font-weight: normal; font-size: 12px; cursor: pointer;">
                                    <input type="checkbox" id="cicatriz-retractil" value="si"> Retráctil
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px; font-weight: normal; font-size: 12px; cursor: pointer;">
                                    <input type="checkbox" id="cicatriz-abierta" value="si"> Abierta
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px; font-weight: normal; font-size: 12px; cursor: pointer;">
                                    <input type="checkbox" id="cicatriz-con-adherencia" value="si"> Con Adherencia
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px; font-weight: normal; font-size: 12px; cursor: pointer;">
                                    <input type="checkbox" id="cicatriz-hipertrofica" value="si"> Hipertrófica
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Valoración Funcional -->
                    <h5 style="margin-top: 15px; margin-bottom: 8px; color: #444; border-bottom: 1px solid #eee; padding-bottom: 3px;">Valoración Funcional</h5>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label>Reflejos</label>
                            <textarea id="exploracion-reflejos" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                        <div>
                            <label>Sensibilidad</label>
                            <textarea id="exploracion-sensibilidad" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px;">
                        <div>
                            <label>Lenguaje / Orientación</label>
                            <textarea id="exploracion-lenguaje-orientacion" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                        <div>
                            <label>Otros</label>
                            <textarea id="exploracion-otros" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                    </div>

                    <!-- Padecimiento Actual -->
                    <h5 style="margin-top: 15px; margin-bottom: 8px; color: #444; border-bottom: 1px solid #eee; padding-bottom: 3px;">Padecimiento Actual</h5>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label>Motivo de consulta</label>
                            <textarea id="padecimiento-motivo" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                        <div>
                            <label>Inicio</label>
                            <textarea id="padecimiento-inicio" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-top: 10px;">
                        <div>
                            <label>Evolución</label>
                            <textarea id="padecimiento-evolucion" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                        <div>
                            <label>Estudios</label>
                            <textarea id="padecimiento-estudios" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                        <div>
                            <label>Tratamientos previos</label>
                            <textarea id="padecimiento-tratamientos" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                        </div>
                    </div>

                    <!-- EVA Dolor Scale -->
                    <div class="eva-container">
                        <strong>Valoración Dolor (EVA)</strong>
                        <div class="eva-face" id="eva-emoji">⚪</div>
                        <input type="range" min="0" max="10" step="1" class="eva-slider" id="eva-slider-input" value="0">
                        <div style="font-weight: bold; font-size: 13px;" id="eva-label">No tocado</div>
                    </div>

                    <!-- Problemas Identificados -->
                    <h5 style="margin-top: 15px; margin-bottom: 8px; color: #444; border-bottom: 1px solid #eee; padding-bottom: 3px;">Problemas Identificados</h5>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: left;" id="problemas-grid-table">
                            <thead>
                                <tr style="background: #f1f3f5; border-bottom: 1px solid #dee2e6;">
                                    <th style="padding: 6px;">Problema</th>
                                    <th style="padding: 6px; width: 180px;">Severidad</th>
                                    <th style="padding: 6px;">Nota / Valoración</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Fixed 8 rows loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- STEP 4: Plan de Tratamiento -->
                <div class="wizard-step-content" id="step-content-4">
                    <h4 style="margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 5px; color: #333;"><i class="fas fa-calendar-alt"></i> Plan de Tratamiento</h4>
                    
                    <!-- Badges Echo Warning -->
                    <div id="step-4-warning-echo" class="warning-badge-alert" style="margin-bottom: 15px;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Contraindicación posible detectada en antecedentes (Marcapasos / Embarazo). Proceder con precaución.</span>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <strong style="font-size: 13px; display: block; margin-bottom: 8px; color: #555;">Sesiones de Tratamiento</strong>
                        <div id="treatment-sessions-container">
                            <!-- Dynamic rows injected here -->
                        </div>
                        <button type="button" class="btn-outline" id="btn-add-treatment-row" style="padding: 6px 12px; font-size: 12px; margin-top: 5px;"><i class="fas fa-plus"></i> Agregar Sesión</button>
                    </div>

                    <div>
                        <label>Notas Generales / Indicaciones Complementarias</label>
                        <textarea id="expediente-notas-generales" rows="4" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 8px;" placeholder="Notas y recomendaciones adicionales..."></textarea>
                    </div>
                </div>

                <!-- STEP 5: Marcha y Análisis (Tinetti) -->
                <div class="wizard-step-content" id="step-content-5">
                    <h4 style="margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 5px; color: #333;"><i class="fas fa-walking"></i> Marcha y Análisis de Marcha (Tinetti)</h4>
                    
                    <div class="gait-grid">
                        <!-- Gait checklist -->
                        <div>
                            <strong style="font-size: 13px; color: #444;">Deambulación / Marcha</strong>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 8px;">
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: normal; cursor: pointer;">
                                    <input type="checkbox" id="gait-libre"> Libre
                                </label>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: normal; cursor: pointer;">
                                    <input type="checkbox" id="gait-claudicante"> Claudicante
                                </label>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: normal; cursor: pointer;">
                                    <input type="checkbox" id="gait-con-ayuda"> Con ayuda
                                </label>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: normal; cursor: pointer;">
                                    <input type="checkbox" id="gait-espasticas"> Espásticas
                                </label>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: normal; cursor: pointer;">
                                    <input type="checkbox" id="gait-ataxica"> Atáxica
                                </label>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: normal; cursor: pointer;">
                                    <input type="checkbox" id="gait-otros"> Otros
                                </label>
                            </div>
                            <div id="gait-otros-spec-container" style="display: none; margin-top: 8px;">
                                <input type="text" id="gait-otros-spec" placeholder="Especificar..." style="width: 100%;">
                            </div>
                            <div style="margin-top: 10px;">
                                <label>Observaciones de Deambulación</label>
                                <textarea id="gait-observaciones" rows="3" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;"></textarea>
                            </div>
                        </div>

                        <!-- Scoring parameters -->
                        <div style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 6px; padding: 12px;">
                            <strong style="font-size: 13px; color: #444; border-bottom: 1px solid #ddd; display: block; padding-bottom: 3px; margin-bottom: 8px;">Tinetti Gait Subscale (POMA-G)</strong>
                            <div id="tinetti-scoring-container" style="display: flex; flex-direction: column; gap: 8px; max-height: 250px; overflow-y: auto; padding-right: 5px;">
                                <!-- Radio groups injected dynamically -->
                            </div>
                            <div style="margin-top: 12px; border-top: 1px dashed #ccc; padding-top: 8px; display: flex; flex-direction: column; gap: 6px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                                    <span>Subtotal Marcha (Max 12):</span>
                                    <strong id="score-marcha-val">0</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                                    <span>Total Equilibrio Manual (0-16):</span>
                                    <input type="number" min="0" max="16" id="score-balance-manual" value="0" style="width: 60px; padding: 3px; text-align: center;">
                                </div>
                                <div style="display: none;">
                                    <strong>Total General (Max 28):</strong>
                                    <strong id="score-general-val" style="color: #a83232; font-size: 14px;">0</strong>
                                    <span id="tinetti-risk-badge" class="status-chip status-approved" style="text-align: center; display: block; margin-top: 5px; font-weight: bold;">Bajo Riesgo</span>
                                </div>

                                <!-- Upgraded SVG Ring Indicator Box -->
                                <div style="display: flex; gap: 12px; align-items: center; background: #fff; border: 1.5px solid var(--border-gray); border-radius: 10px; padding: 12px; margin-top: 10px; box-sizing: border-box;">
                                    <!-- SVG Ring -->
                                    <div style="position: relative; width: 44px; height: 44px; flex-shrink: 0;">
                                        <svg width="44" height="44" viewBox="0 0 36 36" style="transform: rotate(-90deg); display: block;">
                                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E2E8F0" stroke-width="3" />
                                            <path id="tinetti-svg-ring" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#48BB78" stroke-width="3" stroke-dasharray="0, 100" style="transition: stroke-dasharray 0.3s ease-out;" />
                                        </svg>
                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-family: var(--font-heading); font-size: 11px; font-weight: bold; color: var(--slate-text);" id="tinetti-svg-text">0/28</div>
                                    </div>
                                    <!-- Risk Text -->
                                    <div style="display: flex; flex-direction: column; gap: 2px;">
                                        <span style="font-size: 9px; font-weight: 600; color: var(--slate-muted); text-transform: uppercase; letter-spacing: 0.5px; line-height: 1;">Riesgo de Caída</span>
                                        <span id="tinetti-risk-badge-text" style="font-size: 12px; font-weight: bold; color: var(--slate-text); line-height: 1.2;">Bajo Riesgo</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scroll Fade Indicator -->
                <div class="wizard-scroll-indicator" id="wizard-scroll-fade"></div>

                <!-- Navigation controls -->
                <div class="calendar-modal-actions" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px; display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 10;">
                    <button type="button" class="btn-outline" id="wizard-btn-prev" style="display: none;"><i class="fas fa-chevron-left"></i> Anterior</button>
                    <span style="font-size: 11px; color: #888;" id="wizard-step-label">Paso 1 de 5</span>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn-configurar" id="wizard-btn-next">Siguiente <i class="fas fa-chevron-right"></i></button>
                        <button type="button" class="btn-configurar" id="wizard-btn-save" style="display: none; background: #28a745; border-color: #28a745;"><i class="fas fa-save"></i> Guardar Borrador</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="<?php echo URLROOT; ?>/js/sections/patients.js"></script>
