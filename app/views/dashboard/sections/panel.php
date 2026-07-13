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
                                    <?php csrfField(); ?>
                                    <input type="hidden" name="appointment_id" value="<?php echo (int)$pending->id; ?>">
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn-agendar" type="submit">Aprobar</button>
                                </form>
                                <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                    <?php csrfField(); ?>
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
                                    <?php csrfField(); ?>
                                    <input type="hidden" name="appointment_id" value="<?php echo (int)$rejected->id; ?>">
                                    <input type="hidden" name="status" value="pending">
                                    <button class="btn-agendar" type="submit">Reabrir</button>
                                </form>
                                <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                    <?php csrfField(); ?>
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
                                        <?php csrfField(); ?>
                                        <input type="hidden" name="appointment_id" value="<?php echo (int)$item->id; ?>">
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn-agendar" type="submit">Aprobar</button>
                                    </form>
                                    <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                        <?php csrfField(); ?>
                                        <input type="hidden" name="appointment_id" value="<?php echo (int)$item->id; ?>">
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn-chat" type="submit">Rechazar</button>
                                    </form>
                                    <form action="<?php echo URLROOT; ?>/dashboard/panel" method="post">
                                        <?php csrfField(); ?>
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
                <div class="panel-detail-row"><span>Detalle clínico</span><p id="panel-detail-description" style="margin: 0; font-size: 13px; color: #555;"></p></div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo URLROOT; ?>/js/sections/panel.js"></script>
