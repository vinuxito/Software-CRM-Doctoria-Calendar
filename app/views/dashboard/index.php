<?php require APPROOT . '/views/inc/header.php'; ?>
<?php $section = $data['section'] ?? 'calendar'; ?>
<div class="crm-calendar-shell">
    <nav class="icon-sidebar">
        <div class="brand-icon">
            <img src="<?php echo URLROOT; ?>/img/logo.png" alt="Logo">
        </div>
        <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="nav-icon <?php echo $section === 'calendar' ? 'active' : ''; ?>"><i class="far fa-calendar-alt"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/doctors" class="nav-icon <?php echo $section === 'doctors' ? 'active' : ''; ?>"><i class="far fa-user"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/chat" class="nav-icon <?php echo $section === 'chat' ? 'active' : ''; ?>"><i class="far fa-comment"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/panel" class="nav-icon <?php echo $section === 'panel' ? 'active' : ''; ?>"><i class="far fa-chart-bar"></i></a>
        <?php if (in_array($data['user_role'], ['admin', 'medico'], true)) : ?>
        <a href="<?php echo URLROOT; ?>/dashboard/patients" class="nav-icon <?php echo $section === 'patients' ? 'active' : ''; ?>" title="Expedientes Clínicos"><i class="fas fa-notes-medical"></i></a>
        <?php endif; ?>
        <?php if ($data['user_role'] === 'admin') : ?>
        <a href="<?php echo URLROOT; ?>/dashboard/users" class="nav-icon <?php echo $section === 'users' ? 'active' : ''; ?>" title="Control de Usuarios"><i class="fas fa-users"></i></a>
        <?php endif; ?>
        <div class="bottom-actions">
            <a href="<?php echo URLROOT; ?>/dashboard/settings" class="nav-icon <?php echo $section === 'settings' ? 'active' : ''; ?>"><i class="fas fa-cog"></i></a>
            <a href="<?php echo URLROOT; ?>/dashboard/profile" class="user-avatar user-avatar-link <?php echo $section === 'profile' ? 'active' : ''; ?>"><?php echo strtoupper(substr($data['user_name'], 0, 1)); ?></a>
        </div>
    </nav>

    <?php if ($section === 'calendar') : ?>
    <aside class="controls-panel">
        <div class="panel-header">
            <div class="brand-mini-icon"><i class="fas fa-layer-group"></i></div>
            <div class="month-title">Marzo 2026</div>
            <div class="nav-arrows"><span>❮</span><span>❯</span></div>
        </div>
        <div class="mini-cal">
            <div class="mini-day-name">Lun</div><div class="mini-day-name">Mar</div><div class="mini-day-name">Mié</div><div class="mini-day-name">Jue</div><div class="mini-day-name">Vie</div><div class="mini-day-name">Sáb</div><div class="mini-day-name">Dom</div>
            <div class="mini-day-num muted">23</div><div class="mini-day-num muted">24</div><div class="mini-day-num muted">25</div><div class="mini-day-num muted">26</div><div class="mini-day-num muted">27</div><div class="mini-day-num muted">28</div><div class="mini-day-num muted">1</div>
            <div class="mini-day-num">2</div><div class="mini-day-num">3</div><div class="mini-day-num">4</div><div class="mini-day-num">5</div><div class="mini-day-num">6</div><div class="mini-day-num">7</div><div class="mini-day-num">8</div>
            <div class="mini-day-num">9</div><div class="mini-day-num">10</div><div class="mini-day-num">11</div><div class="mini-day-num">12</div><div class="mini-day-num">13</div><div class="mini-day-num active">14</div><div class="mini-day-num">15</div>
            <div class="mini-day-num">16</div><div class="mini-day-num">17</div><div class="mini-day-num">18</div><div class="mini-day-num">19</div><div class="mini-day-num">20</div><div class="mini-day-num">21</div><div class="mini-day-num">22</div>
            <div class="mini-day-num">23</div><div class="mini-day-num">24</div><div class="mini-day-num">25</div><div class="mini-day-num">26</div><div class="mini-day-num">27</div><div class="mini-day-num">28</div><div class="mini-day-num">29</div>
        </div>
        <ul class="action-links">
            <li class="action-link"><i class="fas fa-level-up-alt"></i><span>Lista de espera</span><span class="new-tag">NUEVO</span></li>
            <li class="action-link action-link-danger"><i class="far fa-calendar-times"></i><span>Bloquear fechas</span></li>
        </ul>
        <?php if (!empty($data['flash'])) : ?>
            <div class="calendar-flash"><?php echo htmlspecialchars($data['flash']); ?></div>
        <?php endif; ?>
        <?php if (!empty($data['can_schedule'])) : ?>
            <form action="<?php echo URLROOT; ?>/dashboard/calendar" method="post" class="quick-appointment-form">
                <input type="hidden" name="create_appointment" value="1">
                <input type="text" name="title" placeholder="Título de cita" required>
                <select name="doctor_id" required>
                    <option value="">Selecciona médico</option>
                    <?php foreach (($data['doctors'] ?? []) as $doctorItem) : ?>
                        <option value="<?php echo (int)$doctorItem->id; ?>"><?php echo htmlspecialchars($doctorItem->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="patient_id" required>
                    <option value="">Selecciona cliente</option>
                    <?php foreach (($data['clients'] ?? []) as $clientItem) : ?>
                        <option value="<?php echo (int)$clientItem->id; ?>"><?php echo htmlspecialchars($clientItem->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="quick-date-field">
                    <label class="field-label" for="start_date">Desde</label>
                    <input id="start_date" type="datetime-local" name="start_date" required>
                </div>
                <div class="quick-date-field">
                    <label class="field-label" for="end_date">Hasta</label>
                    <input id="end_date" type="datetime-local" name="end_date" required>
                </div>
                <input type="text" name="contact_phone" placeholder="Número de contacto">
                <textarea name="description" placeholder="Descripción"></textarea>
                <button type="submit" class="btn-configurar">Agendar cita</button>
            </form>
        <?php endif; ?>
        <div class="section-flat">Visitas de hoy <i class="fas fa-chevron-right"></i></div>
    </aside>
    <?php endif; ?>

    <main class="main-view">
        <?php if (!empty($data['flash'])) : ?>
            <?php 
                $flashType = $data['flash_type'] ?? 'auto';
                if ($flashType === 'auto') {
                    $isError = preg_match('/(error|incorrecto|ya está|no puedes|no válido|campos obligatorios|completados)/i', $data['flash']);
                } else {
                    $isError = ($flashType === 'error');
                }
                $flashClass = $isError ? 'flash-bar flash-danger' : 'flash-bar flash-success';
                $flashIcon = $isError ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
            ?>
            <div class="<?php echo $flashClass; ?>">
                <i class="<?php echo $flashIcon; ?>"></i>
                <span><?php echo htmlspecialchars($data['flash']); ?></span>
            </div>
        <?php endif; ?>
        <?php if ($section === 'calendar') : ?>
        <header class="toolbar">
            <div class="tol-left">
                <button id="crm-today" class="btn-outline">Esta semana</button>
                <button id="crm-prev" class="inline-nav">❮</button>
                <button id="crm-next" class="inline-nav">❯</button>
                <div class="date-title"><span id="crm-title">14 - 20 Marzo</span></div>
            </div>
            <div class="tol-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Buscar paciente"></div>
                <select class="btn-outline"><option>Semana</option><option>Día</option><option>Mes</option></select>
                <span class="more-dot">⋮</span>
            </div>
        </header>
        <section id="calendar" class="crm-fc"></section>
        <?php if (!empty($data['can_schedule'])) : ?>
            <div id="calendar-modal" class="calendar-modal-overlay">
                <div class="calendar-modal-card">
                    <div class="calendar-modal-head">
                        <h3>Agendar cita</h3>
                        <button type="button" id="calendar-modal-close" class="calendar-modal-close">×</button>
                    </div>
                    <form action="<?php echo URLROOT; ?>/dashboard/calendar" method="post" class="calendar-modal-form">
                        <input type="hidden" name="create_appointment" value="1">
                        <input type="hidden" name="appointment_id" id="modal-appointment-id" value="0">
                        <input type="hidden" name="appointment_action" id="modal-appointment-action" value="save">
                        <label>Título</label>
                        <input type="text" name="title" id="modal-title" value="Nueva cita" required>
                        <label>Médico</label>
                        <select name="doctor_id" required>
                            <?php foreach (($data['doctors'] ?? []) as $doctorItem) : ?>
                                <option value="<?php echo (int)$doctorItem->id; ?>"><?php echo htmlspecialchars($doctorItem->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label>Cliente</label>
                        <select name="patient_id" required>
                            <?php foreach (($data['clients'] ?? []) as $clientItem) : ?>
                                <option value="<?php echo (int)$clientItem->id; ?>"><?php echo htmlspecialchars($clientItem->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label>Desde</label>
                        <input type="datetime-local" name="start_date" id="modal-start-date" required>
                        <label>Hasta</label>
                        <input type="datetime-local" name="end_date" id="modal-end-date" required>
                        <label>Número de contacto</label>
                        <input type="text" name="contact_phone" id="modal-contact-phone" placeholder="+57 300 000 0000">
                        <label>Descripción</label>
                        <textarea name="description" id="modal-description" placeholder="Detalle de la cita"></textarea>
                        <div class="calendar-modal-actions">
                            <button type="button" id="calendar-modal-delete" class="btn-chat">Eliminar</button>
                            <button type="submit" id="calendar-modal-save" class="btn-configurar">Guardar cita</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php elseif ($section === 'doctors') : ?>
        <header class="toolbar">
            <div class="tol-left"><div class="date-title"><span>Especialistas disponibles</span></div></div>
        </header>
        <section class="crm-content doctors-reference">
            <?php if (empty($data['doctors'])) : ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-user-md"></i></div>
                    <h4>No hay especialistas registrados</h4>
                    <p>Los médicos aparecerán aquí cuando un administrador los registre en el sistema.</p>
                </div>
            <?php else : ?>
                <div class="doctor-grid">
                    <?php
                        $images = [
                            URLROOT . '/../img/doctor1.png',
                            URLROOT . '/../img/doctor2.png',
                            URLROOT . '/../img/doctor3.png',
                            URLROOT . '/../img/doctor4.png'
                        ];
                    ?>
                    <?php foreach (($data['doctors'] ?? []) as $idx => $doctor) : ?>
                        <article class="doctor-card ref">
                            <div class="doctor-thumb" style="background-image:url('<?php echo $images[$idx % count($images)]; ?>')"></div>
                            <div class="doctor-body">
                                <div class="doctor-name"><?php echo htmlspecialchars($doctor->name); ?></div>
                                <div class="doctor-role">Doctor</div>
                                <div class="doctor-rate">★★★★★ <span>(<?php echo 80 + ($idx * 7); ?>)</span></div>
                                <div class="doctor-actions">
                                    <a class="btn-agendar" href="<?php echo URLROOT; ?>/dashboard/calendar?doctor=<?php echo (int)$doctor->id; ?>"><i class="far fa-calendar-alt"></i> Agendar</a>
                                    <a class="btn-chat" href="<?php echo URLROOT; ?>/dashboard/chat?with=<?php echo (int)$doctor->id; ?>"><i class="far fa-comment"></i> Chat</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php elseif ($section === 'chat') : ?>
        <header class="toolbar">
            <div class="tol-left"><div class="date-title"><span>Mensajes</span></div></div>
        </header>
        <section class="crm-content chat-reference">
            <aside class="chat-list ref">
                <?php
                    $chatAvatars = [
                        URLROOT . '/../img/doctor1.png',
                        URLROOT . '/../img/doctor2.png',
                        URLROOT . '/../img/doctor3.png',
                        URLROOT . '/../img/doctor4.png'
                    ];
                ?>
                <?php foreach (($data['chat_contacts'] ?? []) as $contact) : ?>
                    <a class="chat-item" href="<?php echo URLROOT; ?>/dashboard/chat?with=<?php echo (int)$contact->id; ?>">
                        <div class="chat-avatar-photo" style="background-image:url('<?php echo $chatAvatars[$contact->id % count($chatAvatars)]; ?>')"></div>
                        <div class="chat-meta">
                            <div class="chat-name"><?php echo htmlspecialchars($contact->name); ?></div>
                            <div class="chat-last"><?php echo htmlspecialchars($contact->last_message ?? $contact->role); ?></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </aside>
            <?php if (!empty($data['chat_with'])) : ?>
                <div class="chat-window-live">
                    <div class="chat-messages">
                        <?php foreach (($data['chat_messages'] ?? []) as $message) : ?>
                            <div class="chat-row <?php echo ((int)$message->sender_id === (int)$_SESSION['user_id']) ? 'own' : ''; ?>">
                                <div class="chat-avatar-mini" style="background-image:url('<?php echo $chatAvatars[$message->sender_id % count($chatAvatars)]; ?>')"></div>
                                <div class="chat-bubble-live">
                                    <strong><?php echo htmlspecialchars($message->sender_name); ?>:</strong>
                                    <?php echo htmlspecialchars($message->message); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <form class="chat-send-form" action="<?php echo URLROOT; ?>/dashboard/chat" method="post">
                        <input type="hidden" name="receiver_id" value="<?php echo (int)$data['chat_with']; ?>">
                        <input type="text" name="message" placeholder="Escribe un mensaje..." required>
                        <button type="submit" class="btn-configurar">Enviar</button>
                    </form>
                </div>
            <?php else : ?>
                <div class="chat-empty">
                    <div class="chat-empty-icon"><i class="far fa-comment-alt"></i></div>
                    <div>Selecciona un chat para comenzar</div>
                </div>
            <?php endif; ?>
        </section>
        <?php elseif ($section === 'settings') : ?>
        <header class="toolbar">
            <div class="tol-left"><div class="date-title"><span>Configuración de APIs</span></div></div>
        </header>
        <section class="crm-content settings-reference">
            <div class="api-settings-wrap">
                <article class="api-card">
                    <div class="api-icon onurix"><img src="https://www.google.com/s2/favicons?domain=onurix.com&sz=128" alt="Onurix"></div>
                    <div class="api-content">
                        <h3>Onurix</h3>
                        <p>API para mensajería y automatización de comunicaciones para tu CRM médico.</p>
                        <button class="btn-configurar">Configurar</button>
                    </div>
                </article>
                <article class="api-card">
                    <div class="api-icon twilio"><img src="https://www.google.com/s2/favicons?domain=twilio.com&sz=128" alt="Twilio"></div>
                    <div class="api-content">
                        <h3>Twilio</h3>
                        <p>Integra llamadas, SMS y notificaciones de citas con flujos en tiempo real.</p>
                        <button class="btn-configurar">Configurar</button>
                    </div>
                </article>
                <article class="api-card">
                    <div class="api-icon siri"><img src="https://www.google.com/s2/favicons?domain=apple.com&sz=128" alt="Siri"></div>
                    <div class="api-content">
                        <h3>Siri</h3>
                        <p>Habilita comandos de voz para crear recordatorios y gestionar tareas clínicas.</p>
                        <button class="btn-configurar">Configurar</button>
                    </div>
                </article>
                <article class="api-card">
                    <div class="api-icon n8n"><img src="https://www.google.com/s2/favicons?domain=n8n.io&sz=128" alt="n8n"></div>
                    <div class="api-content">
                        <h3>n8n</h3>
                        <p>Orquesta automatizaciones entre módulos del CRM y servicios externos sin código.</p>
                        <button class="btn-configurar">Configurar</button>
                    </div>
                </article>
                <article class="api-card">
                    <div class="api-icon evolution"><img src="https://www.google.com/s2/favicons?domain=evolution-api.com&sz=128" alt="Evolution API"></div>
                    <div class="api-content">
                        <h3>Evolution API</h3>
                        <p>Conecta WhatsApp para confirmaciones de citas y seguimiento con pacientes.</p>
                        <button class="btn-configurar">Configurar</button>
                    </div>
                </article>
            </div>
            <div class="settings-extra-grid">
                <article class="settings-card settings-block">
                    <h3>Información de la empresa</h3>
                    <label>Nombre comercial <input type="text" value="Doctor IA"></label>
                    <label>NIT / Identificación <input type="text" value="900123456-7"></label>
                    <label>Dirección principal <input type="text" value="Calle 100 # 10 - 20"></label>
                    <label>Correo corporativo <input type="email" value="contacto@doctoria.com"></label>
                    <button class="btn-configurar">Guardar empresa</button>
                </article>
                <article class="settings-card settings-block">
                    <h3>Datos operativos</h3>
                    <label>Horario de atención <input type="text" value="Lun - Vie 7:00 AM a 7:00 PM"></label>
                    <label>Ciudad base <input type="text" value="Bogotá"></label>
                    <label>Moneda <input type="text" value="COP"></label>
                    <label>Soporte telefónico <input type="text" value="+57 300 500 5000"></label>
                    <button class="btn-configurar">Actualizar operación</button>
                </article>
                <article class="settings-card settings-block">
                    <h3>Branding y notificaciones</h3>
                    <label>Nombre remitente SMS <input type="text" value="DoctorIA"></label>
                    <label>Color primario <input type="text" value="#00a29a"></label>
                    <label>URL del logo <input type="text" value="https://doctoria.com/logo.png"></label>
                    <label>Plantilla WhatsApp <input type="text" value="confirmacion_cita_v1"></label>
                    <button class="btn-configurar">Guardar branding</button>
                </article>
            </div>
        </section>
        <?php elseif ($section === 'profile') : ?>
        <?php $profile = $data['profile'] ?? null; ?>
        <header class="toolbar">
            <div class="tol-left"><div class="date-title"><span>Perfil</span></div></div>
        </header>
        <section class="crm-content">
            <div class="profile-wrap">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar"><?php echo strtoupper(substr($data['user_name'], 0, 1)); ?></div>
                        <div>
                            <div class="profile-name"><?php echo htmlspecialchars($profile->name ?? $data['user_name']); ?></div>
                            <div class="profile-mail"><?php echo htmlspecialchars($profile->email ?? ''); ?></div>
                        </div>
                    </div>
                    <div class="profile-grid">
                        <label><span>Nombre</span><input type="text" value="<?php echo htmlspecialchars($profile->name ?? $data['user_name']); ?>"></label>
                        <label><span>Email</span><input type="email" value="<?php echo htmlspecialchars($profile->email ?? ''); ?>"></label>
                        <label><span>Teléfono</span><input type="text" value="+57 300 000 0000"></label>
                        <label><span>Especialidad</span><input type="text" value="Medicina general"></label>
                    </div>
                    <button class="btn-outline setting-save">Actualizar perfil</button>
                </div>
            </div>
        </section>
        <?php elseif ($section === 'patients') : ?>
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

                                <!-- Tinetti scoring parameters -->
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
        <?php elseif ($section === 'users') : ?>
        <header class="toolbar">
            <div class="tol-left"><div class="date-title"><span>Gestión de Usuarios</span></div></div>
            <div class="tol-right">
                <button class="btn-outline" id="btn-add-user"><i class="fas fa-user-plus"></i> Crear Usuario</button>
            </div>
        </header>
        <section class="crm-content">
            <div class="settings-card">
                <h3>Todos los Usuarios</h3>
                <?php if (empty($data['users'])) : ?>
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-users"></i></div>
                        <h4>No hay usuarios registrados</h4>
                        <p>Crea el primer usuario para comenzar a gestionar tu equipo.</p>
                        <button class="btn-configurar" id="btn-add-user-empty" onclick="document.getElementById('btn-add-user').click()">
                            <i class="fas fa-user-plus"></i> Crear Usuario
                        </button>
                    </div>
                <?php else : ?>
                    <table class="report-table crud-table">
                        <thead>
                            <tr>
                                <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Rol</th><th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (($data['users'] ?? []) as $u) : ?>
                                <tr class="crud-record-row">
                                    <td>#<?php echo (int)$u->id; ?></td>
                                    <td><?php echo htmlspecialchars($u->name); ?></td>
                                    <td><?php echo htmlspecialchars($u->email); ?></td>
                                    <td><?php echo htmlspecialchars($u->phone ?? 'N/A'); ?></td>
                                    <td><span class="status-chip status-<?php echo htmlspecialchars($u->role); ?>"><?php echo htmlspecialchars($u->role); ?></span></td>
                                    <td>
                                        <div class="pending-actions">
                                            <button class="btn-agendar btn-edit-user" 
                                                    data-id="<?php echo (int)$u->id; ?>"
                                                    data-name="<?php echo htmlspecialchars($u->name); ?>"
                                                    data-email="<?php echo htmlspecialchars($u->email); ?>"
                                                    data-phone="<?php echo htmlspecialchars($u->phone ?? ''); ?>"
                                                    data-role="<?php echo htmlspecialchars($u->role); ?>">Editar</button>
                                            <form action="<?php echo URLROOT; ?>/dashboard/users" method="post" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');" style="display:inline;">
                                                <input type="hidden" name="user_action" value="delete">
                                                <input type="hidden" name="user_id" value="<?php echo (int)$u->id; ?>">
                                                <button class="btn-chat" type="submit">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            
            <!-- Modal for Add/Edit User -->
            <div id="user-modal" class="calendar-modal-overlay">
                <div class="calendar-modal-card">
                    <div class="calendar-modal-head">
                        <h3 id="user-modal-title">Crear Usuario</h3>
                        <button type="button" id="user-modal-close" class="calendar-modal-close">×</button>
                    </div>
                    <form action="<?php echo URLROOT; ?>/dashboard/users" method="post" class="calendar-modal-form">
                        <input type="hidden" name="user_action" id="user-form-action" value="create">
                        <input type="hidden" name="user_id" id="user-form-id" value="0">
                        
                        <label>Nombre</label>
                        <input type="text" name="name" id="user-form-name" placeholder="Ej. Pepe Paciente" required>
                        
                        <label>Email</label>
                        <input type="email" name="email" id="user-form-email" placeholder="Ej. pepe@doctoria.com" required>
                        
                        <label>Teléfono</label>
                        <input type="text" name="phone" id="user-form-phone" placeholder="Ej. +57 300 100 0005">
                        
                        <label>Rol</label>
                        <select name="role" id="user-form-role" required>
                            <option value="cliente">Cliente</option>
                            <option value="medico">Médico</option>
                            <option value="admin">Administrador</option>
                        </select>
                        
                        <label id="user-form-pass-label">Contraseña</label>
                        <input type="password" name="password" id="user-form-password" placeholder="••••••••">
                        
                        <div class="calendar-modal-actions">
                            <button type="submit" class="btn-configurar">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <?php else : ?>
        <header class="toolbar">
            <div class="tol-left"><div class="date-title"><span>Panel de control</span></div></div>
            <div class="tol-right">
                <div class="panel-search-wrap">
                    <i class="fas fa-search"></i>
                    <input id="panel-live-search" type="text" placeholder="Buscar cita, cliente o médico...">
                </div>
                <select class="btn-outline"><option>Año actual</option></select>
                <select class="btn-outline"><option>Todos los especialistas</option></select>
                <select class="btn-outline"><option>Todas las direcciones</option></select>
            </div>
        </header>
        <section class="crm-content panel-layout">
            <div class="panel-left">
                <div class="panel-title">Citas reservadas</div>
                <div class="panel-kpi"><?php echo number_format($data['total_appointments'] ?? 0, 0, ',', '.'); ?></div>
                <div class="panel-bars">
                    <div class="bar-wrap"><div class="bar-off" style="height:68%"></div><div class="bar-on" style="height:10%"></div></div>
                    <div class="bar-wrap"><div class="bar-off" style="height:40%"></div><div class="bar-on" style="height:8%"></div></div>
                    <div class="bar-wrap"><div class="bar-off" style="height:26%"></div><div class="bar-on" style="height:5%"></div></div>
                    <div class="bar-wrap"><div class="bar-off" style="height:55%"></div><div class="bar-on" style="height:9%"></div></div>
                    <div class="bar-wrap"><div class="bar-off" style="height:48%"></div><div class="bar-on" style="height:7%"></div></div>
                    <div class="bar-wrap"><div class="bar-off" style="height:72%"></div><div class="bar-on" style="height:12%"></div></div>
                    <div class="bar-wrap"><div class="bar-off" style="height:62%"></div><div class="bar-on" style="height:10%"></div></div>
                </div>
            </div>
            <div class="panel-right">
                <div class="panel-title">Citas reservadas online</div>
                <div class="panel-kpi online"><?php echo (int) ($data['online_appointments'] ?? 0); ?> citas</div>
                <div class="panel-stat-row"><span>Citas pendientes</span><strong><?php echo (int)($data['summary']->pending ?? 0); ?></strong></div>
                <div class="panel-stat-row"><span>Citas aprobadas</span><strong><?php echo (int)($data['summary']->approved ?? 0); ?></strong></div>
                <div class="panel-title small">Dónde se reservaron</div>
                <div class="panel-stat-row"><span>Doctoralia</span><strong>70%</strong></div>
                <div class="panel-stat-row"><span>Su web</span><strong>25%</strong></div>
                <div class="panel-stat-row"><span>Buzón de voz</span><strong>5%</strong></div>
                <div class="panel-stat-row"><span>Campañas</span><strong>0%</strong></div>
            </div>
        </section>
        <section class="crm-content">
            <div class="settings-card">
                <h3>Citas por aceptar</h3>
                <div class="pending-list">
                    <?php if (empty($data['pending_appointments'])) : ?>
                        <div class="empty-state" style="padding: 20px 10px;">
                            <div class="empty-state-icon" style="font-size: 32px;"><i class="fas fa-check-circle"></i></div>
                            <h4>No hay citas por aceptar</h4>
                            <p>Todas las citas entrantes han sido procesadas.</p>
                        </div>
                    <?php else : ?>
                        <?php foreach (($data['pending_appointments'] ?? []) as $pending) : ?>
                            <div class="pending-item panel-record panel-searchable" data-title="<?php echo htmlspecialchars($pending->title); ?>" data-patient="<?php echo htmlspecialchars($pending->patient_name); ?>" data-patient-phone="<?php echo htmlspecialchars($pending->patient_phone ?? ''); ?>" data-doctor="<?php echo htmlspecialchars($pending->doctor_name); ?>" data-doctor-phone="<?php echo htmlspecialchars($pending->doctor_phone ?? ''); ?>" data-status="pending" data-description="<?php echo htmlspecialchars($pending->description ?? ''); ?>">
                                <div>
                                    <strong><?php echo htmlspecialchars($pending->title); ?></strong>
                                    <div><?php echo htmlspecialchars($pending->patient_name); ?> (<?php echo htmlspecialchars($pending->patient_phone ?? 'sin teléfono'); ?>) con <?php echo htmlspecialchars($pending->doctor_name); ?> (<?php echo htmlspecialchars($pending->doctor_phone ?? 'sin teléfono'); ?>)</div>
                                </div>
                                <?php if (!empty($data['can_approve'])) : ?>
                                    <div class="pending-actions">
                                        <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                            <input type="hidden" name="appointment_id" value="<?php echo (int)$pending->id; ?>">
                                            <input type="hidden" name="status" value="approved">
                                            <button class="btn-agendar" type="submit">Aprobar</button>
                                        </form>
                                        <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                            <input type="hidden" name="appointment_id" value="<?php echo (int)$pending->id; ?>">
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="btn-chat" type="submit">Rechazar</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="settings-card">
                <h3>Citas rechazadas</h3>
                <div class="pending-list">
                    <?php if (empty($data['rejected_appointments'])) : ?>
                        <div class="empty-state" style="padding: 20px 10px;">
                            <div class="empty-state-icon" style="font-size: 32px;"><i class="fas fa-ban"></i></div>
                            <h4>No hay citas rechazadas</h4>
                            <p>No se registran citas rechazadas en el sistema.</p>
                        </div>
                    <?php else : ?>
                        <?php foreach (($data['rejected_appointments'] ?? []) as $rejected) : ?>
                            <div class="pending-item panel-record panel-searchable" data-title="<?php echo htmlspecialchars($rejected->title); ?>" data-patient="<?php echo htmlspecialchars($rejected->patient_name); ?>" data-patient-phone="<?php echo htmlspecialchars($rejected->patient_phone ?? ''); ?>" data-doctor="<?php echo htmlspecialchars($rejected->doctor_name); ?>" data-doctor-phone="<?php echo htmlspecialchars($rejected->doctor_phone ?? ''); ?>" data-status="rejected" data-description="<?php echo htmlspecialchars($rejected->description ?? ''); ?>">
                                <div>
                                    <strong><?php echo htmlspecialchars($rejected->title); ?></strong>
                                    <div><?php echo htmlspecialchars($rejected->patient_name); ?> (<?php echo htmlspecialchars($rejected->patient_phone ?? 'sin teléfono'); ?>) con <?php echo htmlspecialchars($rejected->doctor_name); ?> (<?php echo htmlspecialchars($rejected->doctor_phone ?? 'sin teléfono'); ?>)</div>
                                </div>
                                <?php if (!empty($data['can_approve'])) : ?>
                                    <div class="pending-actions">
                                        <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                            <input type="hidden" name="appointment_id" value="<?php echo (int)$rejected->id; ?>">
                                            <input type="hidden" name="status" value="pending">
                                            <button class="btn-agendar" type="submit">Reabrir</button>
                                        </form>
                                        <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                            <input type="hidden" name="appointment_action" value="delete">
                                            <input type="hidden" name="appointment_id" value="<?php echo (int)$rejected->id; ?>">
                                            <button class="btn-chat" type="submit" onclick="return confirm('¿Seguro que deseas eliminar esta cita?');">Eliminar</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="settings-card">
                <h3>Reportes mensuales</h3>
                <table class="report-table">
                    <thead>
                        <tr><th>Mes</th><th>Total</th><th>Aprobadas</th><th>Pendientes</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach (($data['reports'] ?? []) as $report) : ?>
                            <tr>
                                <td><?php echo (int)$report->month_num; ?></td>
                                <td><?php echo (int)$report->total; ?></td>
                                <td><?php echo (int)$report->approved; ?></td>
                                <td><?php echo (int)$report->pending; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="settings-card">
                <h3>CRUD de citas</h3>
                <?php if (empty($data['appointments'])) : ?>
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-calendar-alt"></i></div>
                        <h4>No hay citas en el sistema</h4>
                        <p>Las citas aparecerán aquí cuando se agenden desde el calendario.</p>
                        <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="btn-configurar" style="width: auto; display: inline-block;">
                            <i class="fas fa-calendar-plus"></i> Ir al Calendario
                        </a>
                    </div>
                <?php else : ?>
                    <table class="report-table crud-table">
                        <thead>
                            <tr>
                                <th>ID</th><th>Título</th><th>Cliente</th><th>Médico</th><th>Teléfono</th><th>Estado</th><th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (($data['appointments'] ?? []) as $item) : ?>
                                <tr class="crud-record-row panel-record panel-searchable" data-title="<?php echo htmlspecialchars($item->title); ?>" data-patient="<?php echo htmlspecialchars($item->patient_name ?? ''); ?>" data-patient-phone="<?php echo htmlspecialchars($item->patient_phone ?? ''); ?>" data-doctor="<?php echo htmlspecialchars($item->doctor_name ?? ''); ?>" data-doctor-phone="<?php echo htmlspecialchars($item->doctor_phone ?? ''); ?>" data-status="<?php echo htmlspecialchars($item->status ?? 'pending'); ?>" data-description="<?php echo htmlspecialchars($item->description ?? ''); ?>">
                                    <td>#<?php echo (int)$item->id; ?></td>
                                    <td><?php echo htmlspecialchars($item->title); ?></td>
                                    <td><?php echo htmlspecialchars($item->patient_name ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($item->doctor_name ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($item->contact_phone ?? $item->patient_phone ?? ''); ?></td>
                                    <td><span class="status-chip status-<?php echo htmlspecialchars($item->status ?? 'pending'); ?>"><?php echo htmlspecialchars($item->status ?? 'pending'); ?></span></td>
                                    <td>
                                        <div class="pending-actions">
                                            <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                                <input type="hidden" name="appointment_id" value="<?php echo (int)$item->id; ?>">
                                                <input type="hidden" name="status" value="approved">
                                                <button class="btn-agendar" type="submit">Aprobar</button>
                                            </form>
                                            <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                                <input type="hidden" name="appointment_id" value="<?php echo (int)$item->id; ?>">
                                                <input type="hidden" name="status" value="rejected">
                                                <button class="btn-chat" type="submit">Rechazar</button>
                                            </form>
                                            <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                                <input type="hidden" name="appointment_action" value="delete">
                                                <input type="hidden" name="appointment_id" value="<?php echo (int)$item->id; ?>">
                                                <button class="btn-chat" type="submit" onclick="return confirm('¿Seguro que deseas eliminar esta cita?');">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            <div id="panel-record-modal" class="calendar-modal-overlay panel-modal-overlay">
                <div class="calendar-modal-card panel-detail-card">
                    <div class="calendar-modal-head">
                        <h3>Detalle del registro</h3>
                        <button type="button" id="panel-record-close" class="calendar-modal-close">×</button>
                    </div>
                    <div class="panel-detail-body">
                        <div class="panel-detail-row"><span>Título</span><strong id="panel-detail-title"></strong></div>
                        <div class="panel-detail-row"><span>Cliente</span><strong id="panel-detail-patient"></strong></div>
                        <div class="panel-detail-row"><span>Teléfono cliente</span><strong id="panel-detail-patient-phone"></strong></div>
                        <div class="panel-detail-row"><span>Médico</span><strong id="panel-detail-doctor"></strong></div>
                        <div class="panel-detail-row"><span>Teléfono médico</span><strong id="panel-detail-doctor-phone"></strong></div>
                        <div class="panel-detail-row"><span>Estado</span><strong id="panel-detail-status"></strong></div>
                        <div class="panel-detail-description" id="panel-detail-description"></div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>
</div>

<?php if ($section === 'calendar') : ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var dbEvents = <?php echo json_encode($data['appointments']); ?>;

    var formattedEvents = dbEvents
    .filter(function (event) {
        var title = (event.title || '').toLowerCase();
        return title !== 'disponible';
    })
    .map(function (event, index) {
        var teal = index % 2 === 0;
        if (event.status === 'pending') {
            teal = true;
        }
        return {
            title: event.title || 'Cita',
            start: event.start_date,
            end: event.end_date,
            color: event.status === 'approved' ? '#e7f0ff' : (event.status === 'rejected' ? '#fdebec' : (teal ? '#eef9f8' : '#e7f0ff')),
            textColor: event.status === 'approved' ? '#2f5faa' : (event.status === 'rejected' ? '#b83a4b' : (teal ? '#00a29a' : '#2f5faa')),
            extendedProps: {
                status: event.status || '',
                doctorName: event.doctor_name || '',
                doctorId: event.doctor_id || '',
                doctorPhone: event.doctor_phone || '',
                patientName: event.patient_name || '',
                patientId: event.patient_id || '',
                patientPhone: event.patient_phone || '',
                contactPhone: event.contact_phone || '',
                description: event.description || ''
            }
        };
    });

    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    var modal = document.getElementById('calendar-modal');
    var modalClose = document.getElementById('calendar-modal-close');
    var modalStart = document.getElementById('modal-start-date');
    var modalEnd = document.getElementById('modal-end-date');
    var modalTitle = document.getElementById('modal-title');
    var modalDescription = document.getElementById('modal-description');
    var modalAppointmentId = document.getElementById('modal-appointment-id');
    var modalAction = document.getElementById('modal-appointment-action');
    var modalDelete = document.getElementById('calendar-modal-delete');
    var modalSave = document.getElementById('calendar-modal-save');
    var modalDoctor = document.querySelector('.calendar-modal-form select[name="doctor_id"]');
    var modalPatient = document.querySelector('.calendar-modal-form select[name="patient_id"]');
    var modalContactPhone = document.getElementById('modal-contact-phone');

    function toLocalInputValue(date) {
        var d = new Date(date.getTime() - (date.getTimezoneOffset() * 60000));
        return d.toISOString().slice(0, 16);
    }

    function openModal(start, end, eventData) {
        if (!modal || !modalStart || !modalEnd) {
            return;
        }
        if (eventData) {
            modalAppointmentId.value = eventData.id || 0;
            modalTitle.value = eventData.title || 'Nueva cita';
            modalDescription.value = eventData.extendedProps.description || '';
            if (modalDoctor) {
                modalDoctor.value = eventData.extendedProps.doctorId || modalDoctor.value;
            }
            if (modalPatient) {
                modalPatient.value = eventData.extendedProps.patientId || modalPatient.value;
            }
            if (modalContactPhone) {
                modalContactPhone.value = eventData.extendedProps.contactPhone || '';
            }
            modalAction.value = 'save';
            if (modalDelete) {
                modalDelete.style.display = 'inline-flex';
            }
            if (modalSave) {
                modalSave.textContent = 'Actualizar cita';
            }
        } else {
            modalAppointmentId.value = 0;
            modalTitle.value = 'Nueva cita';
            modalDescription.value = '';
            if (modalDoctor) {
                modalDoctor.selectedIndex = 0;
            }
            if (modalPatient) {
                modalPatient.selectedIndex = 0;
            }
            if (modalContactPhone) {
                modalContactPhone.value = '';
            }
            modalAction.value = 'save';
            if (modalDelete) {
                modalDelete.style.display = 'none';
            }
            if (modalSave) {
                modalSave.textContent = 'Guardar cita';
            }
        }
        modalStart.value = toLocalInputValue(start);
        modalEnd.value = toLocalInputValue(end);
        modal.classList.add('active');
    }

    function closeModal() {
        if (modal) {
            modal.classList.remove('active');
        }
    }

    if (modalClose) {
        modalClose.addEventListener('click', closeModal);
    }

    if (modalDelete) {
        modalDelete.addEventListener('click', function () {
            if (modalAppointmentId && Number(modalAppointmentId.value) > 0) {
                modalAction.value = 'delete';
                modalDelete.closest('form').submit();
            }
        });
    }

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'es',
        initialDate: '2026-03-14',
        firstDay: 6,
        allDaySlot: false,
        selectable: true,
        slotMinTime: '07:00:00',
        slotMaxTime: '20:00:00',
        slotDuration: '00:30:00',
        headerToolbar: false,
        dayHeaderFormat: { weekday: 'short', day: 'numeric' },
        nowIndicator: false,
        expandRows: true,
        events: formattedEvents,
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
        eventContent: function(arg) {
            var doctorName = arg.event.extendedProps.doctorName || 'Sin médico';
            var patientName = arg.event.extendedProps.patientName || 'Sin cliente';
            var status = arg.event.extendedProps.status || '';
            var statusLabel = status ? status.toUpperCase() : '';
            return {
                html:
                    '<div class="fc-event-main-custom">' +
                        '<div class="fc-event-title-custom">' + arg.event.title + '</div>' +
                        '<div class="fc-event-meta">Cliente: ' + patientName + '</div>' +
                        '<div class="fc-event-meta">Tel cliente: ' + (arg.event.extendedProps.patientPhone || 'N/A') + '</div>' +
                        '<div class="fc-event-meta">Médico: ' + doctorName + '</div>' +
                        '<div class="fc-event-meta">Tel médico: ' + (arg.event.extendedProps.doctorPhone || 'N/A') + '</div>' +
                        (statusLabel ? '<div class="fc-event-status">' + statusLabel + '</div>' : '') +
                    '</div>'
            };
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            openModal(info.event.start, info.event.end, info.event);
        },
        dateClick: function(info) {
            var start = new Date(info.date);
            var end = new Date(start.getTime() + 30 * 60000);
            openModal(start, end);
        },
        select: function(info) {
            openModal(info.start, info.end);
        }
    });

    function updateTitle() {
        var title = document.getElementById('crm-title');
        var start = calendar.view.currentStart;
        var end = new Date(calendar.view.currentEnd.getTime() - 86400000);
        title.textContent = start.getDate() + ' - ' + end.getDate() + ' ' + months[end.getMonth()];
    }

    calendar.render();
    updateTitle();

    document.getElementById('crm-prev').addEventListener('click', function () {
        calendar.prev();
        updateTitle();
    });

    document.getElementById('crm-next').addEventListener('click', function () {
        calendar.next();
        updateTitle();
    });

    document.getElementById('crm-today').addEventListener('click', function () {
        calendar.today();
        updateTitle();
    });
});
</script>
<?php elseif ($section === 'panel') : ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('panel-record-modal');
    var closeBtn = document.getElementById('panel-record-close');
    var records = document.querySelectorAll('.panel-record');
    var searchInput = document.getElementById('panel-live-search');
    var searchableRecords = document.querySelectorAll('.panel-searchable');
    var title = document.getElementById('panel-detail-title');
    var patient = document.getElementById('panel-detail-patient');
    var patientPhone = document.getElementById('panel-detail-patient-phone');
    var doctor = document.getElementById('panel-detail-doctor');
    var doctorPhone = document.getElementById('panel-detail-doctor-phone');
    var status = document.getElementById('panel-detail-status');
    var description = document.getElementById('panel-detail-description');

    function openModal(record) {
        title.textContent = record.dataset.title || '';
        patient.textContent = record.dataset.patient || '';
        patientPhone.textContent = record.dataset.patientPhone || 'N/A';
        doctor.textContent = record.dataset.doctor || '';
        doctorPhone.textContent = record.dataset.doctorPhone || 'N/A';
        status.textContent = (record.dataset.status || '').toUpperCase();
        description.textContent = record.dataset.description || 'Sin descripción';
        modal.classList.add('active');
    }

    function closeModal() {
        modal.classList.remove('active');
    }

    records.forEach(function (record) {
        record.addEventListener('click', function (event) {
            if (event.target.closest('form,button,a,input')) {
                return;
            }
            openModal(record);
        });
    });

    function runSearch() {
        var query = (searchInput.value || '').trim().toLowerCase();
        searchableRecords.forEach(function (item) {
            var txt = (item.textContent || '').toLowerCase();
            item.style.display = query === '' || txt.indexOf(query) !== -1 ? '' : 'none';
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', runSearch);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }
});
</script>
<?php elseif ($section === 'users') : ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('user-modal');
    var closeBtn = document.getElementById('user-modal-close');
    var addBtn = document.getElementById('btn-add-user');
    var editBtns = document.querySelectorAll('.btn-edit-user');
    
    var formAction = document.getElementById('user-form-action');
    var formId = document.getElementById('user-form-id');
    var formName = document.getElementById('user-form-name');
    var formEmail = document.getElementById('user-form-email');
    var formPhone = document.getElementById('user-form-phone');
    var formRole = document.getElementById('user-form-role');
    var formPassword = document.getElementById('user-form-password');
    var modalTitle = document.getElementById('user-modal-title');
    var passLabel = document.getElementById('user-form-pass-label');

    function openAddModal() {
        modalTitle.textContent = 'Crear Usuario';
        formAction.value = 'create';
        formId.value = '0';
        formName.value = '';
        formEmail.value = '';
        formPhone.value = '';
        formRole.value = 'cliente';
        formPassword.value = '';
        formPassword.required = true;
        passLabel.textContent = 'Contraseña';
        modal.classList.add('active');
    }

    function openEditModal(btn) {
        modalTitle.textContent = 'Editar Usuario';
        formAction.value = 'update';
        formId.value = btn.dataset.id;
        formName.value = btn.dataset.name;
        formEmail.value = btn.dataset.email;
        formPhone.value = btn.dataset.phone;
        formRole.value = btn.dataset.role;
        formPassword.value = '';
        formPassword.required = false;
        passLabel.textContent = 'Contraseña (dejar en blanco para mantener)';
        modal.classList.add('active');
    }

    function closeModal() {
        modal.classList.remove('active');
    }

    if (addBtn) {
        addBtn.addEventListener('click', openAddModal);
    }
    editBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            openEditModal(btn);
        });
    });
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }
});
<?php elseif ($section === 'patients') : ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('patient-file-modal');
    var closeBtn = document.getElementById('patient-file-modal-close');
    var viewBtns = document.querySelectorAll('.btn-view-patient-file');
    
    // State management
    var activePatientId = 0;
    var currentStep = 1;
    var currentExpedienteId = 0;

    var antecedenteItems = [
        {key: "diabetes", label: "Diabetes", grupo: "patologico"},
        {key: "alergia", label: "Alergia", grupo: "patologico"},
        {key: "hta", label: "HTA", grupo: "patologico"},
        {key: "cancer", label: "Cáncer", grupo: "patologico"},
        {key: "marcapasos", label: "Marcapasos", grupo: "patologico"},
        {key: "reumaticas", label: "Enf. Reumáticas", grupo: "patologico"},
        {key: "encames", label: "Encames", grupo: "patologico"},
        {key: "accidentes", label: "Accidentes", grupo: "patologico"},
        {key: "cardiopatias", label: "Cardiopatías", grupo: "patologico"},
        {key: "cirugias", label: "Cirugías", grupo: "patologico"},
        {key: "fracturas", label: "Fracturas", grupo: "patologico"},
        {key: "tabaquismo", label: "Tabaquismo", grupo: "no_patologico"},
        {key: "alcoholismo", label: "Alcoholismo", grupo: "no_patologico"},
        {key: "drogas", label: "Drogas", grupo: "no_patologico"},
        {key: "actividad_fisica", label: "Actividad Física", grupo: "no_patologico"},
        {key: "embarazo", label: "Embarazo", grupo: "no_patologico"},
        {key: "hijos", label: "Hijos", grupo: "no_patologico", placeholder: "¿Cuántos?"}
    ];

    var tinettiCriteria = [
        {key: "inicio_marcha", label: "Inicio de la marcha", options: [
            {val: 0, text: "Duda, vacila o múltiples intentos para comenzar"},
            {val: 1, text: "No vacilante"}
        ]},
        {key: "paso_pd_longitud", label: "Paso pie derecho - Longitud", options: [
            {val: 0, text: "El pie derecho no sobrepasa al izquierdo con el paso"},
            {val: 1, text: "El pie derecho sobrepasa al izquierdo con el paso"}
        ]},
        {key: "paso_pd_altura", label: "Paso pie derecho - Altura", options: [
            {val: 0, text: "El pie derecho no se levanta completamente del suelo"},
            {val: 1, text: "El pie derecho se levanta completamente"}
        ]},
        {key: "paso_pi_longitud", label: "Paso pie izquierdo - Longitud", options: [
            {val: 0, text: "El pie izquierdo no sobrepasa al derecho con el paso"},
            {val: 1, text: "El pie izquierdo sobrepasa al derecho con el paso"}
        ]},
        {key: "paso_pi_altura", label: "Paso pie izquierdo - Altura", options: [
            {val: 0, text: "El pie izquierdo no se levanta completamente del suelo"},
            {val: 1, text: "El pie izquierdo se levanta completamente"}
        ]},
        {key: "simetria_paso", label: "Simetría del paso", options: [
            {val: 0, text: "La longitud del paso con el pie derecho e izquierdo es diferente"},
            {val: 1, text: "Los pasos son iguales en longitud"}
        ]},
        {key: "continuidad_pasos", label: "Continuidad de los pasos", options: [
            {val: 0, text: "Para o hay discontinuidad entre los pasos"},
            {val: 1, text: "Los pasos son continuos"}
        ]},
        {key: "trayectoria", label: "Trayectoria (Estimada en baldosas)", options: [
            {val: 0, text: "Marcada desviación"},
            {val: 1, text: "Desviación moderada, media o utiliza ayudas"},
            {val: 2, text: "Derecho sin utilizar ayudas"}
        ]},
        {key: "tronco", label: "Tronco", options: [
            {val: 0, text: "Marcado balanceo o utiliza ayudas"},
            {val: 1, text: "No balanceo pero hay flexión de espalda/brazos extensión"},
            {val: 2, text: "No balanceo ni flexión, ni utiliza ayudas"}
        ]},
        {key: "postura_marcha", label: "Postura en la marcha", options: [
            {val: 0, text: "Talones separados"},
            {val: 1, text: "Talones casi se tocan al caminar"}
        ]}
    ];

    var problemaRows = [
        {key: "dolor", label: "Dolor"},
        {key: "edema", label: "Edema"},
        {key: "limitacion_articular", label: "Limitación articular"},
        {key: "contractura", label: "Contractura"},
        {key: "supuracion", label: "Supuración"},
        {key: "infeccion", label: "Infección"},
        {key: "inmovilizacion", label: "Inmovilización"},
        {key: "ayuda_marcha", label: "Ayuda para marcha"}
    ];

    // Initialize layout components dynamically
    function renderAntecedentesList() {
        var containerA = document.getElementById('antecedentes-grupo-a');
        var containerB = document.getElementById('antecedentes-grupo-b');
        containerA.innerHTML = '';
        containerB.innerHTML = '';

        antecedenteItems.forEach(function (item) {
            var div = document.createElement('div');
            div.className = 'antecedente-item-row';
            div.style.padding = '8px 0';
            div.style.borderBottom = '1px dashed #eee';
            
            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <span style="font-weight: 500; font-size: 12px; color: #444;">${item.label}</span>
                    <div class="segmented-control" data-key="${item.key}">
                        <button type="button" class="segmented-btn" data-val="si">Sí</button>
                        <button type="button" class="segmented-btn" data-val="no">No</button>
                        <button type="button" class="segmented-btn" data-val="null">N/A</button>
                    </div>
                </div>
                <div class="spec-input-container" id="spec-container-${item.key}">
                    <input type="text" id="spec-${item.key}" placeholder="${item.placeholder || 'Especificaciones...'}" style="width: 100%; font-size: 12px; padding: 5px;">
                </div>
            `;

            // Segmented controls event listeners
            var btns = div.querySelectorAll('.segmented-btn');
            btns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var val = btn.dataset.val;
                    setSegmentedValue(item.key, val);
                    runAutosave();
                });
            });

            if (item.grupo === 'patologico') {
                containerA.appendChild(div);
            } else {
                containerB.appendChild(div);
            }
        });
    }

    function setSegmentedValue(key, val) {
        var container = document.querySelector(`.segmented-control[data-key="${key}"]`);
        if (!container) return;
        var btns = container.querySelectorAll('.segmented-btn');
        btns.forEach(function (btn) {
            btn.className = 'segmented-btn';
            if (btn.dataset.val === val) {
                btn.className = `segmented-btn active-${val}`;
            }
        });

        var specContainer = document.getElementById(`spec-container-${key}`);
        if (specContainer) {
            if (val === 'si') {
                specContainer.classList.add('active');
            } else {
                specContainer.classList.remove('active');
                var specInput = document.getElementById(`spec-${key}`);
                if (specInput) specInput.value = '';
            }
        }
        checkClinicalWarnings();
    }

    function getSegmentedValue(key) {
        var container = document.querySelector(`.segmented-control[data-key="${key}"]`);
        if (!container) return 'null';
        var active = container.querySelector('.active-si, .active-no, .active-unset');
        return active ? active.dataset.val : 'null';
    }

    function checkClinicalWarnings() {
        var marcapasos = getSegmentedValue('marcapasos') === 'si';
        var embarazo = getSegmentedValue('embarazo') === 'si';

        var badge = document.getElementById('wizard-warning-badge');
        var echo = document.getElementById('step-4-warning-echo');

        if (marcapasos || embarazo) {
            badge.style.display = 'flex';
            echo.style.display = 'flex';
        } else {
            badge.style.display = 'none';
            echo.style.display = 'none';
        }
    }

    function renderProblemasGrid() {
        var tbody = document.querySelector('#problemas-grid-table tbody');
        tbody.innerHTML = '';
        problemaRows.forEach(function (row) {
            var tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid #eee';
            tr.innerHTML = `
                <td style="padding: 6px; font-weight: 500; font-size: 12px; color: #444;">${row.label}</td>
                <td style="padding: 6px;">
                    <select id="prob-sev-${row.key}" style="width: 100%; font-size: 11px; padding: 4px;">
                        <option value="null">No especificado</option>
                        <option value="leve">Leve</option>
                        <option value="moderado">Moderado</option>
                        <option value="severo">Severo</option>
                        <option value="na">No aplica</option>
                    </select>
                </td>
                <td style="padding: 6px;">
                    <input type="text" id="prob-nota-${row.key}" placeholder="Notas..." style="width: 100%; font-size: 11px; padding: 4px;">
                </td>
            `;
            // Trigger autosave on change/blur
            tr.querySelector('select').addEventListener('change', runAutosave);
            tr.querySelector('input').addEventListener('blur', runAutosave);
            tbody.appendChild(tr);
        });
    }

    function renderTinettiContainer() {
        var container = document.getElementById('tinetti-scoring-container');
        container.innerHTML = '';
        tinettiCriteria.forEach(function (crit) {
            var div = document.createElement('div');
            div.style.marginBottom = '14px';
            div.innerHTML = `
                <span style="font-family: var(--font-heading); font-weight: bold; font-size: 12px; color: var(--slate-text); display: block; margin-bottom: 6px;">${crit.label}</span>
                <div class="tinetti-segmented-row">
                    ${crit.options.map(function (opt) {
                        return `
                            <label class="tinetti-option-card">
                                <input type="radio" name="tinetti-${crit.key}" value="${opt.val}" style="display: none;">
                                <div class="tinetti-card-content">
                                    <span class="tinetti-card-score">${opt.val} pts</span>
                                    <span class="tinetti-card-desc">${opt.text}</span>
                                </div>
                            </label>
                        `;
                    }).join('')}
                </div>
            `;

            // Radio events
            div.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                radio.addEventListener('change', function () {
                    calculateGaitTotals();
                    runAutosave();
                });
            });
            container.appendChild(div);
        });
    }

    // EVA Pain scale faces and colors mapping
    var evaSlider = document.getElementById('eva-slider-input');
    var evaLabel = document.getElementById('eva-label');
    var evaEmoji = document.getElementById('eva-emoji');

    var evaStates = {
        0: { emoji: '😊', label: 'Sin dolor', color: '#6c757d' },
        1: { emoji: '🙂', label: 'Dolor muy leve', color: '#41464b' },
        2: { emoji: '💙', label: 'Dolor leve', color: '#0d6efd' },
        3: { emoji: '😐', label: 'Dolor leve a moderado', color: '#0dcaf0' },
        4: { emoji: '💛', label: 'Dolor moderado', color: '#ffc107' },
        5: { emoji: '😕', label: 'Dolor moderado a severo', color: '#fd7e14' },
        6: { emoji: '💚', label: 'Dolor severo', color: '#198754' },
        7: { emoji: '😰', label: 'Dolor bastante severo', color: '#20c997' },
        8: { emoji: '🖤', label: 'Dolor muy severo', color: '#212529' },
        9: { emoji: '😩', label: 'Dolor casi insoportable', color: '#dc3545' },
        10: { emoji: '😭', label: 'Máximo dolor', color: '#a83232' }
    };

    function updateEvaScaleDisplay(val, isTouched) {
        if (!isTouched) {
            evaEmoji.textContent = '⚪';
            evaLabel.textContent = 'No tocado';
            evaLabel.style.color = '#888';
            return;
        }
        var state = evaStates[val] || evaStates[0];
        evaEmoji.textContent = state.emoji;
        evaLabel.textContent = `${state.label} (${val}/10)`;
        evaLabel.style.color = state.color;
    }

    var evaTouched = false;
    evaSlider.addEventListener('input', function () {
        evaTouched = true;
        updateEvaScaleDisplay(parseInt(evaSlider.value), true);
        runAutosave();
    });

    // Age Auto-compute
    var dobInput = document.getElementById('patient-fecha-nacimiento');
    var edadInput = document.getElementById('patient-edad');

    dobInput.addEventListener('change', function () {
        var birthdateStr = dobInput.value;
        if (birthdateStr) {
            var age = computeAge(birthdateStr);
            edadInput.value = age;
            edadInput.readOnly = true;
            edadInput.style.background = '#f1f3f5';
        } else {
            edadInput.value = '';
            edadInput.readOnly = false;
            edadInput.style.background = '#ffffff';
        }
        runAutosave();
    });

    function computeAge(birthdateStr) {
        if (!birthdateStr) return '';
        var today = new Date();
        var birthDate = new Date(birthdateStr);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    function syncChipsFromSelect(selectId) {
        var select = document.getElementById(selectId);
        var val = select.value;
        var container = document.querySelector(`.option-chips-container[data-target="${selectId}"]`);
        if (container) {
            var chips = container.querySelectorAll('.option-chip');
            chips.forEach(function (chip) {
                if (chip.dataset.value === val) {
                    chip.classList.add('active');
                } else {
                    chip.classList.remove('active');
                }
            });
        }
    }

    function setupOptionChips() {
        var containers = document.querySelectorAll('.option-chips-container');
        containers.forEach(function (container) {
            var targetSelectId = container.dataset.target;
            var select = document.getElementById(targetSelectId);
            if (select) {
                select.style.display = 'none'; // Hide select
                var chips = container.querySelectorAll('.option-chip');
                chips.forEach(function (chip) {
                    chip.addEventListener('click', function () {
                        select.value = chip.dataset.value;
                        var event = new Event('change');
                        select.dispatchEvent(event);
                        syncChipsFromSelect(targetSelectId);
                    });
                });
            }
        });
    }

    function updateIMCGauge() {
        var estaturaInput = document.getElementById('exploracion-estatura');
        var pesoInput = document.getElementById('exploracion-peso');
        var gaugeBlock = document.getElementById('imc-gauge-block');
        var valueBadge = document.getElementById('imc-value-badge');
        var needle = document.getElementById('imc-gauge-needle');

        if (!estaturaInput || !pesoInput || !gaugeBlock || !valueBadge || !needle) return;

        var estatura = parseFloat(estaturaInput.value);
        var peso = parseFloat(pesoInput.value);

        if (estatura > 0 && peso > 0) {
            var h = estatura / 100;
            var imc = peso / (h * h);
            gaugeBlock.style.display = 'block';

            var category = '';
            var bg = '';
            var fg = '';

            if (imc < 18.5) {
                category = 'Bajo Peso';
                bg = '#EBF8FF';
                fg = '#2B6CB0';
            } else if (imc >= 18.5 && imc < 25) {
                category = 'Saludable';
                bg = '#C6F6D5';
                fg = '#22543D';
            } else if (imc >= 25 && imc < 30) {
                category = 'Sobrepeso';
                bg = '#FEFCBF';
                fg = '#744210';
            } else {
                category = 'Obesidad';
                bg = '#FED7D7';
                fg = '#742A2A';
            }

            valueBadge.textContent = `${imc.toFixed(1)} - ${category}`;
            valueBadge.style.backgroundColor = bg;
            valueBadge.style.color = fg;

            // Map IMC range 15 to 35 onto 0% to 100%
            var pct = ((imc - 15) / (35 - 15)) * 100;
            if (pct < 0) pct = 0;
            if (pct > 100) pct = 100;
            needle.style.left = pct + '%';
        } else {
            gaugeBlock.style.display = 'none';
        }
    }

    function setupTAMask() {
        var taInput = document.getElementById('exploracion-ta');
        if (!taInput) return;
        taInput.addEventListener('input', function () {
            var val = taInput.value;
            var cleaned = val.replace(/[^\d\/]/g, '');
            if (cleaned.length === 4 && !cleaned.includes('/')) {
                cleaned = cleaned.slice(0, 3) + '/' + cleaned.slice(3);
            }
            if (cleaned !== val) {
                taInput.value = cleaned;
            }
        });
    }

    var scrollFade = document.getElementById('wizard-scroll-fade');
    function updateScrollIndicator(el) {
        if (!scrollFade || !el) return;
        var hasScroll = el.scrollHeight > el.clientHeight;
        var isNearBottom = el.scrollHeight - el.scrollTop <= el.clientHeight + 8;
        if (hasScroll && !isNearBottom) {
            scrollFade.classList.add('visible');
        } else {
            scrollFade.classList.remove('visible');
        }
    }

    // Surgical scar master toggle toggle
    var cicatrizMasterSi = document.querySelector('#cicatriz-master-control button[data-val="1"]');
    var cicatrizMasterNo = document.querySelector('#cicatriz-master-control button[data-val="0"]');
    var cicatrizContainer = document.getElementById('cicatriz-details-container');

    function setCicatrizMaster(val) {
        cicatrizMasterSi.className = 'segmented-btn';
        cicatrizMasterNo.className = 'segmented-btn';

        if (val === 1) {
            cicatrizMasterSi.className = 'segmented-btn active-si';
            cicatrizContainer.style.display = 'block';
        } else {
            cicatrizMasterNo.className = 'segmented-btn active-no';
            cicatrizContainer.style.display = 'none';
            // Clear inputs
            document.getElementById('cicatriz-sitio').value = '';
            document.getElementById('cicatriz-queloide').checked = false;
            document.getElementById('cicatriz-retractil').checked = false;
            document.getElementById('cicatriz-abierta').checked = false;
            document.getElementById('cicatriz-con-adherencia').checked = false;
            document.getElementById('cicatriz-hipertrofica').checked = false;
        }
    }

    cicatrizMasterSi.addEventListener('click', function () { setCicatrizMaster(1); runAutosave(); });
    cicatrizMasterNo.addEventListener('click', function () { setCicatrizMaster(0); runAutosave(); });

    // Repeatable plan session rows
    var planContainer = document.getElementById('treatment-sessions-container');
    var addPlanBtn = document.getElementById('btn-add-treatment-row');

    function createTreatmentRow(fechaVal, indicacionesVal) {
        var row = document.createElement('div');
        row.className = 'repeatable-row';
        row.innerHTML = `
            <button type="button" class="repeatable-row-remove">×</button>
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 10px; align-items: flex-start;">
                <div>
                    <label style="font-size: 11px; font-weight: bold; margin-bottom: 2px;">Fecha</label>
                    <input type="date" class="session-fecha" value="${fechaVal || ''}" style="padding: 4px; font-size: 11px; width: 100%;">
                </div>
                <div>
                    <label style="font-size: 11px; font-weight: bold; margin-bottom: 2px;">Indicaciones (frecuencia y duración)</label>
                    <textarea class="session-indicaciones" rows="1" style="padding: 4px; font-size: 11px; width: 100%; border: 1px solid #ccc; border-radius: 4px; resize: vertical;">${indicacionesVal || ''}</textarea>
                </div>
            </div>
        `;

        row.querySelector('.repeatable-row-remove').addEventListener('click', function () {
            row.remove();
            runAutosave();
        });

        row.querySelector('.session-fecha').addEventListener('change', runAutosave);
        row.querySelector('.session-indicaciones').addEventListener('blur', runAutosave);

        planContainer.appendChild(row);
    }

    addPlanBtn.addEventListener('click', function () {
        createTreatmentRow('', '');
    });

    // Gait score checkboxes toggle showing specific inputs
    var gaitOtrosCheck = document.getElementById('gait-otros');
    var gaitOtrosSpecContainer = document.getElementById('gait-otros-spec-container');
    gaitOtrosCheck.addEventListener('change', function () {
        gaitOtrosSpecContainer.style.display = gaitOtrosCheck.checked ? 'block' : 'none';
        if (!gaitOtrosCheck.checked) {
            document.getElementById('gait-otros-spec').value = '';
        }
        runAutosave();
    });

    // Tinetti & totals calculator
    var balanceInput = document.getElementById('score-balance-manual');
    balanceInput.addEventListener('input', function () {
        calculateGaitTotals();
        runAutosave();
    });

    function calculateGaitTotals() {
        var totalMarcha = 0;
        tinettiCriteria.forEach(function (crit) {
            var radios = document.getElementsByName(`tinetti-${crit.key}`);
            radios.forEach(function (radio) {
                if (radio.checked) {
                    totalMarcha += parseInt(radio.value);
                }
            });
        });

        var totalBalance = parseInt(balanceInput.value) || 0;
        if (totalBalance < 0) totalBalance = 0;
        if (totalBalance > 16) totalBalance = 16;
        balanceInput.value = totalBalance;

        var grandTotal = totalMarcha + totalBalance;

        document.getElementById('score-marcha-val').textContent = totalMarcha;
        document.getElementById('score-general-val').textContent = grandTotal;

        var riskBadge = document.getElementById('tinetti-risk-badge');
        if (grandTotal < 19) {
            riskBadge.className = 'status-chip status-rejected';
            riskBadge.textContent = 'Alto Riesgo de Caídas (<19)';
        } else if (grandTotal >= 19 && grandTotal <= 24) {
            riskBadge.className = 'status-chip status-pending';
            riskBadge.textContent = 'Riesgo Moderado (19-24)';
        } else {
            riskBadge.className = 'status-chip status-approved';
            riskBadge.textContent = 'Bajo Riesgo (25+)';
        }

        // Upgraded SVG Ring updates
        var svgRing = document.getElementById('tinetti-svg-ring');
        var svgText = document.getElementById('tinetti-svg-text');
        var riskText = document.getElementById('tinetti-risk-badge-text');

        if (svgRing && svgText && riskText) {
            svgText.textContent = `${grandTotal}/28`;
            var pct = (grandTotal / 28) * 100;
            svgRing.style.strokeDasharray = `${pct}, 100`;

            if (grandTotal < 19) {
                svgRing.style.stroke = '#D66F7C'; // var(--critical-rose)
                riskText.textContent = 'Alto Riesgo de Caída';
                riskText.style.color = '#D66F7C';
            } else if (grandTotal >= 19 && grandTotal <= 24) {
                svgRing.style.stroke = '#E5A87B'; // var(--warning-ochre)
                riskText.textContent = 'Riesgo Moderado';
                riskText.style.color = '#E5A87B';
            } else {
                svgRing.style.stroke = '#7FB8A6'; // var(--brand-green-success)
                riskText.textContent = 'Bajo Riesgo';
                riskText.style.color = '#7FB8A6';
            }
        }
    }

    // Modal view initialization trigger
    viewBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var patientId = parseInt(btn.dataset.id);
            activePatientId = patientId;
            openWizard(patientId);
        });
    });

    function populateForm(data) {
        // Populate Step 1 (Datos del Paciente)
        document.getElementById('patient-name').value = data.patient.name || '';
        document.getElementById('patient-ocupacion').value = data.patient.ocupacion || '';
        document.getElementById('patient-fecha-nacimiento').value = data.patient.fecha_nacimiento || '';
        document.getElementById('patient-edad').value = data.patient.fecha_nacimiento ? computeAge(data.patient.fecha_nacimiento) : '';
        document.getElementById('patient-sexo').value = data.patient.sexo || '';
        syncChipsFromSelect('patient-sexo');
        document.getElementById('patient-estado-civil').value = data.patient.estado_civil || '';
        syncChipsFromSelect('patient-estado-civil');
        document.getElementById('patient-domicilio').value = data.patient.domicilio || '';
        document.getElementById('patient-tel').value = data.patient.tel || '';
        document.getElementById('patient-cel').value = data.patient.cel || '';
        document.getElementById('patient-familiar-responsable').value = data.patient.familiar_responsable || '';
        document.getElementById('patient-familiar-tel-cel').value = data.patient.familiar_cel || data.patient.familiar_tel || '';

        // Populate Step 2 (Antecedentes)
        if (data.antecedentes && data.antecedentes.length > 0) {
            data.antecedentes.forEach(function (ant) {
                setSegmentedValue(ant.item_key, ant.valor);
                var specInput = document.getElementById(`spec-${ant.item_key}`);
                if (specInput) specInput.value = ant.especificacion || '';
            });
        } else {
            antecedenteItems.forEach(function(item) {
                setSegmentedValue(item.key, 'null');
            });
        }

        // Populate Step 3
        if (data.exploracion) {
            document.getElementById('exploracion-estatura').value = data.exploracion.estatura_cm || '';
            document.getElementById('exploracion-peso').value = data.exploracion.peso_kg || '';
            document.getElementById('exploracion-ta').value = data.exploracion.ta || '';
            document.getElementById('exploracion-fc').value = data.exploracion.fc || '';
            document.getElementById('exploracion-fr').value = data.exploracion.fr || '';
            document.getElementById('exploracion-arcos').value = data.exploracion.arcos_movimiento || '';
            document.getElementById('exploracion-fuerza').value = data.exploracion.fuerza_muscular || '';
            document.getElementById('exploracion-reflejos').value = data.exploracion.reflejos || '';
            document.getElementById('exploracion-sensibilidad').value = data.exploracion.sensibilidad || '';
            document.getElementById('exploracion-lenguaje-orientacion').value = data.exploracion.lenguaje_orientacion || '';
            document.getElementById('exploracion-otros').value = data.exploracion.otros || '';
            updateIMCGauge();
        }

        if (data.cicatriz) {
            setCicatrizMaster(parseInt(data.cicatriz.presenta));
            document.getElementById('cicatriz-sitio').value = data.cicatriz.sitio || '';
            document.getElementById('cicatriz-queloide').checked = data.cicatriz.queloide === 'si';
            document.getElementById('cicatriz-retractil').checked = data.cicatriz.retractil === 'si';
            document.getElementById('cicatriz-abierta').checked = data.cicatriz.abierta === 'si';
            document.getElementById('cicatriz-con-adherencia').checked = data.cicatriz.con_adherencia === 'si';
            document.getElementById('cicatriz-hipertrofica').checked = data.cicatriz.hipertrofica === 'si';
        }

        if (data.padecimiento) {
            document.getElementById('padecimiento-motivo').value = data.padecimiento.motivo_consulta || '';
            document.getElementById('padecimiento-inicio').value = data.padecimiento.inicio || '';
            document.getElementById('padecimiento-evolucion').value = data.padecimiento.evolucion || '';
            document.getElementById('padecimiento-estudios').value = data.padecimiento.estudios || '';
            document.getElementById('padecimiento-tratamientos').value = data.padecimiento.tratamientos_previos || '';
        }

        var eva_val = data.expediente ? data.expediente.eva_dolor : null;
        if (data.eva_dolor !== undefined) eva_val = data.eva_dolor;
        
        if (eva_val !== null && eva_val !== undefined) {
            evaTouched = true;
            evaSlider.value = eva_val;
            updateEvaScaleDisplay(eva_val, true);
        } else {
            evaTouched = false;
            evaSlider.value = 0;
            updateEvaScaleDisplay(0, false);
        }

        if (data.problemas && data.problemas.length > 0) {
            data.problemas.forEach(function (prob) {
                var sevSelect = document.getElementById(`prob-sev-${prob.item_key}`);
                var noteInput = document.getElementById(`prob-nota-${prob.item_key}`);
                if (sevSelect) sevSelect.value = prob.severidad || 'null';
                if (noteInput) noteInput.value = prob.nota || '';
            });
        }

        // Populate Step 4
        planContainer.innerHTML = '';
        if (data.plan_sesiones && data.plan_sesiones.length > 0) {
            data.plan_sesiones.forEach(function (ses) {
                createTreatmentRow(ses.fecha, ses.indicaciones);
            });
        } else {
            createTreatmentRow('', '');
        }
        
        var notes_val = data.expediente ? data.expediente.notas_generales : '';
        if (data.notas_generales !== undefined) notes_val = data.notas_generales;
        document.getElementById('expediente-notas-generales').value = notes_val || '';

        // Populate Step 5
        if (data.marcha) {
            document.getElementById('gait-libre').checked = parseInt(data.marcha.libre) === 1;
            document.getElementById('gait-claudicante').checked = parseInt(data.marcha.claudicante) === 1;
            document.getElementById('gait-con-ayuda').checked = parseInt(data.marcha.con_ayuda) === 1;
            document.getElementById('gait-espasticas').checked = parseInt(data.marcha.espasticas) === 1;
            document.getElementById('gait-ataxica').checked = parseInt(data.marcha.ataxica) === 1;
            document.getElementById('gait-otros').checked = parseInt(data.marcha.otros) === 1;
            gaitOtrosSpecContainer.style.display = data.marcha.otros ? 'block' : 'none';
            document.getElementById('gait-otros-spec').value = data.marcha.otros_spec || '';
            document.getElementById('gait-observaciones').value = data.marcha.observaciones || '';

            tinettiCriteria.forEach(function (crit) {
                var val = data.marcha[crit.key];
                if (val !== null && val !== undefined && val !== '') {
                    var radio = document.querySelector(`input[name="tinetti-${crit.key}"][value="${val}"]`);
                    if (radio) radio.checked = true;
                }
            });

            balanceInput.value = data.marcha.total_balance_manual !== null ? data.marcha.total_balance_manual : 0;
            calculateGaitTotals();
        }

        checkClinicalWarnings();
    }

    function openWizard(patientId) {
        currentStep = 1;
        showStep(1);
        
        // Render empty lists
        renderAntecedentesList();
        renderProblemasGrid();
        renderTinettiContainer();
        planContainer.innerHTML = '';
        
        updateAutosaveUI('saving', 'Cargando expediente...');

        // Check localStorage first (GC-5)
        var localDraftStr = localStorage.getItem(`expediente_draft_${patientId}`);
        var useLocal = false;
        
        if (localDraftStr) {
            try {
                var localDraft = JSON.parse(localDraftStr);
                if (localDraft && localDraft.data && localDraft.data.patient.name) {
                    if (confirm('Se encontró un borrador local más reciente de este expediente. ¿Desea restaurarlo?')) {
                        populateForm(localDraft.data);
                        useLocal = true;
                        updateAutosaveUI('saved', 'Borrador local restaurado');
                        modal.classList.add('active');
                    }
                }
            } catch (e) {
                console.error(e);
            }
        }

        if (useLocal) return;

        fetch(`<?php echo URLROOT; ?>/dashboard/loadExpediente/${patientId}`)
            .then(function (res) { return res.json(); })
            .then(function (data) {
                currentExpedienteId = data.expediente.id;
                populateForm(data);
                updateAutosaveUI('saved', 'Expediente cargado');
                modal.classList.add('active');
            })
            .catch(function (err) {
                console.error(err);
                updateAutosaveUI('error', 'Error al cargar');
            });
    }

    // Step Switching Logic
    var indicators = document.querySelectorAll('.wizard-step-indicator');
    
    function showStep(stepNum) {
        currentStep = stepNum;
        document.querySelectorAll('.wizard-step-content').forEach(function (content) {
            content.classList.remove('active');
        });
        document.getElementById(`step-content-${stepNum}`).classList.add('active');

        indicators.forEach(function (ind) {
            ind.classList.remove('active');
            var indStep = parseInt(ind.dataset.step);
            if (indStep === stepNum) {
                ind.classList.add('active');
            } else if (indStep < stepNum) {
                ind.classList.add('visited');
            }
        });

        // Toggle buttons
        var prevBtn = document.getElementById('wizard-btn-prev');
        var nextBtn = document.getElementById('wizard-btn-next');
        var saveBtn = document.getElementById('wizard-btn-save');
        var label = document.getElementById('wizard-step-label');

        prevBtn.style.display = stepNum === 1 ? 'none' : 'block';
        if (stepNum === 5) {
            nextBtn.style.display = 'none';
            saveBtn.style.display = 'block';
        } else {
            nextBtn.style.display = 'block';
            saveBtn.style.display = 'none';
        }
        label.textContent = `Paso ${stepNum} de 5`;

        var activeContent = document.getElementById(`step-content-${stepNum}`);
        if (activeContent) {
            updateScrollIndicator(activeContent);
        }
    }

    document.getElementById('wizard-btn-prev').addEventListener('click', function () {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });

    document.getElementById('wizard-btn-next').addEventListener('click', function () {
        if (currentStep < 5) {
            showStep(currentStep + 1);
        }
    });

    indicators.forEach(function (ind) {
        ind.addEventListener('click', function () {
            var stepNum = parseInt(ind.dataset.step);
            showStep(stepNum);
        });
    });

    // Collect values from the DOM form and compile payload
    function collectFormPayload() {
        var payload = {
            patient: {
                name: document.getElementById('patient-name').value,
                ocupacion: document.getElementById('patient-ocupacion').value,
                fecha_nacimiento: document.getElementById('patient-fecha-nacimiento').value,
                sexo: document.getElementById('patient-sexo').value,
                estado_civil: document.getElementById('patient-estado-civil').value,
                domicilio: document.getElementById('patient-domicilio').value,
                phone: document.getElementById('patient-cel').value || document.getElementById('patient-tel').value || '',
                tel: document.getElementById('patient-tel').value,
                cel: document.getElementById('patient-cel').value,
                familiar_responsable: document.getElementById('patient-familiar-responsable').value,
                familiar_tel: document.getElementById('patient-familiar-tel-cel').value,
                familiar_cel: document.getElementById('patient-familiar-tel-cel').value
            },
            expediente: {
                eva_dolor: evaTouched ? parseInt(evaSlider.value) : null,
                notas_generales: document.getElementById('expediente-notas-generales').value,
                notas_plan: ''
            },
            antecedentes: antecedenteItems.map(function (item) {
                var val = getSegmentedValue(item.key);
                var spec = document.getElementById(`spec-${item.key}`).value;
                return {
                    grupo: item.grupo,
                    item_key: item.key,
                    valor: val,
                    especificacion: spec
                };
            }),
            exploracion: {
                estatura_cm: document.getElementById('exploracion-estatura').value,
                peso_kg: document.getElementById('exploracion-peso').value,
                ta: document.getElementById('exploracion-ta').value,
                fc: document.getElementById('exploracion-fc').value,
                fr: document.getElementById('exploracion-fr').value,
                arcos_movimiento: document.getElementById('exploracion-arcos').value,
                fuerza_muscular: document.getElementById('exploracion-fuerza').value,
                reflejos: document.getElementById('exploracion-reflejos').value,
                sensibilidad: document.getElementById('exploracion-sensibilidad').value,
                lenguaje_orientacion: document.getElementById('exploracion-lenguaje-orientacion').value,
                otros: document.getElementById('exploracion-otros').value
            },
            cicatriz: {
                presenta: document.querySelector('#cicatriz-master-control .active-si') ? 1 : 0,
                sitio: document.getElementById('cicatriz-sitio').value,
                queloide: document.getElementById('cicatriz-queloide').checked ? 'si' : 'no',
                retractil: document.getElementById('cicatriz-retractil').checked ? 'si' : 'no',
                abierta: document.getElementById('cicatriz-abierta').checked ? 'si' : 'no',
                con_adherencia: document.getElementById('cicatriz-con-adherencia').checked ? 'si' : 'no',
                hipertrofica: document.getElementById('cicatriz-hipertrofica').checked ? 'si' : 'no'
            },
            padecimiento: {
                motivo_consulta: document.getElementById('padecimiento-motivo').value,
                inicio: document.getElementById('padecimiento-inicio').value,
                evolucion: document.getElementById('padecimiento-evolucion').value,
                estudios: document.getElementById('padecimiento-estudios').value,
                tratamientos_previos: document.getElementById('padecimiento-tratamientos').value
            },
            problemas: problemaRows.map(function (row) {
                return {
                    item_key: row.key,
                    severidad: document.getElementById(`prob-sev-${row.key}`).value,
                    nota: document.getElementById(`prob-nota-${row.key}`).value
                };
            }),
            plan_sesiones: Array.from(document.querySelectorAll('#treatment-sessions-container .repeatable-row')).map(function (row) {
                return {
                    fecha: row.querySelector('.session-fecha').value,
                    indicaciones: row.querySelector('.session-indicaciones').value
                };
            }),
            marcha: {
                libre: document.getElementById('gait-libre').checked ? 1 : 0,
                claudicante: document.getElementById('gait-claudicante').checked ? 1 : 0,
                con_ayuda: document.getElementById('gait-con-ayuda').checked ? 1 : 0,
                espasticas: document.getElementById('gait-espasticas').checked ? 1 : 0,
                ataxica: document.getElementById('gait-ataxica').checked ? 1 : 0,
                otros: document.getElementById('gait-otros').checked ? 1 : 0,
                otros_spec: document.getElementById('gait-otros-spec').value,
                observaciones: document.getElementById('gait-observaciones').value,
                
                inicio_marcha: getRadioValue('tinetti-inicio_marcha'),
                paso_pd_longitud: getRadioValue('tinetti-paso_pd_longitud'),
                paso_pd_altura: getRadioValue('tinetti-paso_pd_altura'),
                paso_pi_longitud: getRadioValue('tinetti-paso_pi_longitud'),
                paso_pi_altura: getRadioValue('tinetti-paso_pi_altura'),
                simetria_paso: getRadioValue('tinetti-simetria_paso'),
                continuidad_pasos: getRadioValue('tinetti-continuidad_pasos'),
                trayectoria: getRadioValue('tinetti-trayectoria'),
                tronco: getRadioValue('tinetti-tronco'),
                postura_marcha: getRadioValue('tinetti-postura_marcha'),
                total_balance_manual: document.getElementById('score-balance-manual').value
            }
        };
        return payload;
    }

    function getRadioValue(name) {
        var el = document.querySelector(`input[name="${name}"]:checked`);
        return el ? parseInt(el.value) : '';
    }

    function updateAutosaveUI(state, text) {
        var dot = document.getElementById('autosave-glow-dot');
        var txt = document.getElementById('autosave-text');
        if (!dot || !txt) return;

        txt.textContent = text;
        dot.className = 'autosave-glow-dot'; // reset
        if (state === 'saving') {
            dot.classList.add('saving');
        } else if (state === 'error') {
            dot.classList.add('error');
        }
    }

    // Server Autosave / local storage mirroring (GC-5)
    var saveTimeout = null;
    function runAutosave() {
        // Save to localStorage immediately
        var payload = collectFormPayload();
        if (activePatientId) {
            localStorage.setItem(`expediente_draft_${activePatientId}`, JSON.stringify({
                timestamp: Date.now(),
                data: payload
            }));
        }

        if (saveTimeout) clearTimeout(saveTimeout);
        saveTimeout = setTimeout(function () {
            var offlineBanner = document.getElementById('wizard-offline-banner');

            if (!navigator.onLine) {
                updateAutosaveUI('error', 'Guardado localmente');
                offlineBanner.style.display = 'inline-flex';
                return;
            }

            updateAutosaveUI('saving', 'Guardando...');
            offlineBanner.style.display = 'none';

            if (!payload.patient.name) return; // // GC-4 name required

            fetch(`<?php echo URLROOT; ?>/dashboard/saveExpediente/${activePatientId}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.status === 'success') {
                    var now = new Date();
                    var timeStr = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    updateAutosaveUI('saved', `Guardado a las ${timeStr}`);
                } else {
                    updateAutosaveUI('error', 'Error al guardar');
                }
            })
            .catch(function () {
                updateAutosaveUI('error', 'Error de conexión (Guardado local)');
                offlineBanner.style.display = 'inline-flex';
            });
        }, 1000);
    }

    setupOptionChips();
    setupTAMask();

    document.querySelectorAll('.wizard-step-content').forEach(function (content) {
        content.addEventListener('scroll', function () {
            updateScrollIndicator(content);
        });
    });

    var estInput = document.getElementById('exploracion-estatura');
    var pesInput = document.getElementById('exploracion-peso');
    if (estInput) {
        estInput.addEventListener('input', updateIMCGauge);
        estInput.addEventListener('change', updateIMCGauge);
    }
    if (pesInput) {
        pesInput.addEventListener('input', updateIMCGauge);
        pesInput.addEventListener('change', updateIMCGauge);
    }

    // Attach autosave triggers to Step 1 fields on change / blur
    var inputs = [
        'patient-name', 'patient-ocupacion', 'patient-fecha-nacimiento',
        'patient-sexo', 'patient-estado-civil', 'patient-domicilio',
        'patient-tel', 'patient-cel', 'patient-familiar-responsable', 'patient-familiar-tel-cel',
        'exploracion-estatura', 'exploracion-peso', 'exploracion-ta',
        'exploracion-fc', 'exploracion-fr', 'exploracion-arcos', 'exploracion-fuerza',
        'exploracion-reflejos', 'exploracion-sensibilidad', 'exploracion-lenguaje-orientacion', 'exploracion-otros',
        'cicatriz-sitio', 'padecimiento-motivo', 'padecimiento-inicio',
        'padecimiento-evolucion', 'padecimiento-estudios', 'padecimiento-tratamientos',
        'expediente-notas-generales', 'gait-observaciones', 'gait-otros-spec'
    ];

    inputs.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('blur', runAutosave);
            el.addEventListener('change', runAutosave);
        }
    });

    // Checkboxes click events
    var checks = [
        'cicatriz-queloide', 'cicatriz-retractil', 'cicatriz-abierta', 'cicatriz-con-adherencia', 'cicatriz-hipertrofica',
        'gait-libre', 'gait-claudicante', 'gait-con-ayuda', 'gait-espasticas', 'gait-ataxica'
    ];
    checks.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', runAutosave);
        }
    });

    document.getElementById('wizard-btn-save').addEventListener('click', function () {
        runAutosave();
        closeModal();
    });

    function closeModal() {
        modal.classList.remove('active');
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    // Client-side live search for patients
    var searchInput = document.getElementById('patient-live-search');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var query = (searchInput.value || '').toLowerCase().trim();
            var rows = document.querySelectorAll('#patients-table tbody tr');
            rows.forEach(function (row) {
                var text = (row.textContent || '').toLowerCase();
                row.style.display = query === '' || text.indexOf(query) !== -1 ? '' : 'none';
            });
        });
    }
    window.addEventListener('online', function () {
        var offlineBanner = document.getElementById('wizard-offline-banner');
        if (offlineBanner) offlineBanner.style.display = 'none';
        runAutosave();
    });

    window.addEventListener('offline', function () {
        var offlineBanner = document.getElementById('wizard-offline-banner');
        if (offlineBanner) offlineBanner.style.display = 'inline-flex';
        updateAutosaveUI('error', 'Guardado localmente');
    });
});
</script>
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
