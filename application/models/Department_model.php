<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model
{
    protected $table = 'departments';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_departments()
    {
        return $this->db
            ->order_by('name', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_department($id)
    {
        return $this->db
            ->where('id', $id)
            ->get($this->table)
            ->row();
    }

    public function create_department($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_department($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete_department($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    public function name_exists($name, $exclude_id = NULL)
    {
        $this->db->where('name', $name);

        if ($exclude_id !== NULL) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    public function code_exists($code, $exclude_id = NULL)
    {
        $this->db->where('code', $code);

        if ($exclude_id !== NULL) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results($this->table) > 0;
    }
}