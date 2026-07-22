<div class="crm-content-container" style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0;">
                <i class="fas fa-file-invoice-dollar" style="color: var(--brand-primary); margin-right: 8px;"></i> Facturación Electrónica SAT CFDI 4.0
            </h2>
            <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0 0;">Gestión de comprobantes fiscales con complemento de servicios médicos (Uso CFDI D01)</p>
        </div>
        <button class="btn-configurar" onclick="document.getElementById('modal-fiscal-profile').style.display='flex';" style="background: var(--brand-primary); color: #fff; padding: 10px 18px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-id-card"></i> Configurar Perfil Fiscal RFC
        </button>
    </div>

    <!-- Summary Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 10px; padding: 18px;">
            <span style="font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase;">Facturas Emitidas</span>
            <h3 style="font-size: 24px; font-weight: 700; color: var(--brand-primary); margin: 6px 0 0 0;"><?php echo count($data['invoices'] ?? []); ?></h3>
        </div>
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 10px; padding: 18px;">
            <span style="font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase;">Régimen Fiscal Predeterminado</span>
            <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 6px 0 0 0;">605 - Sueldos y Salarios / 612</h3>
        </div>
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 10px; padding: 18px;">
            <span style="font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase;">Uso CFDI Médico</span>
            <h3 style="font-size: 16px; font-weight: 700; color: var(--color-success); margin: 6px 0 0 0;">D01 - Honorarios Médicos</h3>
        </div>
    </div>

    <!-- Invoices Table -->
    <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm);">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--border-default); font-size: 12px; color: var(--text-muted); text-transform: uppercase;">
                    <th style="padding: 14px 18px;">Folio / Serie</th>
                    <th style="padding: 14px 18px;">Paciente</th>
                    <th style="padding: 14px 18px;">RFC / Razón Social</th>
                    <th style="padding: 14px 18px;">UUID SAT</th>
                    <th style="padding: 14px 18px;">Total</th>
                    <th style="padding: 14px 18px;">Estado SAT</th>
                    <th style="padding: 14px 18px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['invoices'])) : ?>
                    <tr>
                        <td colspan="7" style="padding: 30px; text-align: center; color: var(--text-muted);">
                            <i class="fas fa-file-invoice" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                            No se han timbrado comprobantes fiscales CFDI 4.0 aún.
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($data['invoices'] as $inv) : ?>
                        <tr style="border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 14px 18px; font-weight: 700; color: var(--brand-primary);"><?php echo htmlspecialchars($inv->serie . '-' . $inv->folio); ?></td>
                            <td style="padding: 14px 18px; font-weight: 600;"><?php echo htmlspecialchars($inv->patient_name ?? 'Paciente'); ?></td>
                            <td style="padding: 14px 18px; font-size: 13px; color: var(--text-secondary);">
                                <strong><?php echo htmlspecialchars($inv->rfc ?? 'XAXX010101000'); ?></strong><br>
                                <?php echo htmlspecialchars($inv->razon_social ?? 'Público en General'); ?>
                            </td>
                            <td style="padding: 14px 18px; font-family: monospace; font-size: 12px; color: #64748b;"><?php echo htmlspecialchars(substr($inv->folio_fiscal, 0, 18) . '...'); ?></td>
                            <td style="padding: 14px 18px; font-weight: 700;">$<?php echo number_format($inv->total, 2); ?> MXN</td>
                            <td style="padding: 14px 18px;">
                                <span class="status-chip status-approved" style="background: #e6fffa; color: #047857; font-weight: 700; padding: 4px 10px; border-radius: 12px; font-size: 11px;">Timbrada SAT</span>
                            </td>
                            <td style="padding: 14px 18px;">
                                <button class="btn-configurar" style="padding: 4px 10px; font-size: 12px;" onclick="alert('Descargando XML CFDI 4.0: <?php echo $inv->folio_fiscal; ?>');"><i class="fas fa-code"></i> XML</button>
                                <button class="btn-configurar" style="padding: 4px 10px; font-size: 12px; background: #64748b;" onclick="alert('Descargando Representación Impresa PDF...');"><i class="fas fa-file-pdf"></i> PDF</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Profile Fiscal RFC -->
<div id="modal-fiscal-profile" class="calendar-modal" style="display: none; position: fixed; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 12px; width: 90%; max-width: 520px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="margin-top: 0; font-family: var(--font-heading); color: var(--brand-primary);"><i class="fas fa-address-card"></i> Configurar Perfil Fiscal RFC</h3>
        <form action="<?php echo URLROOT; ?>/dashboard/saveFiscalProfile" method="post" style="display: flex; flex-direction: column; gap: 12px;">
            <?php csrfField(); ?>
            <div>
                <label style="font-size: 12px; font-weight: 600;">Seleccionar Paciente:</label>
                <select name="patient_id" required style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border-default);">
                    <?php foreach (($data['patients'] ?? []) as $p) : ?>
                        <option value="<?php echo $p->id; ?>"><?php echo htmlspecialchars($p->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label style="font-size: 12px; font-weight: 600;">RFC (12 o 13 caracteres):</label>
                <input type="text" name="rfc" placeholder="XAXX010101000" required maxlength="13" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border-default); font-transform: uppercase;">
            </div>
            <div>
                <label style="font-size: 12px; font-weight: 600;">Razón Social / Nombre Fiscal:</label>
                <input type="text" name="razon_social" placeholder="Nombre completo o Empresa" required style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border-default);">
            </div>
            <div>
                <label style="font-size: 12px; font-weight: 600;">Código Postal Fiscal (5 dígitos):</label>
                <input type="text" name="codigo_postal" placeholder="06600" required maxlength="5" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border-default);">
            </div>
            <div>
                <label style="font-size: 12px; font-weight: 600;">Uso del CFDI:</label>
                <select name="uso_cfdi" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border-default);">
                    <option value="D01" selected>D01 - Honorarios médicos, dentales y gastos hospitalarios</option>
                    <option value="G03">G03 - Gastos en general</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 12px;">
                <button type="button" onclick="document.getElementById('modal-fiscal-profile').style.display='none';" style="padding: 8px 16px; border-radius: 6px; border: 1px solid var(--border-default); background: #f1f5f9;">Cancelar</button>
                <button type="submit" style="padding: 8px 16px; border-radius: 6px; border: none; background: var(--brand-primary); color: #fff; font-weight: 600;">Guardar RFC</button>
            </div>
        </form>
    </div>
</div>
