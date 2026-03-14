<?php require APPROOT . '/views/inc/header.php'; ?>
<?php $section = $data['section'] ?? 'calendar'; ?>
<div class="crm-calendar-shell">
    <nav class="icon-sidebar">
        <div class="brand-icon">
            <img src="<?php echo URLROOT; ?>/../img/logo.png" alt="Logo">
        </div>
        <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="nav-icon <?php echo $section === 'calendar' ? 'active' : ''; ?>"><i class="far fa-calendar-alt"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/doctors" class="nav-icon <?php echo $section === 'doctors' ? 'active' : ''; ?>"><i class="far fa-user"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/chat" class="nav-icon <?php echo $section === 'chat' ? 'active' : ''; ?>"><i class="far fa-comment"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/panel" class="nav-icon <?php echo $section === 'panel' ? 'active' : ''; ?>"><i class="far fa-chart-bar"></i></a>
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
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
