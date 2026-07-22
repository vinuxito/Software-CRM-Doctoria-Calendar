<div class="crm-content-container" style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0;">
                <i class="fas fa-door-open" style="color: var(--brand-primary); margin-right: 8px;"></i> Gestión de Cubículos y Recursos de Tratamiento
            </h2>
            <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0 0;">Asignación de consultorios, camillas y equipos de electroterapia/ultrasonido para evitar empalmes</p>
        </div>
        <button class="btn-configurar" onclick="document.getElementById('modal-add-resource').style.display='flex';" style="background: var(--brand-primary); color: #fff; padding: 10px 18px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-plus-circle"></i> Nuevo Cubículo / Recurso
        </button>
    </div>

    <!-- Resources Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        <?php if (empty($data['resources'])) : ?>
            <div style="grid-column: 1 / -1; background: #fff; border: 1px dashed var(--border-default); border-radius: 12px; padding: 40px; text-align: center; color: var(--text-muted);">
                <i class="fas fa-cubes" style="font-size: 36px; margin-bottom: 12px; display: block; color: var(--brand-primary);"></i>
                No hay cubículos ni recursos registrados. Agrega el primer cubículo de fisioterapia.
            </div>
        <?php else : ?>
            <?php foreach ($data['resources'] as $res) : ?>
                <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 12px; padding: 20px; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--text-primary);"><?php echo htmlspecialchars($res->name); ?></h4>
                        <span class="status-chip <?php echo $res->status === 'available' ? 'status-approved' : 'status-rejected'; ?>" style="font-size: 11px; padding: 3px 8px; border-radius: 10px; font-weight: 700;">
                            <?php echo $res->status === 'available' ? 'Disponible' : 'Mantenimiento'; ?>
                        </span>
                    </div>
                    <div style="font-size: 13px; color: var(--text-secondary);">
                        <i class="fas fa-tag"></i> Tipo: <strong><?php echo ucfirst(htmlspecialchars($res->type)); ?></strong>
                    </div>
                    <div style="margin-top: auto; padding-top: 12px; border-top: 1px solid var(--border-light); display: flex; justify-content: flex-end;">
                        <form action="<?php echo URLROOT; ?>/dashboard/toggleResourceStatus" method="post">
                            <?php csrfField(); ?>
                            <input type="hidden" name="resource_id" value="<?php echo $res->id; ?>">
                            <input type="hidden" name="current_status" value="<?php echo $res->status; ?>">
                            <button type="submit" style="background: transparent; border: 1px solid var(--border-default); padding: 4px 10px; border-radius: 6px; font-size: 12px; cursor: pointer;">
                                <?php echo $res->status === 'available' ? 'Poner en Mantenimiento' : 'Habilitar'; ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Add Resource -->
<div id="modal-add-resource" class="calendar-modal" style="display: none; position: fixed; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 12px; width: 90%; max-width: 440px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="margin-top: 0; font-family: var(--font-heading); color: var(--brand-primary);"><i class="fas fa-door-open"></i> Nuevo Cubículo / Recurso</h3>
        <form action="<?php echo URLROOT; ?>/dashboard/addResource" method="post" style="display: flex; flex-direction: column; gap: 14px;">
            <?php csrfField(); ?>
            <div>
                <label style="font-size: 12px; font-weight: 600;">Nombre del Recurso / Cubículo *</label>
                <input type="text" name="name" placeholder="Ej. Cubículo 1 (Electroterapia)" required style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border-default);">
            </div>
            <div>
                <label style="font-size: 12px; font-weight: 600;">Tipo de Recurso</label>
                <select name="type" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border-default);">
                    <option value="cubiculo">Cubículo / Consultorio</option>
                    <option value="camilla">Camilla de Rehabilitación</option>
                    <option value="equipo">Equipo de Fisioterapia</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <button type="button" onclick="document.getElementById('modal-add-resource').style.display='none';" style="padding: 8px 16px; border-radius: 6px; border: 1px solid var(--border-default); background: #f1f5f9;">Cancelar</button>
                <button type="submit" style="padding: 8px 16px; border-radius: 6px; border: none; background: var(--brand-primary); color: #fff; font-weight: 600;">Guardar Recurso</button>
            </div>
        </form>
    </div>
</div>
