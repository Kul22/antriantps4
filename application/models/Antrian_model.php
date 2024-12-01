<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Antrian_model extends CI_Model {

    public function get_all_antrian()
    {
        $this->db->select('antrian.id, antrian.id_dpt, dpt.nama, dpt.jenis_kelamin');
        $this->db->from('antrian');
        $this->db->join('dpt', 'dpt.id = antrian.id_dpt'); // Join tabel dpt
        $this->db->order_by('antrian.id', 'ASC'); // Urutkan berdasarkan id antrian secara ascending
        $query = $this->db->get();
        return $query->result_array();
    }



    public function add_to_queue($id_dpt)
    {
        $data = [
            'id_dpt' => $id_dpt,
            'waktu_hadir' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('antrian', $data);
    }

    public function mark_as_done($id)
    {
        // Move to memilih table
        $antrian = $this->db->get_where('antrian', ['id' => $id])->row_array();
        if ($antrian) {
            $data = [
                'id_dpt' => $antrian['id_dpt'],
                'waktu' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('memilih', $data);

            // Remove from antrian
            $this->db->delete('antrian', ['id' => $id]);
        }
    }

    public function get_progress_data()
    {
        // Ambil jumlah yang memilih berdasarkan jenis kelamin
        $this->db->select('dpt.jenis_kelamin, COUNT(*) as chosen_count');
        $this->db->from('memilih');
        $this->db->join('dpt', 'memilih.id_dpt = dpt.id');
        $this->db->group_by('dpt.jenis_kelamin');
        $chosen = $this->db->get()->result_array();

        // Ambil total jumlah pemilih berdasarkan jenis kelamin
        $this->db->select('jenis_kelamin, COUNT(*) as total_count');
        $this->db->from('dpt');
        $this->db->group_by('jenis_kelamin');
        $total = $this->db->get()->result_array();

        // Format data
        $result = [
            'maleChosen' => 0,
            'femaleChosen' => 0,
            'totalMale' => 0,
            'totalFemale' => 0,
        ];

        foreach ($chosen as $row) {
            if ($row['jenis_kelamin'] === 'L') {
                $result['maleChosen'] = $row['chosen_count'];
            } elseif ($row['jenis_kelamin'] === 'P') {
                $result['femaleChosen'] = $row['chosen_count'];
            }
        }

        foreach ($total as $row) {
            if ($row['jenis_kelamin'] === 'L') {
                $result['totalMale'] = $row['total_count'];
            } elseif ($row['jenis_kelamin'] === 'P') {
                $result['totalFemale'] = $row['total_count'];
            }
        }

        return $result;
    }
    
}
