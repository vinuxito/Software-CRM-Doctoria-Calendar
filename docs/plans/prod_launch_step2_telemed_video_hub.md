# Step 2: Telemedicine Video Hub & Patient Consultation Portal

## Objective
Provide an integrated WebRTC video consultation room and virtual patient waiting room inside Doctoria CRM, allowing specialists to conduct remote physical therapy consultations, gait assessments, and exercise follow-ups online.

## User Value
- **Patients**: Receive a 1-click encrypted video link via SMS/WhatsApp without installing third-party mobile apps.
- **Therapists**: Conduct video consultations with split-screen clinical record access (taking SOAP notes and updating body maps live during the call).

## Files or Modules Likely Affected
- **Database Schema**: Add `video_room_token`, `is_telemed`, `telemed_status` to `appointments` table.
- **Controllers**: `app/controllers/Dashboard.php` (Add `telemedRoom($appointmentId)`, `generateVideoLink($appointmentId)`).
- **Views**: Create `app/views/dashboard/telemed_room.php` (WebRTC video layout with split-screen patient history panel).
- **Helpers**: `app/helpers/TelemedService.php` (Secure JWT video room link generator).

## Implementation Plan
1. **Database Update**:
   - Add columns: `is_telemed TINYINT(1) DEFAULT 0`, `video_room_token VARCHAR(64) UNIQUE DEFAULT NULL`, `telemed_status VARCHAR(20) DEFAULT 'scheduled'`.
2. **Video Room Token Generator**:
   - Build `TelemedService::generateRoomToken($appointmentId)` generating crypto-random 64-character tokens.
   - Build public patient join link: `/telemed/join/{token}` allowing patients to enter the virtual waiting room.
3. **Split-Screen Telemedicine View**:
   - Left Panel (60% width): WebRTC video interface (Local & Remote camera streams, mute microphone, camera toggle, screen share).
   - Right Panel (40% width): Live patient expediente overview, interactive body map, and clinical notes drawer.

## UX Expectations
- Appointment details card in calendar displays a prominent "🎥 Iniciar Teleconsulta" button for virtual appointments.
- Patient receives automated WhatsApp message: *"Hola, tu videoconsulta está lista. Únete aquí: http://localhost/naxielly/telemed/join/TOKEN"*.

## Security Considerations
- **Token Expiration**: Video room tokens auto-expire 2 hours after the scheduled appointment end time.
- **Encrypted Peer-to-Peer**: WebRTC video and audio streams operate over DTLS-SRTP end-to-end encryption.

## Failure Cases
- **Camera / Mic Permission Denied**: Render clear inline visual guidance telling the patient/doctor how to enable camera permissions in their browser settings.
- **Network Disconnection**: Automatic reconnect attempts with status banner *"Reconectando señal de video..."*.

## Test Plan
- Write `test_prod_step2_telemed.php`:
  1. Flag appointment ID as `is_telemed = 1`.
  2. Generate video room token via `TelemedService`.
  3. Verify token uniqueness and valid route resolution.
  4. Verify patient waiting room status transitions (`waiting` -> `in_call` -> `completed`).

## Verification Evidence
- CLI test log verifying video room token generation and expiration bounds.

## Documentation/Logging Requirements
- Log structured audit events: `error_log("AUDIT LOG: Telemed Session started for Appointment ID [id] by Specialist [user_id]")`.

## Definition of Done
- Telemedicine room layout created with responsive split-screen.
- 1-click video link generation active.
- Telemed test suite 100% green.

## Next Logical Step
Proceed to **Step 3: Stripe/MercadoPago Payments & Financial Ledger Engine**.
