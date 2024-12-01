<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpt_model extends CI_Model {

    public function get_all()
    {
        return $this->db->get('dpt')->result_array();
    }

    public function get_available_dpt()
    {
        $this->db->select('id, nama');
        $this->db->from('dpt');
        $this->db->where('id NOT IN (SELECT id_dpt FROM memilih)', NULL, FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function search_by_name($term)
    {
        $this->db->select('dpt.id, dpt.nama, dpt.no_dpt');
        $this->db->from('dpt');
        $this->db->like('dpt.nama', $term);  // Pencarian berdasarkan nama
        
        $this->db->join('memilih', 'memilih.id_dpt = dpt.id', 'left');

        $this->db->join('antrian', 'antrian.id_dpt = dpt.id', 'left');

        $this->db->where('memilih.id_dpt IS NULL');
        $this->db->where('antrian.id_dpt IS NULL');
        $this->db->limit(10);

        // Debugging: Periksa query yang dijalankan
        $query = $this->db->get();
        if (!$query) {
            echo "Error in query: " . $this->db->last_query();
            return [];
        }

        return $query->result_array();
    }




}
