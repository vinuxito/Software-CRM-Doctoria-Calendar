# Step 4: CFDI 4.0 SAT Medical Invoicing Engine (Mexican Fiscal Compliance)

> **Goal**: Turn Doctoria CRM into a high-value tax & invoicing platform by adding Mexican SAT CFDI 4.0 medical invoice generation (Complemento de Servicios Médicos), RFC fiscal profile management per patient, and 1-click XML/PDF invoice issuing directly from appointments.

---

## Proposed Changes

### 1. Database Schema
#### Schema Update in `setup.sql` & Migration Script
```sql
CREATE TABLE IF NOT EXISTS patient_fiscal_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL UNIQUE,
    rfc VARCHAR(13) NOT NULL,
    razon_social VARCHAR(255) NOT NULL,
    codigo_postal VARCHAR(10) NOT NULL,
    regimen_fiscal VARCHAR(10) NOT NULL DEFAULT '605', -- 605: Sueldos y Salarios / 612 / 601
    uso_cfdi VARCHAR(10) NOT NULL DEFAULT 'D01', -- D01: Honorarios médicos, dentales y gastos hospitalarios
    email_cfdi VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cfdi_invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT DEFAULT NULL,
    patient_id INT NOT NULL,
    folio_fiscal VARCHAR(64) DEFAULT NULL, -- UUID SAT
    serie VARCHAR(10) DEFAULT 'F',
    folio INT NOT NULL AUTO_INCREMENT,
    subtotal DECIMAL(10,2) NOT NULL,
    iva DECIMAL(10,2) NOT NULL DEFAULT 0.00, -- Medical services exempt or 0% / 16% depending on clinic type
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'draft', -- 'draft', 'stamped', 'cancelled'
    pdf_path VARCHAR(255) DEFAULT NULL,
    xml_path VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY (patient_id),
    KEY (folio)
);
```

---

### 2. View Layer
#### [NEW] [invoices.php](file:///lamp/www/naxielly/app/views/dashboard/sections/invoices.php)
- Dedicated "Facturación CFDI 4.0" section in Dashboard.
- Fiscal RFC profile editor modal for patients.
- Table of issued medical invoices with status badges (Borrador, Timbrada SAT, Cancelada), quick download links for XML and PDF, and "Emitir Factura" action.

---

### 3. Model & Controller Layer
#### [NEW] [Invoice.php](file:///lamp/www/naxielly/app/models/Invoice.php)
- Methods: `getFiscalProfile($patientId)`, `saveFiscalProfile($data)`, `createInvoice($data)`, `getInvoices()`, `generateCfdiXml($invoiceId)`.

#### [MODIFY] [Dashboard.php](file:///lamp/www/naxielly/app/controllers/Dashboard.php)
- Add `invoices()` action method to render invoice section.
- Add `saveFiscalProfile()` and `issueInvoice()` handlers with full validation of RFC length (12 or 13 chars), CP length (5 digits), and Uso CFDI `D01` (Honorarios médicos).

---

## Verification Plan
1. Go to `Facturación CFDI` section in sidebar.
2. Select patient "Pepe Paciente", enter RFC `XAXX010101000`, CP `06600`, Uso CFDI `D01` (Honorarios Médicos) and save profile.
3. Click "Generar Factura Médica" for an appointment: verify subtotal/total calculation and CFDI 4.0 XML/PDF record generated in `cfdi_invoices`.
