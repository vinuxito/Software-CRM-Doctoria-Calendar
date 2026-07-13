<?php
class Users extends Controller {
    private $userModel;

    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function register(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            // Init data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone'] ?? ''),
                'password' => trim($_POST['password']),
                'role' => isset($_POST['role']) && in_array($_POST['role'], ['cliente', 'medico']) ? $_POST['role'] : 'cliente',
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Ingresa tu correo electrónico';
            } else {
                // Check email
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Este correo ya está registrado';
                }
            }

            // Validate Name
            if(empty($data['name'])){
                $data['name_err'] = 'Ingresa tu nombre';
            }

            // Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Ingresa una contraseña';
            } elseif(strlen($data['password']) < 6){
                $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres';
            }

            // Validate Confirm Password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Confirma tu contraseña';
            } else {
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Las contraseñas no coinciden';
                }
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                // Validated
                
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if($this->userModel->register($data)){
                    header('location: ' . URLROOT . '/users/login');
                } else {
                    die('Ocurrió un error');
                }

            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }

        } else {
            // Init data
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'password' => '',
                'role' => 'cliente',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view
            $this->view('auth/register', $data);
        }
    }

    public function login(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Ingresa tu correo o usuario';
            }

            // Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Ingresa tu contraseña';
            }

            // Check for user/email
            if($this->userModel->findUserByEmail($data['email'])){
                // User found
            } else {
                $data['email_err'] = 'Usuario no encontrado';
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])){
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser){
                    // Create Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Contraseña incorrecta';

                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }

        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            // Load view
            $this->view('auth/login', $data);
        }
    }

    public function createUserSession($user){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->role;
        header('location: ' . URLROOT . '/dashboard');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        header('location: ' . URLROOT . '/users/login');
    }
}
