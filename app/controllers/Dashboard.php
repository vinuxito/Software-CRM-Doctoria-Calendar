<?php
class Dashboard extends Controller {
    private $appointmentModel;
    private $userModel;
    private $chatModel;
    private $patientFileModel;
    private $expedienteModel;
    private $invoiceModel;
    private $resourceModel;
    private $clinicModel;
    private $paymentModel;
    private $pathwayModel;

    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            // Redirect to login
            header('location: ' . URLROOT . '/users/login');
            exit;
        }
        $this->appointmentModel = $this->model('Appointment');
        $this->userModel = $this->model('User');
        $this->chatModel = $this->model('Chat');
        $this->patientFileModel = $this->model('PatientFile');
        $this->expedienteModel = $this->model('Expediente');
        $this->invoiceModel = $this->model('Invoice');
        $this->resourceModel = $this->model('Resource');
        $this->clinicModel = $this->model('Clinic');
        $this->paymentModel = $this->model('Payment');
        $this->pathwayModel = $this->model('CarePathway');

        if(!isset($_SESSION['active_clinic_id'])){
            $_SESSION['active_clinic_id'] = 1;
        }
    }

    public function index(){
        $this->calendar();
    }

    public function calendar(){
        $this->handleAppointmentCreation();
        $role = $_SESSION['user_role'] ?? 'cliente';
        $userId = (int)$_SESSION['user_id'];
        $appointments = $this->appointmentModel->getAppointmentsForUser($userId, $role);
        $doctors = $this->userModel->getUsersByRole('medico');
        $clients = $this->userModel->getUsersByRole('cliente');
        $resources = $this->resourceModel->getResources();
        $data = $this->baseData('calendar');
        $data['appointments'] = $appointments;
        $data['doctors'] = $doctors;
        $data['clients'] = $clients;
        $data['resources'] = $resources;
        $data['can_schedule'] = in_array($role, ['admin', 'medico', 'cliente']);
        $this->view('dashboard/index', $data);
    }

    public function doctors(){
        $users = $this->userModel->getUsersByRole('medico');
        $data = $this->baseData('doctors');
        $data['doctors'] = $users;
        $this->view('dashboard/index', $data);
    }

    public function chat(){
        $currentUserId = (int)$_SESSION['user_id'];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Solicitud no válida');
            }
            $receiverId = (int)($_POST['receiver_id'] ?? 0);
            $message = trim($_POST['message'] ?? '');
            if($receiverId > 0 && $message !== ''){
                $this->chatModel->sendMessage($currentUserId, $receiverId, $message);
            }
            header('location: ' . URLROOT . '/dashboard/chat?with=' . $receiverId);
            return;
        }

        $withUserId = isset($_GET['with']) ? (int)$_GET['with'] : 0;
        $contacts = $this->chatModel->getContacts($currentUserId);
        if($withUserId === 0 && count($contacts) > 0){
            $withUserId = (int)$contacts[0]->id;
        }
        $messages = $withUserId > 0 ? $this->chatModel->getConversation($currentUserId, $withUserId) : [];
        $data = $this->baseData('chat');
        $data['chat_contacts'] = $contacts;
        $data['chat_messages'] = $messages;
        $data['chat_with'] = $withUserId;
        $this->view('dashboard/index', $data);
    }

    public function panel(){
        $role = $_SESSION['user_role'] ?? 'cliente';
        if($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($role, ['admin', 'medico'])){
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Solicitud no válida');
            }
            $appointmentId = (int)($_POST['appointment_id'] ?? 0);
            $status = $_POST['status'] ?? '';
            $action = $_POST['appointment_action'] ?? 'status';
            if($appointmentId > 0 && $action === 'delete'){
                $this->appointmentModel->deleteAppointment($appointmentId);
            } elseif($appointmentId > 0 && in_array($status, ['approved', 'rejected', 'pending', 'completed'])){
                $this->appointmentModel->updateStatus($appointmentId, $status);
            }
            header('location: ' . URLROOT . '/dashboard/panel');
            return;
        }

        $appointments = $this->appointmentModel->getAppointments();
        $pendingAppointments = $this->appointmentModel->getPendingAppointments();
        $rejectedAppointments = $this->appointmentModel->getRejectedAppointments();
        $summary = $this->appointmentModel->getSummaryCounts();
        $reports = $this->appointmentModel->getReportByMonth(date('Y'));
        $data = $this->baseData('panel');
        $data['appointments'] = $appointments;
        $data['total_appointments'] = count($appointments);

        $data['pending_appointments'] = $pendingAppointments;
        $data['rejected_appointments'] = $rejectedAppointments;
        $data['summary'] = $summary;
        $data['reports'] = $reports;
        $data['can_approve'] = in_array($role, ['admin', 'medico']);
        $this->view('dashboard/index', $data);
    }

    public function settings(){
        $data = $this->baseData('settings');
        $this->view('dashboard/index', $data);
    }

    public function profile(){
        $userId = (int)$_SESSION['user_id'];

        // Handle POST: update profile
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Solicitud no válida');
            }
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $passwordRaw = trim($_POST['password'] ?? '');
            $passwordConfirm = trim($_POST['password_confirm'] ?? '');

            $existingUser = $this->userModel->getUserByEmail($email);

            if(empty($name) || empty($email)){
                $_SESSION['flash'] = 'Nombre y correo electrónico son obligatorios.';
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $_SESSION['flash'] = 'El formato del correo electrónico no es válido.';
            } elseif($existingUser && (int)$existingUser->id !== $userId){
                $_SESSION['flash'] = 'El correo electrónico ya está registrado por otro usuario.';
            } elseif(!empty($passwordRaw) && $passwordRaw !== $passwordConfirm){
                $_SESSION['flash'] = 'Las contraseñas no coinciden.';
            } elseif(!empty($passwordRaw) && strlen($passwordRaw) < 6){
                $_SESSION['flash'] = 'La contraseña debe tener al menos 6 caracteres.';
            } else {
                $data = [
                    'id' => $userId,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'role' => $_SESSION['user_role'],
                    'password' => !empty($passwordRaw) ? password_hash($passwordRaw, PASSWORD_DEFAULT) : ''
                ];
                if($this->userModel->updateUser($data)){
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['flash'] = 'Perfil actualizado exitosamente.';
                } else {
                    $_SESSION['flash'] = 'Ocurrió un error al actualizar el perfil.';
                }
            }
            header('location: ' . URLROOT . '/dashboard/profile');
            return;
        }

        $user = $this->userModel->getUserById($userId);
        $data = $this->baseData('profile');
        $data['profile'] = $user;
        $this->view('dashboard/index', $data);
    }

    private function baseData($section){
        $flash = $_SESSION['flash'] ?? '';
        unset($_SESSION['flash']);
        return [
            'title' => 'Dashboard',
            'user_name' => $_SESSION['user_name'],
            'user_role' => $_SESSION['user_role'] ?? 'cliente',
            'section' => $section,
            'hide_navbar' => true,
            'layout_full' => true,
            'body_class' => 'crm-dashboard-body',
            'flash' => $flash
        ];
    }

    private function handleAppointmentCreation(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return;
        }

        if(!isset($_POST['create_appointment']) && !isset($_POST['appointment_action'])){
            return;
        }

        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            die('Solicitud no válida');
        }

        $role = $_SESSION['user_role'] ?? 'cliente';
        if(!in_array($role, ['admin', 'medico', 'cliente'])){
            return;
        }

        $doctorId = (int)($_POST['doctor_id'] ?? 0);
        $patientId = (int)($_POST['patient_id'] ?? 0);
        $resourceId = (int)($_POST['resource_id'] ?? 0);
        $appointmentId = (int)($_POST['appointment_id'] ?? 0);
        $action = $_POST['appointment_action'] ?? 'save';
        $startDate = trim($_POST['start_date'] ?? '');
        $endDate = trim($_POST['end_date'] ?? '');
        $contactPhone = trim($_POST['contact_phone'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if($action === 'delete' && $appointmentId > 0){
            $deleted = $this->appointmentModel->deleteAppointment($appointmentId);
            $_SESSION['flash'] = $deleted ? 'Cita eliminada.' : 'No se pudo eliminar.';
            header('location: ' . URLROOT . '/dashboard/calendar');
            return;
        }

        if($title === '' || $doctorId <= 0 || $patientId <= 0 || $startDate === '' || $endDate === ''){
            $_SESSION['flash'] = 'Completa todos los campos para agendar una cita.';
            header('location: ' . URLROOT . '/dashboard/calendar');
            return;
        }

        $status = ($role === 'admin' || $role === 'medico') ? 'approved' : 'pending';
        if($appointmentId > 0){
            $saved = $this->appointmentModel->updateAppointment([
                'id' => $appointmentId,
                'title' => $title,
                'doctor_id' => $doctorId,
                'patient_id' => $patientId,
                'resource_id' => $resourceId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'contact_phone' => $contactPhone,
                'description' => $description,
                'status' => $status
            ]);
            $_SESSION['flash'] = $saved ? 'Cita actualizada correctamente.' : 'No se pudo actualizar la cita.';
        } else {
            $saved = $this->appointmentModel->addAppointment([
                'user_id' => $patientId,
                'title' => $title,
                'doctor_id' => $doctorId,
                'patient_id' => $patientId,
                'resource_id' => $resourceId,
                'created_by' => (int)$_SESSION['user_id'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'contact_phone' => $contactPhone,
                'description' => $description,
                'status' => $status,
                'source_channel' => 'crm'
            ]);
            $_SESSION['flash'] = $saved ? 'Cita agendada correctamente.' : 'No se pudo agendar la cita.';
        }
        header('location: ' . URLROOT . '/dashboard/calendar');
    }

    public function users(){
        $role = $_SESSION['user_role'] ?? 'cliente';
        // Only admin can access user management
        if($role !== 'admin'){
            header('location: ' . URLROOT . '/dashboard');
            return;
        }

        // Handle POST actions: create, update, delete
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Solicitud no válida');
            }
            $action = $_POST['user_action'] ?? '';
            
            if($action === 'create'){
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $userRole = trim($_POST['role'] ?? 'cliente');
                $passwordRaw = trim($_POST['password'] ?? '');

                if(empty($name) || empty($email) || empty($userRole) || empty($passwordRaw)){
                    $_SESSION['flash'] = 'Todos los campos obligatorios deben ser completados.';
                } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $_SESSION['flash'] = 'El formato del correo electrónico no es válido.';
                } elseif(!in_array($userRole, ['admin', 'medico', 'cliente'], true)){
                    $_SESSION['flash'] = 'El rol seleccionado no es válido.';
                } elseif($this->userModel->getUserByEmail($email)){
                    $_SESSION['flash'] = 'El correo electrónico ya está registrado.';
                } else {
                    $data = [
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'role' => $userRole,
                        'password' => password_hash($passwordRaw, PASSWORD_DEFAULT)
                    ];
                    if($this->userModel->register($data)){
                        $_SESSION['flash'] = 'Usuario creado exitosamente.';
                        error_log("AUDIT LOG: Admin User [{$_SESSION['user_email']}] CREATED new user [{$email}] with role [{$userRole}]. SUCCESS.");
                    } else {
                        $_SESSION['flash'] = 'Ocurrió un error al intentar registrar el usuario.';
                        error_log("AUDIT LOG: Admin User [{$_SESSION['user_email']}] CREATED new user [{$email}] with role [{$userRole}]. FAILED.");
                    }
                }
            } elseif($action === 'update'){
                $userId = (int)($_POST['user_id'] ?? 0);
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $userRole = trim($_POST['role'] ?? 'cliente');
                $passwordRaw = trim($_POST['password'] ?? '');

                $existingUser = $this->userModel->getUserByEmail($email);

                if($userId <= 0){
                    $_SESSION['flash'] = 'ID de usuario no válido.';
                } elseif(empty($name) || empty($email) || empty($userRole)){
                    $_SESSION['flash'] = 'Los campos nombre, correo y rol son obligatorios.';
                } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $_SESSION['flash'] = 'El formato del correo electrónico no es válido.';
                } elseif(!in_array($userRole, ['admin', 'medico', 'cliente'], true)){
                    $_SESSION['flash'] = 'El rol seleccionado no es válido.';
                } elseif($existingUser && (int)$existingUser->id !== $userId){
                    $_SESSION['flash'] = 'El correo electrónico ya está registrado por otro usuario.';
                } else {
                    $data = [
                        'id' => $userId,
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'role' => $userRole,
                        'password' => !empty($passwordRaw) ? password_hash($passwordRaw, PASSWORD_DEFAULT) : ''
                    ];
                    if($this->userModel->updateUser($data)){
                        $_SESSION['flash'] = 'Usuario actualizado exitosamente.';
                        error_log("AUDIT LOG: Admin User [{$_SESSION['user_email']}] UPDATED user ID [{$userId}] (New Email: [{$email}], Role: [{$userRole}]). SUCCESS.");
                    } else {
                        $_SESSION['flash'] = 'Ocurrió un error al intentar actualizar el usuario.';
                        error_log("AUDIT LOG: Admin User [{$_SESSION['user_email']}] UPDATED user ID [{$userId}] (New Email: [{$email}], Role: [{$userRole}]). FAILED.");
                    }
                }
            } elseif($action === 'delete'){
                $userId = (int)($_POST['user_id'] ?? 0);
                // Prevent self-deletion
                if($userId === (int)$_SESSION['user_id']){
                    $_SESSION['flash'] = 'No puedes eliminar tu propio usuario administrador.';
                    error_log("AUDIT LOG: Admin User [{$_SESSION['user_email']}] ATTEMPTED self-deletion. BLOCKED.");
                } elseif($userId > 0){
                    if($this->userModel->deleteUser($userId)){
                        $_SESSION['flash'] = 'Usuario eliminado exitosamente.';
                        error_log("AUDIT LOG: Admin User [{$_SESSION['user_email']}] DELETED user ID [{$userId}]. SUCCESS.");
                    } else {
                        $_SESSION['flash'] = 'Ocurrió un error al intentar eliminar el usuario.';
                        error_log("AUDIT LOG: Admin User [{$_SESSION['user_email']}] DELETED user ID [{$userId}]. FAILED.");
                    }
                } else {
                    $_SESSION['flash'] = 'ID de usuario no válido para eliminación.';
                }
            }
            header('location: ' . URLROOT . '/dashboard/users');
            return;
        }

        $users = $this->userModel->getAllUsers();
        $data = $this->baseData('users');
        $data['users'] = $users;
        $this->view('dashboard/index', $data);
    }

    public function patients(){
        $role = $_SESSION['user_role'] ?? 'cliente';
        // Only admin and medico can manage patient digital files
        if(!in_array($role, ['admin', 'medico'], true)){
            header('location: ' . URLROOT . '/dashboard');
            return;
        }

        $patients = $this->userModel->getUsersByRole('cliente');
        // Attach clinical record to each patient
        foreach($patients as $p){
            $p->clinical_record = $this->patientFileModel->getOrCreateFile($p->id);
        }

        $appointments = $this->appointmentModel->getAppointments();

        $data = $this->baseData('patients');
        $data['patients'] = $patients;
        $data['appointments'] = $appointments;
        
        $this->view('dashboard/index', $data);
    }

    public function loadExpediente($patientId){
        if($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'medico'){
            echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
            exit;
        }
        $data = $this->expedienteModel->loadExpedienteData($patientId);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function saveExpediente($patientId){
        if($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'medico'){
            echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
            exit;
        }

        // CSRF verification for JSON API
        $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            echo json_encode(['status' => 'error', 'message' => 'Token CSRF inválido']);
            exit;
        }

        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true);

        if(!$payload){
            echo json_encode(['status' => 'error', 'message' => 'Payload inválido']);
            exit;
        }

        if(empty($payload['patient']['name'])){
            echo json_encode(['status' => 'error', 'message' => 'El nombre del paciente es obligatorio']);
            exit;
        }

        $saved = $this->expedienteModel->saveExpedienteData($patientId, $payload);

        if($saved){
            error_log("AUDIT LOG: User [{$_SESSION['user_email']}] SAVED clinical expediente for patient ID [{$patientId}]. STATUS: SUCCESS.");
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al guardar el expediente']);
        }
        exit;
    }

    public function globalSearch(){
        header('Content-Type: application/json');
        $q = trim($_GET['q'] ?? '');
        if(strlen($q) < 2){
            echo json_encode(['results' => []]);
            exit;
        }

        $results = [];

        // 1. Search Patients
        $patients = $this->userModel->getUsersByRole('cliente');
        foreach($patients as $p){
            if(stripos($p->name, $q) !== false || stripos($p->email, $q) !== false || stripos($p->phone ?? '', $q) !== false){
                $results[] = [
                    'title' => $p->name,
                    'subtitle' => 'Paciente • ' . $p->email,
                    'category' => 'Paciente',
                    'icon' => 'fas fa-notes-medical',
                    'url' => URLROOT . '/dashboard/patients?highlight=' . $p->id
                ];
            }
        }

        // 2. Search Specialists / Doctors
        $doctors = $this->userModel->getUsersByRole('medico');
        foreach($doctors as $d){
            if(stripos($d->name, $q) !== false || stripos($d->email, $q) !== false){
                $results[] = [
                    'title' => $d->name,
                    'subtitle' => 'Médico Especialista • ' . $d->email,
                    'category' => 'Especialista',
                    'icon' => 'fas fa-user-md',
                    'url' => URLROOT . '/dashboard/doctors'
                ];
            }
        }

        // 3. Search Appointments
        $appointments = $this->appointmentModel->getAppointments();
        foreach($appointments as $app){
            if(stripos($app->title, $q) !== false || stripos($app->patient_name ?? '', $q) !== false || stripos($app->doctor_name ?? '', $q) !== false){
                $results[] = [
                    'title' => $app->title,
                    'subtitle' => ($app->patient_name ?? 'Paciente') . ' con ' . ($app->doctor_name ?? 'Médico'),
                    'category' => 'Cita',
                    'icon' => 'far fa-calendar-alt',
                    'url' => URLROOT . '/dashboard/calendar'
                ];
            }
        }

        echo json_encode(['results' => array_slice($results, 0, 10)]);
        exit;
    }

    public function sendAppointmentReminder($appointmentId){
        require_once APPROOT . '/helpers/WhatsAppService.php';

        $appointment = $this->appointmentModel->getAppointmentById($appointmentId);
        if (!$appointment) {
            $_SESSION['flash'] = 'Cita no encontrada.';
            header('location: ' . URLROOT . '/dashboard/calendar');
            return;
        }

        $token = bin2hex(random_bytes(16));
        $this->appointmentModel->setConfirmationToken($appointmentId, $token);

        $waUrl = WhatsAppService::generateReminderUrl(
            $appointment->contact_phone ?: ($appointment->patient_phone ?? ''),
            $appointment->patient_name ?? 'Paciente',
            $appointment->doctor_name ?? 'Dr. Especialista',
            $appointment->start_date,
            $token
        );

        header('location: ' . $waUrl);
        exit;
    }

    public function confirmAppointment($token){
        if (empty($token)) {
            die('Token de confirmación no válido.');
        }

        $confirmed = $this->appointmentModel->confirmAppointmentByToken($token);
        if ($confirmed) {
            echo '<div style="font-family: sans-serif; text-align: center; padding: 50px;">' .
                 '<h1 style="color: #00a29a;">¡Cita Confirmada Exitosamente!</h1>' .
                 '<p>Tu asistencia ha sido registrada en el sistema de Doctoria CRM. ¡Te esperamos!</p>' .
                 '</div>';
        } else {
            echo '<div style="font-family: sans-serif; text-align: center; padding: 50px;">' .
                 '<h1 style="color: #e53e3e;">Enlace de confirmación no válido o expirado.</h1>' .
                 '</div>';
        }
        exit;
    }

    public function invoices(){
        $role = $_SESSION['user_role'] ?? 'cliente';
        if(!in_array($role, ['admin', 'medico'], true)){
            header('location: ' . URLROOT . '/dashboard');
            return;
        }

        $invoices = $this->invoiceModel->getInvoices();
        $patients = $this->userModel->getUsersByRole('cliente');

        $data = $this->baseData('invoices');
        $data['invoices'] = $invoices;
        $data['patients'] = $patients;

        $this->view('dashboard/index', $data);
    }

    public function saveFiscalProfile(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Solicitud no válida');
            }

            $patientId = (int)($_POST['patient_id'] ?? 0);
            $rfc = strtoupper(preg_replace('/[^A-Za-z0-9&Ññ]/', '', trim($_POST['rfc'] ?? '')));
            $razonSocial = trim($_POST['razon_social'] ?? '');
            $codigoPostal = preg_replace('/[^0-9]/', '', trim($_POST['codigo_postal'] ?? ''));
            $usoCfdi = trim($_POST['uso_cfdi'] ?? 'D01');

            $isValidRfc = preg_match('/^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$/', $rfc);
            $isValidCp = preg_match('/^\d{5}$/', $codigoPostal);

            if ($patientId <= 0 || !$isValidRfc || empty($razonSocial) || !$isValidCp) {
                $_SESSION['flash'] = 'Por favor ingresa un RFC válido (12-13 caracteres) y un Código Postal de 5 dígitos.';
            } else {
                $saved = $this->invoiceModel->saveFiscalProfile([
                    'patient_id' => $patientId,
                    'rfc' => $rfc,
                    'razon_social' => $razonSocial,
                    'codigo_postal' => $codigoPostal,
                    'uso_cfdi' => $usoCfdi
                ]);
                if ($saved) {
                    error_log("AUDIT LOG: User [{$_SESSION['user_email']}] SAVED RFC Fiscal Profile for patient ID [{$patientId}]. RFC: [{$rfc}].");
                    $_SESSION['flash'] = 'Perfil Fiscal RFC guardado correctamente.';
                } else {
                    $_SESSION['flash'] = 'Error al guardar el perfil fiscal.';
                }
            }
        }
        header('location: ' . URLROOT . '/dashboard/invoices');
        exit;
    }

    public function analytics(){
        $role = $_SESSION['user_role'] ?? 'cliente';
        if(!in_array($role, ['admin', 'medico'], true)){
            header('location: ' . URLROOT . '/dashboard');
            return;
        }

        $patients = $this->userModel->getUsersByRole('cliente');
        $selectedPatientId = (int)($_GET['patient_id'] ?? ($patients[0]->id ?? 0));

        $progressHistory = [];
        if ($selectedPatientId > 0) {
            $progressHistory = $this->expedienteModel->getPatientProgressHistory($selectedPatientId);
        }

        $data = $this->baseData('analytics');
        $data['patients'] = $patients;
        $data['selected_patient_id'] = $selectedPatientId;
        $data['progress_history'] = $progressHistory;

        $this->view('dashboard/index', $data);
    }

    public function exportExpedientePdf($patientId){
        $role = $_SESSION['user_role'] ?? 'cliente';
        if(!in_array($role, ['admin', 'medico'], true)){
            die('No autorizado');
        }

        $expedienteData = $this->expedienteModel->loadExpedienteData((int)$patientId);
        if (!$expedienteData || empty($expedienteData['patient'])) {
            die('Expediente no encontrado.');
        }

        $data = [
            'patient' => $expedienteData['patient'],
            'expediente' => $expedienteData['expediente'],
            'antecedentes' => $expedienteData['antecedentes'],
            'exploracion' => $expedienteData['exploracion'],
            'marcha' => $expedienteData['marcha'],
            'dolor_puntos' => $expedienteData['dolor_puntos'] ?? []
        ];

        error_log("AUDIT LOG: User [{$_SESSION['user_email']}] EXPORTED PDF Clinical Expediente for patient ID [{$patientId}].");

        require_once APPROOT . '/views/dashboard/expediente_pdf.php';
        exit;
    }

    public function resources(){
        $role = $_SESSION['user_role'] ?? 'cliente';
        if(!in_array($role, ['admin', 'medico'], true)){
            header('location: ' . URLROOT . '/dashboard');
            return;
        }

        $resources = $this->resourceModel->getResources();

        $data = $this->baseData('resources');
        $data['resources'] = $resources;

        $this->view('dashboard/index', $data);
    }

    public function addResource(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Solicitud no válida');
            }

            $name = trim($_POST['name'] ?? '');
            $type = trim($_POST['type'] ?? 'cubiculo');

            if (!empty($name)) {
                $this->resourceModel->addResource([
                    'name' => $name,
                    'type' => $type,
                    'status' => 'available'
                ]);
                error_log("AUDIT LOG: User [{$_SESSION['user_email']}] ADDED Clinic Resource [{$name}].");
                $_SESSION['flash'] = 'Cubículo / Recurso registrado correctamente.';
            } else {
                $_SESSION['flash'] = 'Ingresa un nombre para el recurso.';
            }
        }
        header('location: ' . URLROOT . '/dashboard/resources');
        exit;
    }

    public function toggleResourceStatus(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Solicitud no válida');
            }

            $resId = (int)($_POST['resource_id'] ?? 0);
            $currStatus = trim($_POST['current_status'] ?? 'available');
            $newStatus = ($currStatus === 'available') ? 'maintenance' : 'available';

            if ($resId > 0) {
                $this->resourceModel->updateStatus($resId, $newStatus);
                error_log("AUDIT LOG: User [{$_SESSION['user_email']}] TOGGLED Resource ID [{$resId}] status to [{$newStatus}].");
                $_SESSION['flash'] = 'Estado del recurso actualizado.';
            }
        }
        header('location: ' . URLROOT . '/dashboard/resources');
        exit;
    }

    public function switchClinic(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Solicitud no válida');
            }
            $clinicId = (int)($_POST['clinic_id'] ?? 1);
            $_SESSION['active_clinic_id'] = $clinicId;
            error_log("AUDIT LOG: User [{$_SESSION['user_email']}] SWITCHED active clinic to ID [{$clinicId}].");
            $_SESSION['flash'] = 'Sede / Clínica cambiada correctamente.';
        }
        header('location: ' . URLROOT . '/dashboard/calendar');
        exit;
    }

    public function payments(){
        $role = $_SESSION['user_role'] ?? 'cliente';
        if(!in_array($role, ['admin', 'medico'], true)){
            header('location: ' . URLROOT . '/dashboard');
            return;
        }

        $transactions = $this->paymentModel->getTransactions($_SESSION['active_clinic_id']);
        $summary = $this->paymentModel->getFinancialSummary();

        $data = $this->baseData('payments');
        $data['transactions'] = $transactions;
        $data['summary'] = $summary;

        $this->view('dashboard/index', $data);
    }

    public function pathways(){
        $role = $_SESSION['user_role'] ?? 'cliente';
        if(!in_array($role, ['admin', 'medico'], true)){
            header('location: ' . URLROOT . '/dashboard');
            return;
        }

        $pathways = $this->pathwayModel->getPathways();
        $patients = $this->userModel->getUsersByRole('cliente');

        $data = $this->baseData('pathways');
        $data['pathways'] = $pathways;
        $data['patients'] = $patients;

        $this->view('dashboard/index', $data);
    }

    public function startTelemedSession($appointmentId){
        require_once APPROOT . '/helpers/TelemedService.php';
        $token = TelemedService::generateRoomToken((int)$appointmentId);
        error_log("AUDIT LOG: User [{$_SESSION['user_email']}] STARTED Telemed Session for appointment ID [{$appointmentId}]. Token: [{$token}]");
        
        $data = $this->baseData('telemed');
        $data['appointment_id'] = (int)$appointmentId;
        $data['room_token'] = $token;
        $data['join_url'] = TelemedService::buildPatientJoinUrl($token);

        $this->view('dashboard/index', $data);
    }
}
