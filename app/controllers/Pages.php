<?php
class Pages extends Controller {
    public function __construct(){
        
    }

    public function index(){
        if(isset($_SESSION['user_id'])){
            header('location: ' . URLROOT . '/dashboard');
        } else {
            header('location: ' . URLROOT . '/users/login');
        }
    }
}
