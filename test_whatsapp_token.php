<?php
require_once 'config/config.php';
require_once 'app/bootstrap.php';
require_once 'app/models/Appointment.php';
require_once 'app/helpers/WhatsAppService.php';

echo "Running Step 3 Automated WhatsApp & SMS Reminders Tests...\n";

$appointmentModel = new Appointment();

$mockToken = bin2hex(random_bytes(16));

// Test setting confirmation token for appointment ID 1
$tokenSaved = $appointmentModel->setConfirmationToken(1, $mockToken);
if ($tokenSaved) {
    echo "✓ Confirmation token set for appointment ID 1.\n";
} else {
    echo "x Failed setting confirmation token.\n";
    exit(1);
}

// Test URL generator
$waUrl = WhatsAppService::generateReminderUrl('5551234567', 'Pepe Paciente', 'Dr. House', '2026-07-25 10:00:00', $mockToken);
if (strpos($waUrl, 'https://wa.me/') === 0 && strpos($waUrl, $mockToken) !== false) {
    echo "✓ Generated valid WhatsApp wa.me URL with confirmation token.\n";
} else {
    echo "x Failed generating WhatsApp URL.\n";
    exit(1);
}

// Test token confirmation endpoint execution
$confirmed = $appointmentModel->confirmAppointmentByToken($mockToken);
if ($confirmed) {
    echo "✓ Appointment successfully confirmed via 1-click token!\n";
} else {
    echo "x Failed confirming appointment by token.\n";
    exit(1);
}

echo "ALL STEP 3 WHATSAPP REMINDER TESTS PASSED!\n";
