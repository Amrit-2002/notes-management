<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// if (!function_exists('check_collaborator_permission')) {
    function check_collaborator_permission($note_id, $user_id, $action) {
        $CI = &get_instance();
        
        // Check if the user is the owner
        $note = $CI->db->get_where('notes', ['id' => $note_id, 'user_id' => $user_id])->row();

        if ($note) {
            return true; // Owners have full access
        }

        // Check collaborator permissions
        $collaborator = $CI->db->get_where('collaborators', ['note_id' => $note_id, 'user_id' => $user_id])->row();
        if ($collaborator) {
            if ($action === 'read' && $collaborator->can_read) return true;
            if ($action === 'write' && $collaborator->can_write) return true;
            if ($action === 'delete' && $collaborator->can_delete) return true;
        }

        return false; // No permissions
    }
// }
