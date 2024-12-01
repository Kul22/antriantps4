<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpt extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dpt_model');  // Memuat model Dpt_model
    }

    public function autocomplete() {
        header('Content-Type: application/json');
        $term = $this->input->get('term');  // Ambil parameter 'term' dari URL

        if (empty($term)) {
            echo json_encode([]);  // Jika 'term' kosong, kembalikan array kosong
            return;
        }

        // Ambil data berdasarkan pencarian 'term' dari model
        $results = $this->Dpt_model->search_by_name($term);

        $data = [];
        
            foreach ($results as $row) {
                $data[] = [
                    'id' => $row['id'],  // ID pemilih
                    'label' => $row['nama'] . ' | ' . $row['no_dpt'],  // Gabungkan nama dan no_dpt
                    'value' => $row['nama'],  // Hanya nama yang akan dimunculkan pada input
                ];
            }
        

        echo json_encode($data);  // Kembalikan data sebagai JSON
    }
}

