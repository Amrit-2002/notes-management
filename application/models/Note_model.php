<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Note_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    // public function get_all_notes() {
    //     return $this->db
    //         ->where('user_id', $this->session->userdata('user_id'))
    //         ->where('deleted_at', null)
    //         ->order_by('updated_at', 'DESC')
    //         ->get('notes')->result();
    // }

    public function get_all_notes() {
        $user_id = $this->session->userdata('user_id');
    
        return $this->db
            ->distinct()
            ->select('notes.*')->from('notes')
            ->join('collaborators', 'notes.id = collaborators.note_id', 'left') // Join with collaborators table
            ->group_start() 
                ->where('notes.user_id', $user_id) // notes owned by the user
                ->or_where('collaborators.user_id', $user_id) // notes the user is a collaborator on
            ->group_end()
            ->where('notes.deleted_at', null)
            ->order_by('notes.updated_at', 'DESC')
            ->get()
            ->result();
    }

    public function insert_note($title, $desc, $content) {
        $data = array('user_id' => $this->session->userdata('user_id'),'title' => $title, 'desc' => $desc, 'content' => $content);
        $this->db->insert('notes', $data);
    }

    public function get_note_by_id($id) {
        return $this->db->get_where('notes', array('id' => $id))->row();
    }

    public function update_note($id, $title, $desc, $content) {
        $data = array('title' => $title, 'desc' => $desc, 'content' => $content, 'updated_by' => $this->session->userdata('user_id'));
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->where('id', $id);
        $this->db->update('notes', $data);
    }

    public function delete_note($id) {
        $data = array('deleted_by' => $this->session->userdata('user_id'));
        $this->db->set('deleted_at', 'NOW()', FALSE);
        $this->db->where('id', $id);
        $this->db->update('notes',$data);
    }

    public function update_collaborators_note($id, $collaborators){
        // Clear existing collaborators for this note
        $this->db->where('note_id',$id)->delete('collaborators');
    
        // Insert new collaborators
        if (!empty($collaborators)) {
            foreach ($collaborators as $user_id) {
                $this->db->insert('collaborators', [
                    'note_id' => $id,
                    'user_id' => $user_id,
                ]);
            }
        }
    }

    // public function update_collaborator_permissions_note($note_id, $collaborator_id, $can_read, $can_write, $can_delete){
    public function update_collaborator_permissions_note($note_id, $collaborator_id, $can_write, $can_delete){
        if ($collaborator_id) {
            // Update collaborator permissions in the database
            $data = array(
                // 'can_read' => $can_read,
                'can_write' => $can_write,
                'can_delete' => $can_delete
            );
    
            $this->db->where('note_id', $note_id);
            $this->db->where('user_id', $collaborator_id);
            $this->db->update('collaborators', $data);
    
            $this->session->set_flashdata('permissions_success', 'Permissions updated successfully.');
        } else {
            $this->session->set_flashdata('permissions_error', 'No collaborator selected.');
        }
    }

    public function get_collaborators_by_note_id($note_id) {
        $this->db->select('user_id');
        $this->db->from('collaborators');
        $this->db->where('note_id', $note_id);
        $query = $this->db->get();
        return array_column($query->result_array(), 'user_id');
    }    

        

    // public function search_notes($search_term, $user_id) {

    //     $this->db->where('user_id', $user_id)
    //     ->where('deleted_at', null)->order_by('updated_at', 'DESC');
        
    //     if (!empty($search_term)) {
    //         $this->db->group_start();
    //         $this->db->like('title', $search_term);
    //         $this->db->or_like('desc', $search_term);
    //         $this->db->group_end();
    //     }

    //     $query = $this->db->get('notes');
    //     return $query->result();
    // }
}
