<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Note_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('permissions_helper');
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $data['notes'] = $this->Note_model->get_all_notes();
        $data['users'] = $this->User_model->get_all_users();

        $user_id = $this->session->userdata('user_id');
        $notes = $data['notes'];

        foreach ($notes as $note) {
            $permissions_delete[$note->id] = check_collaborator_permission($note->id, $user_id, 'delete');
        }
    
        // Pass permissions to the view
        $data['permissions_delete'] = $permissions_delete;

        $data['json_notes'] = json_encode($data['notes']); // Pass notes as JSON for Fuse.js
        $data['json_users'] = json_encode($data['users']);

        $this->load->view('templates/header');
        $this->load->view('notes_view', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('desc', 'Desc', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if($this->form_validation->run() === FALSE){
            $this->session->set_flashdata('error', 'Title, description and content are required fields.');

            $data['notes'] = $this->Note_model->get_all_notes();
            $this->load->view('templates/header');
            $this->load->view('notes_view', $data);
            $this->load->view('templates/footer');

            redirect('notes');
        } else {

            $title = $this->input->post('title');
            $desc = $this->input->post('desc');
            $content = $this->input->post('content');

            if (!empty($title) && !empty($desc) && !empty($content)) {
                $this->Note_model->insert_note($title, $desc, $content);
                $this->session->set_flashdata('success', 'Notes added successfully.');
            }
            else{
                $this->session->set_flashdata('error', 'Content is a required field.');
                redirect('notes');
            }
            redirect('notes');
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $note_id = $id;
        $data['current_collaborators'] = $this->Note_model->get_collaborators_by_note_id($note_id);

        $current_collaborators = $data['current_collaborators'];
        $data['current_collaborators_users'] = !empty($current_collaborators) ? 
                $this->User_model->get_current_collaborators_users($current_collaborators) : [];


        $data['note'] = $this->Note_model->get_note_by_id($id);
        $data['users'] = $this->User_model->get_all_users();

        $user_id = $this->session->userdata('user_id');

        $users = $data['users'];

        foreach ($users as $user) {
            $permissions_write_by_userid[$user->id] = check_collaborator_permission($id, $user->id, 'write');
            $permissions_delete_by_userid[$user->id] = check_collaborator_permission($id, $user->id, 'delete');
        }
        // Pass permissions to the view
        $data['permissions_write_by_userid'] = $permissions_write_by_userid;
        $data['permissions_delete_by_userid'] = $permissions_delete_by_userid;



        $permissions_write[$note_id] = check_collaborator_permission($note_id, $user_id, 'write');
        // Pass permissions to the view
        $data['permissions_write'] = $permissions_write;

        $this->load->view('templates/header');
        $this->load->view('edit_note_view', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('desc', 'Desc', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if($this->form_validation->run() === FALSE){
            $this->session->set_flashdata('error', 'Title, description and content are required fields.');

            $note_id = $id;
            $data['current_collaborators'] = $this->Note_model->get_collaborators_by_note_id($note_id);

            $current_collaborators = $data['current_collaborators'];
            $data['current_collaborators_users'] = !empty($current_collaborators) ? 
                    $this->User_model->get_current_collaborators_users($current_collaborators) : [];

            $data['note'] = $this->Note_model->get_note_by_id($id);
            $data['users'] = $this->User_model->get_all_users();
            $this->load->view('templates/header');
            $this->load->view('edit_note_view', $data);
            $this->load->view('templates/footer');
        }

        $title = $this->input->post('title');
        $desc = $this->input->post('desc');
        $content = $this->input->post('content');
        
        if (!empty($title) && !empty($desc) && !empty($content)) {
            $this->Note_model->update_note($id, $title, $desc, $content);
            $this->session->set_flashdata('update', 'Notes updated successfully.');
        }
        redirect('notes');
    }

    public function delete($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $this->Note_model->delete_note($id);
        $this->session->set_flashdata('delete', 'Notes deleted successfully.');
        redirect('notes');
    }

    public function update_collaborators($id, $user_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        if ($user_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('collaborators_error', 'You are not authorized to add collaborators for this note!');
            redirect('notes/edit/' . $id);
        }

        $collaborators = $this->input->post('collaborators');
    
        $this->Note_model->update_collaborators_note($id, $collaborators);       
    
        $this->session->set_flashdata('collaborators', 'Collaborators updated successfully!');
        redirect('notes/edit/' . $id);
    }    

    public function update_collaborator_permissions($note_id, $owner_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        // Ensure the current user is the owner of the note
        if ($this->session->userdata('user_id') != $owner_id) {
            show_error('Unauthorized action.', 403);
            redirect('notes/edit/' . $note_id);
        }
    
        $collaborator_id = $this->input->post('collaborator_id');
        // $can_read = $this->input->post('can_read') ? 1 : 0;
        $can_write = $this->input->post('can_write') ? 1 : 0;
        $can_delete = $this->input->post('can_delete') ? 1 : 0;

        // $this->Note_model->update_collaborator_permissions_note($note_id, $collaborator_id, $can_read, $can_write, $can_delete);
        $this->Note_model->update_collaborator_permissions_note($note_id, $collaborator_id, $can_write, $can_delete);
    
        redirect('notes/edit/' . $note_id);
    }    

    public function upload_image() {
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
    
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
        $config['max_size'] = 2048; // Limit to 2MB
    
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }
    
        $this->upload->initialize($config);
    
        if (!$this->upload->do_upload('upload')) {
            // Handle upload error
            echo json_encode(['error' => ['message' => $this->upload->display_errors('', '')]]);
        } else {
            $data = $this->upload->data();
            $file_url = base_url('uploads/' . $data['file_name']);
            echo json_encode(['url' => $file_url]);
        }
    }
    

    
    // public function search_notes() {
    //     if (!$this->session->userdata('logged_in')) {
    //         redirect('users/login');
    //     }

    //     $search_term = $this->input->get('q');
    //     $user_id = $this->session->userdata('user_id');

    //     $this->load->model('Note_model');
    //     $data['notes'] = $this->Note_model->search_notes($search_term, $user_id);

    //     $this->load->view('templates/header');
    //     $this->load->view('notes_view', $data);
    //     $this->load->view('templates/footer');
    // }    
}
