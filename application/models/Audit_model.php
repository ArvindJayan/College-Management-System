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
}