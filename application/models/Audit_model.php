<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function log(
        $actor_user_id,
        $action,
        $table_name,
        $record_id,
        $old_values = NULL,
        $new_values = NULL,
        $description = NULL
    ) {
        $data = [
            'actor_user_id' => $actor_user_id,
            'action'        => $action,
            'table_name'    => $table_name,
            'record_id'     => $record_id,
            'old_values'    => $old_values !== NULL
                ? json_encode($old_values)
                : NULL,
            'new_values'    => $new_values !== NULL
                ? json_encode($new_values)
                : NULL,
            'description'   => $description,
            'ip_address'    => $this->input->ip_address(),
            'user_agent'    => $this->input->user_agent()
        ];

        return $this->db->insert('audit_logs', $data);
    }

    public function get_all_logs() {
        $this->db->select('
            audit_logs.*,
            users.name as actor_name,
            roles.name as actor_role
        ');

        $this->db->from('audit_logs');

        $this->db->join(
            'users',
            'users.id = audit_logs.actor_user_id',
            'left'
        );

        $this->db->join(
            'roles',
            'roles.id = users.role_id',
            'left'
        );

        $this->db->order_by(
            'audit_logs.created_at',
            'DESC'
        );

        return $this->db->get()->result();
    }
}