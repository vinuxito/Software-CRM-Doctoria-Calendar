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
                                        <?php csrfField(); ?>
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
                <?php csrfField(); ?>
                <input type="hidden" name="user_action" id="user-form-action" value="create">
                <input type="hidden" name="user_id" id="user-form-id" value="0">
                
                <label>Nombre</label>
                <input type="text" name="name" id="user-form-name" placeholder="Ej. Pepe Paciente" required>
                
                <label>Email</label>
                <input type="email" name="email" id="user-form-email" placeholder="Ej. pepe@doctoria.com" required>
                
                <label>Teléfono</label>
                <input type="text" name="phone" id="user-form-phone" placeholder="Ej. +57 300 000 0000">
                
                <label id="user-form-pass-label">Contraseña</label>
                <input type="password" name="password" id="user-form-password" placeholder="Mínimo 6 caracteres">
                
                <label>Rol del Sistema</label>
                <select name="role" id="user-form-role" required>
                    <option value="cliente">Cliente (Paciente)</option>
                    <option value="medico">Médico especialista</option>
                    <option value="admin">Administrador</option>
                </select>
                
                <button type="submit" class="btn-configurar" style="margin-top:15px;">Guardar Usuario</button>
            </form>
        </div>
    </div>
</section>

<script src="<?php echo URLROOT; ?>/js/sections/users.js"></script>
