<?php
	class User_model extends CI_Model{

		
		public function get_all_users() {
			return $this->db->get('users')->result();
		}

		public function get_current_collaborators_users($current_collaborators){
			if (!empty($current_collaborators) && is_array($current_collaborators)) {
				$this->db->select('users.*');
				$this->db->from('users');
				$this->db->where_in('id', $current_collaborators); // Match user IDs
				$query = $this->db->get();
				return $query->result(); // Return the user details as an array of objects
			} else {
				return []; // Return an empty array if no IDs are provided
			}
		}
		
		public function register($enc_password){
			// User data array
			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => $enc_password,
			);

			// Insert user
			return $this->db->insert('users', $data);
		}

		// Log user in
		public function login($username, $password){
			// Validate
			$this->db->where('username', $username);
			$this->db->where('password', $password);

			$result = $this->db->get('users');

			if($result->num_rows() == 1){
				return $result->row(0)->id;
			} else {
				return false;
			}
		}

		// Check username exists
		public function check_username_exists($username){
			$query = $this->db->get_where('users', array('username' => $username));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		// Check email exists
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}
	}