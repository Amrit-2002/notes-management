<?php  
    defined('BASEPATH') OR exit('No direct script access allowed');  

    class Login extends CI_Controller {  
        
        public function check_login() {
            $this->CI =& get_instance();

            $this->CI->load->library('session');
            $this->CI->load->helper('url');
        
            // current route
            $current_controller = $this->CI->router->fetch_class();
            $current_method = $this->CI->router->fetch_method();
        
            $public_routes = [
                'Pages' => ['view'],
                'Users' => ['login', 'register']
            ];
            // print_r($public_routes);
            // echo($current_controller);
            // exit;
            
            if (!isset($public_routes[$current_controller]) || 
                !in_array($current_method, $public_routes[$current_controller])) {
                if (!$this->CI->session->userdata('logged_in')) {
                        redirect('users/login');
                }
            }
        }


        // private $public_routes = [
        //     'Pages' => ['view'],
        //     'Users' => ['login', 'register']
        // ];
    
        // public function check_login() {
        //     $CI =& get_instance();

        //     $base_url = $CI->config->base_url();
            
        //     $current_controller = $CI->router->fetch_class();
        //     $current_method = $CI->router->fetch_method();
    
        //     if ($this->is_route_protected($current_controller, $current_method)) {
        //         if (!$CI->session->userdata('logged_in')) {
        //             redirect($base_url . 'users/login');
        //         }
        //     }
        // }
    
        // private function is_route_protected($controller, $method) {
        //     return !isset($this->public_routes[$controller]) || 
        //            !in_array($method, $this->public_routes[$controller]);
        // }
    }  
?>  