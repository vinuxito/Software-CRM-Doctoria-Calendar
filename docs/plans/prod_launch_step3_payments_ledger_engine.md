# Step 3: Stripe/MercadoPago Payments & Financial Ledger Engine

## Objective
Implement an automated financial ledger, payment gateway integration (Stripe & MercadoPago), online deposit link generator, and automated commission split calculator for treating physiotherapists and specialists.

## User Value
- **Clinic Financial Managers**: Track total daily revenue, pending patient balances, collected deposits, and net clinic profit margins.
- **Therapists**: View transparent commission payouts per session based on configured commission rates.
- **Patients**: Pay session deposits or full treatment packages online via debit/credit card, SPEI bank transfer, or OXXO cash links.

## Files or Modules Likely Affected
- **Database Schema**: Create `financial_transactions`, `payment_links`, and `therapist_commissions` tables.
- **Models**: `app/models/Payment.php` (new model).
- **Controllers**: `app/controllers/Dashboard.php` (Add `payments()`, `generatePaymentLink()`, `webhookPayment()`).
- **Views**: `app/views/dashboard/sections/payments.php` (Financial ledger view).

## Implementation Plan
1. **Database Tables Creation**:
   ```sql
   CREATE TABLE IF NOT EXISTS financial_transactions (
       id INT AUTO_INCREMENT PRIMARY KEY,
       appointment_id INT DEFAULT NULL,
       patient_id INT NOT NULL,
       doctor_id INT NOT NULL,
       amount DECIMAL(10,2) NOT NULL,
       doctor_commission_amount DECIMAL(10,2) NOT NULL,
       clinic_net_amount DECIMAL(10,2) NOT NULL,
       payment_method VARCHAR(50) DEFAULT 'cash',
       payment_status VARCHAR(20) DEFAULT 'paid',
       transaction_ref VARCHAR(100) DEFAULT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```
2. **Payment Link Service**:
   - Allow staff to click "Generar Link de Pago" on any appointment to produce a checkout URL for deposit or full payment.
3. **Automated Ledger Allocation**:
   - Automatically split session fee into Specialist Commission (`doctor_commission_rate` %) and Net Clinic Income when an appointment is marked `completed`.

## UX Expectations
- Finance section in sidebar displays key KPI metric cards: **Ingresos Totales**, **Comisiones Médicas**, **Balance Neto Clínica**, **Pagos Pendientes**.
- Color-coded badges for payment statuses: `Pagado` (Green), `Depósito 50%` (Blue), `Pendiente` (Yellow).

## Security Considerations
- **Webhook Signature Verification**: Webhook endpoints verify HMAC signatures (`Stripe-Signature` or `X-Signature`) before marking transactions `paid`.
- **Financial Audit Logging**: Financial records are append-only; transactions cannot be deleted without an admin reversal audit trail.

## Failure Cases
- **Payment Gateway Downtime**: System gracefully falls back to Manual Payment Entry (`Efectivo`, `Transferencia Directa`, `Terminal PV`).
- **Card Charge Decline**: Patient is presented with clear failure messaging and retry option.

## Test Plan
- Write `test_prod_step3_payments.php`:
  1. Record a $1,000 MXN session payment with 60% therapist commission.
  2. Verify calculation: $600 MXN doctor commission, $400 MXN net clinic income.
  3. Verify financial ledger query sums balance accurately.

## Verification Evidence
- CLI execution output verifying mathematical correctness of commission splits and ledger balances.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Payment of $[amount] processed for Appointment ID [id]. Method: [method]")`.

## Definition of Done
- Ledger tables created and integrated with appointments.
- Commission calculations automated.
- Payment test suite 100% green.

## Next Logical Step
Proceed to **Step 4: AI Clinical Assistant & Speech Auto-SOAP Copilot**.
