<div class="crm-content-container" style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0;">
                <i class="fas fa-wallet" style="color: var(--brand-primary); margin-right: 8px;"></i> Libro Contable & Comisiones Fisioterapia
            </h2>
            <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0 0;">Gestión de ingresos por consulta, repartición de comisiones de especialistas e ingresos netos de clínica</p>
        </div>
    </div>

    <!-- Financial KPI Summary Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 12px; padding: 18px; box-shadow: var(--shadow-sm);">
            <span style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Ingresos Totales</span>
            <div style="font-size: 24px; font-weight: 800; color: #10b981; margin-top: 6px;">
                $<?php echo number_format($data['summary']->total_revenue ?? 0, 2); ?> MXN
            </div>
        </div>
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 12px; padding: 18px; box-shadow: var(--shadow-sm);">
            <span style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Comisiones Médicas</span>
            <div style="font-size: 24px; font-weight: 800; color: #3b82f6; margin-top: 6px;">
                $<?php echo number_format($data['summary']->total_commissions ?? 0, 2); ?> MXN
            </div>
        </div>
        <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 12px; padding: 18px; box-shadow: var(--shadow-sm);">
            <span style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Utilidad Neta Clínica</span>
            <div style="font-size: 24px; font-weight: 800; color: var(--brand-primary); margin-top: 6px;">
                $<?php echo number_format($data['summary']->total_net_income ?? 0, 2); ?> MXN
            </div>
        </div>
    </div>

    <!-- Ledger Table -->
    <div style="background: #fff; border: 1px solid var(--border-default); border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--border-default);">
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: var(--text-muted);">Fecha</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: var(--text-muted);">Paciente</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: var(--text-muted);">Fisioterapeuta</th>
                    <th style="padding: 12px 16px; text-align: right; font-size: 12px; font-weight: 700; color: var(--text-muted);">Cobro Total</th>
                    <th style="padding: 12px 16px; text-align: right; font-size: 12px; font-weight: 700; color: var(--text-muted);">Comisión Médico</th>
                    <th style="padding: 12px 16px; text-align: right; font-size: 12px; font-weight: 700; color: var(--text-muted);">Neto Clínica</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['transactions'])) : ?>
                    <tr>
                        <td colspan="6" style="padding: 32px; text-align: center; color: var(--text-muted);">No hay registros contables en este período.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($data['transactions'] as $tx) : ?>
                        <tr style="border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 12px 16px; font-size: 13px;"><?php echo date('d/m/Y H:i', strtotime($tx->created_at)); ?></td>
                            <td style="padding: 12px 16px; font-size: 13px; font-weight: 600;"><?php echo htmlspecialchars($tx->patient_name ?? 'N/A'); ?></td>
                            <td style="padding: 12px 16px; font-size: 13px;"><?php echo htmlspecialchars($tx->doctor_name ?? 'N/A'); ?></td>
                            <td style="padding: 12px 16px; font-size: 13px; font-weight: 700; text-align: right;">$<?php echo number_format($tx->amount, 2); ?></td>
                            <td style="padding: 12px 16px; font-size: 13px; color: #3b82f6; text-align: right;">$<?php echo number_format($tx->doctor_commission_amount, 2); ?></td>
                            <td style="padding: 12px 16px; font-size: 13px; color: #10b981; font-weight: 700; text-align: right;">$<?php echo number_format($tx->clinic_net_amount, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
