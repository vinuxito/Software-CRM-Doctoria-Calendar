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
                $isError = preg_match('/(error|incorrecto|ya está|no puedes|no válido|campos obligatorios|completados)/i', $data['flash']);
                $flashClass = $isError ? 'calendar-flash flash-danger' : 'calendar-flash flash-success';
                $flashIcon = $isError ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
            ?>
            <div class="<?php echo $flashClass; ?>" style="display: flex; align-items: center; gap: 10px; padding: 12px 15px; margin: 15px; border-radius: 6px; font-weight: 500; font-size: 14px; background: <?php echo $isError ? '#f8d7da' : '#d1e7dd'; ?>; color: <?php echo $isError ? '#842029' : '#0f5132'; ?>; border: 1px solid <?php echo $isError ? '#f5c2c7' : '#badbcc'; ?>;">
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
            </div>
            
            <!-- Modal for Patient Clinical File -->
            <div id="patient-file-modal" class="calendar-modal-overlay">
                <div class="calendar-modal-card" style="max-width: 900px; width: 90%;">
                    <div class="calendar-modal-head">
                        <h3>Expediente Clínico Digital</h3>
                        <button type="button" id="patient-file-modal-close" class="calendar-modal-close">×</button>
                    </div>
                    <form action="<?php echo URLROOT; ?>/dashboard/patients" method="post" class="calendar-modal-form">
                        <input type="hidden" name="patient_id" id="patient-form-id" value="0">
                        
                        <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 20px;">
                            <!-- Left Column: Patient File Form -->
                            <div>
                                <h4 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px; color: #333;"><i class="fas fa-id-card"></i> Datos Clínicos & Personales</h4>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                    <div>
                                        <label>Nombre</label>
                                        <input type="text" name="name" id="patient-form-name" required>
                                    </div>
                                    <div>
                                        <label>Email</label>
                                        <input type="email" name="email" id="patient-form-email" required>
                                    </div>
                                </div>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
                                    <div>
                                        <label>Teléfono</label>
                                        <input type="text" name="phone" id="patient-form-phone">
                                    </div>
                                    <div>
                                        <label>Fecha de Nacimiento</label>
                                        <input type="date" name="dob" id="patient-form-dob">
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 10px; margin-top: 10px;">
                                    <div>
                                        <label>Dirección de Residencia</label>
                                        <input type="text" name="address" id="patient-form-address" placeholder="Ej. Calle 45 #12-34">
                                    </div>
                                    <div>
                                        <label>Grupo Sanguíneo</label>
                                        <select name="blood_type" id="patient-form-blood-type">
                                            <option value="">No definido</option>
                                            <option value="O+">O Positivo (O+)</option>
                                            <option value="O-">O Negativo (O-)</option>
                                            <option value="A+">A Positivo (A+)</option>
                                            <option value="A-">A Negativo (A-)</option>
                                            <option value="B+">B Positivo (B+)</option>
                                            <option value="B-">B Negativo (B-)</option>
                                            <option value="AB+">AB Positivo (AB+)</option>
                                            <option value="AB-">AB Negativo (AB-)</option>
                                        </select>
                                    </div>
                                </div>

                                <label style="margin-top: 10px;">Alergias & Contraindicaciones</label>
                                <textarea name="allergies" id="patient-form-allergies" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;" placeholder="Ej. Penicilina, AINEs..."></textarea>

                                <label style="margin-top: 10px;">Antecedentes Médicos</label>
                                <textarea name="medical_history" id="patient-form-medical-history" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;" placeholder="Ej. Hipertensión arterial, Diabetes tipo 2..."></textarea>

                                <label style="margin-top: 10px;">Medicamentos Activos</label>
                                <textarea name="medications" id="patient-form-medications" rows="2" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;" placeholder="Ej. Losartán 50mg/día..."></textarea>

                                <label style="margin-top: 10px;">Notas Clínicas / Observaciones</label>
                                <textarea name="clinical_notes" id="patient-form-clinical-notes" rows="3" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 6px;" placeholder="Anotaciones de la última consulta..."></textarea>
                            </div>
                            
                            <!-- Right Column: Medical Context (Appointments list) -->
                            <div style="background: #f8f9fa; border-radius: 6px; padding: 15px; border: 1px solid #e9ecef; display: flex; flex-direction: column;">
                                <h4 style="margin-bottom: 12px; border-bottom: 1px solid #ddd; padding-bottom: 5px; color: #333;"><i class="far fa-calendar-alt"></i> Historial de Citas</h4>
                                <div id="patient-appointments-history" style="flex: 1; overflow-y: auto; max-height: 400px; display: flex; flex-direction: column; gap: 8px;">
                                    <!-- Populated dynamically via JS -->
                                    <div style="text-align: center; color: #888; margin-top: 20px;">Seleccione un paciente para ver su historial</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="calendar-modal-actions" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                            <button type="submit" class="btn-configurar"><i class="fas fa-save"></i> Guardar Expediente</button>
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
                </div>
            </div>
            <div class="settings-card">
                <h3>Citas rechazadas</h3>
                <div class="pending-list">
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
                                        <button class="btn-chat" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
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
                                            <button class="btn-chat" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
    
    var formId = document.getElementById('patient-form-id');
    var formName = document.getElementById('patient-form-name');
    var formEmail = document.getElementById('patient-form-email');
    var formPhone = document.getElementById('patient-form-phone');
    var formDob = document.getElementById('patient-form-dob');
    var formAddress = document.getElementById('patient-form-address');
    var formBloodType = document.getElementById('patient-form-blood-type');
    var formAllergies = document.getElementById('patient-form-allergies');
    var formMedicalHistory = document.getElementById('patient-form-medical-history');
    var formMedications = document.getElementById('patient-form-medications');
    var formClinicalNotes = document.getElementById('patient-form-clinical-notes');
    
    var appointmentsHistory = document.getElementById('patient-appointments-history');
    
    // Load all appointments passed from PHP controller
    var dbAppointments = <?php echo json_encode($data['appointments'] ?? []); ?>;

    function openPatientModal(btn) {
        var patientId = parseInt(btn.dataset.id);
        
        formId.value = patientId;
        formName.value = btn.dataset.name;
        formEmail.value = btn.dataset.email;
        formPhone.value = btn.dataset.phone;
        formDob.value = btn.dataset.dob;
        formAddress.value = btn.dataset.address;
        formBloodType.value = btn.dataset.blood_type;
        formAllergies.value = btn.dataset.allergies;
        formMedicalHistory.value = btn.dataset.medical_history;
        formMedications.value = btn.dataset.medications;
        formClinicalNotes.value = btn.dataset.clinical_notes;
        
        // Render appointments history
        renderAppointmentsHistory(patientId);
        
        modal.classList.add('active');
    }

    function renderAppointmentsHistory(patientId) {
        appointmentsHistory.innerHTML = '';
        var patientApps = dbAppointments.filter(function (app) {
            return parseInt(app.patient_id) === patientId;
        });

        if (patientApps.length === 0) {
            appointmentsHistory.innerHTML = '<div style="text-align: center; color: #888; margin-top: 20px; font-size: 13px;">No hay citas registradas para este paciente.</div>';
            return;
        }

        patientApps.forEach(function (app) {
            var dateObj = new Date(app.start_date);
            var dateStr = dateObj.toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
            var timeStr = dateObj.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            
            var statusColors = {
                'pending': { bg: '#fff3cd', text: '#664d03', border: '#ffe69c' },
                'approved': { bg: '#d1e7dd', text: '#0f5132', border: '#badbcc' },
                'rejected': { bg: '#f8d7da', text: '#842029', border: '#f5c2c7' },
                'completed': { bg: '#e2e3e5', text: '#41464b', border: '#d3d6d8' }
            };
            var status = app.status || 'pending';
            var colors = statusColors[status] || statusColors['pending'];
            
            var card = document.createElement('div');
            card.style.background = '#ffffff';
            card.style.border = '1px solid #e9ecef';
            card.style.borderRadius = '5px';
            card.style.padding = '10px 12px';
            card.style.display = 'flex';
            card.style.flexDirection = 'column';
            card.style.gap = '4px';
            card.style.boxShadow = '0 1px 2px rgba(0,0,0,0.02)';
            
            card.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <strong style="color: #333; font-size: 13px;">${app.title}</strong>
                    <span style="font-size: 10px; font-weight: bold; text-transform: uppercase; padding: 2px 6px; border-radius: 4px; background: ${colors.bg}; color: ${colors.text}; border: 1px solid ${colors.border};">${status}</span>
                </div>
                <div style="font-size: 12px; color: #555;">
                    <i class="far fa-clock"></i> ${dateStr} a las ${timeStr}
                </div>
                <div style="font-size: 11px; color: #777;">
                    Médico: ${app.doctor_name}
                </div>
                ${app.description ? `<div style="font-size: 11px; color: #888; font-style: italic; margin-top: 2px; border-left: 2px solid #ddd; padding-left: 5px;">${app.description}</div>` : ''}
            `;
            appointmentsHistory.appendChild(card);
        });
    }

    function closeModal() {
        modal.classList.remove('active');
    }

    viewBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            openPatientModal(btn);
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
});
</script>
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
