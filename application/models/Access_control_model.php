<?php

class Access_control_model extends CI_Model
{


    public $id;
    public $group_id;
    public $department_id;


    public function __construct()
    {
// Call the CI_Model constructor
        parent::__construct();
        $this->config->load('db_tables');
    }

    public function get_entries($limit, $offset)
    {
        if ($limit == 0 && $offset == 0) {
            $query = $this->db->get($this->config->item('access_control_table'));
        } else {
            $query = $this->db->get($this->config->item('access_control_table'), $limit, $offset);
        }
        return $query->result();
    }

    public function get_entries_joined()
    {

        $main_t = $this->config->item('access_control_table');

        //$this->db->select(" " . $main_t . ".id as id,   " . $this->config->item('group_table') . ".username as user, " . $this->config->item('role_table') . ".name as role , " . $this->config->item('department_table') . ".name as department");
        $this->db->select(" " . $main_t . ".id as id,   " . $this->config->item('group_table') . ".name as group,  " . $this->config->item('department_table') . ".name as department");
        $this->db->from($main_t);
        $this->db->join($this->config->item('group_table'), $main_t . ".group_id = " . $this->config->item('group_table') . ".id", 'left');
        //$this->db->join($this->config->item('role_table'), $main_t . ".role_id = " . $this->config->item('role_table') . ".id", 'left');
        $this->db->join($this->config->item('department_table'), $main_t . ".department_id = " . $this->config->item('department_table') . ".id", 'left');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function get_entry_by_id($id)
    {
        $query = $this->db->get_where($this->config->item('access_control_table'), array('id' => $id));
        return $query->result();

    }

    public function is_duplicate()
    {

        $this->group_id = $this->input->post('group_id', true);
        $this->department_id = $this->input->post('department_id', true);
        $query = $this->db->get_where($this->config->item('access_control_table'), array('group_id' => $this->group_id, 'department_id' => $this->department_id));
        return $query->result();
    }

    public function get_last_ten_entries()
    {
        $query = $this->db->get($this->config->item('access_control_table'), 10);
        return $query->result();
    }

    public function insert_entry()
    {

        $this->group_id = $this->input->post('group_id', true);
        //$this->role_id = $this->input->post('role_id', true);
        $this->department_id = $this->input->post('department_id', true);


        $this->db->insert($this->config->item('access_control_table'), $this);


        //echo $this->db->last_query();
    }

    public function update_entry()
    {
        $this->id = $this->input->post('id', true);
        $this->group_id = $this->input->post('group_id', true);
        //$this->role_id = $this->input->post('role_id', true);
        $this->department_id = $this->input->post('department_id', true);

        $this->db->update($this->config->item('access_control_table'), $this, array('id' => $this->id));
    }

    function row_delete($id)
    {

        $this->db->where('id', $id);
        $this->db->delete($this->config->item('access_control_table'));
    }

}

?>