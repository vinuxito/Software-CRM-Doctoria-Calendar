<?php
class Dashboard extends Controller {
    private $appointmentModel;
    private $userModel;
    private $chatModel;

    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            // Redirect to login
            header('location: ' . URLROOT . '/users/login');
        }
        $this->appointmentModel = $this->model('Appointment');
        $this->userModel = $this->model('User');
        $this->chatModel = $this->model('Chat');
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
        $data = $this->baseData('calendar');
        $data['appointments'] = $appointments;
        $data['doctors'] = $doctors;
        $data['clients'] = $clients;
        $data['can_schedule'] = in_array($role, ['admin', 'medico', 'cliente']);
        $data['flash'] = $_SESSION['flash'] ?? '';
        unset($_SESSION['flash']);
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
        $data['online_appointments'] = (int) ceil(count($appointments) * 0.35);
        $data['offline_appointments'] = count($appointments) - $data['online_appointments'];
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
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $data = $this->baseData('profile');
        $data['profile'] = $user;
        $this->view('dashboard/index', $data);
    }

    private function baseData($section){
        return [
            'title' => 'Dashboard',
            'user_name' => $_SESSION['user_name'],
            'user_role' => $_SESSION['user_role'] ?? 'cliente',
            'section' => $section,
            'hide_navbar' => true,
            'layout_full' => true,
            'body_class' => 'crm-dashboard-body'
        ];
    }

    private function handleAppointmentCreation(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return;
        }

        if(!isset($_POST['create_appointment'])){
            return;
        }

        $role = $_SESSION['user_role'] ?? 'cliente';
        if(!in_array($role, ['admin', 'medico', 'cliente'])){
            return;
        }

        $doctorId = (int)($_POST['doctor_id'] ?? 0);
        $patientId = (int)($_POST['patient_id'] ?? 0);
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
            $action = $_POST['user_action'] ?? '';
            if($action === 'create'){
                $data = [
                    'name' => trim($_POST['name'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'phone' => trim($_POST['phone'] ?? ''),
                    'role' => trim($_POST['role'] ?? 'cliente'),
                    'password' => password_hash(trim($_POST['password'] ?? '123456'), PASSWORD_DEFAULT)
                ];
                $this->userModel->register($data);
            } elseif($action === 'update'){
                $data = [
                    'id' => (int)($_POST['user_id'] ?? 0),
                    'name' => trim($_POST['name'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'phone' => trim($_POST['phone'] ?? ''),
                    'role' => trim($_POST['role'] ?? 'cliente'),
                    'password' => !empty($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : ''
                ];
                if($data['id'] > 0){
                    $this->userModel->updateUser($data);
                }
            } elseif($action === 'delete'){
                $userId = (int)($_POST['user_id'] ?? 0);
                if($userId > 0){
                    $this->userModel->deleteUser($userId);
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
}
