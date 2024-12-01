<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Antrian extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Dpt_model');
        $this->load->model('Antrian_model');
    }

    public function index()
    {
        // Ambil data DPT yang tersedia dan data antrian
        $available_dpt = $this->Dpt_model->get_available_dpt();
        $antrian = $this->Antrian_model->get_all_antrian();

        // Ambil data progress berdasarkan jenis kelamin
        $progress_data = $this->Antrian_model->get_progress_data();

        $data['available_dpt'] = $available_dpt;
        $data['antrian'] = $antrian;

        // Progress data untuk progress bar
        $data['maleChosen'] = $progress_data['maleChosen'];
        $data['femaleChosen'] = $progress_data['femaleChosen'];
        $data['totalMale'] = $progress_data['totalMale'];
        $data['totalFemale'] = $progress_data['totalFemale'];

        // Load view
        $this->load->view('layouts/header');
        $this->load->view('antrian/index', $data);
        $this->load->view('layouts/footer');
    }


    public function hadir()
    {
        $id_dpt = $this->input->post('id_dpt'); // Ambil ID dari input hidden
        
        if ($id_dpt) {
            // Ambil nama dari tabel dpt berdasarkan id_dpt
            $this->db->select('nama');
            $this->db->from('dpt');
            $this->db->where('id', $id_dpt);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $nama = $query->row()->nama; // Ambil nama dari hasil query

                // Tambahkan ke antrian
                $this->Antrian_model->add_to_queue($id_dpt);

                // Set flashdata untuk pesan sukses dengan nama yang ditambahkan
                $this->session->set_flashdata('message', $nama . ' berhasil ditambahkan ke antrian.');
                $this->session->set_flashdata('alert_type', 'alert-info');
            } else {
                // Jika ID DPT tidak ditemukan
                $this->session->set_flashdata('message', 'ID DPT tidak valid!');
                $this->session->set_flashdata('alert_type', 'alert-danger');
            }
            
            redirect('antrian'); // Redirect ke halaman antrian
        } else {
            // Jika ID DPT tidak dikirim atau kosong
            $this->session->set_flashdata('message', 'Nama tidak valid!');
            $this->session->set_flashdata('alert_type', 'alert-danger');
            redirect('antrian'); // Redirect ke halaman antrian
        }
    }




    public function selesai($id)
    {
        // Ambil id_dpt berdasarkan id antrian
        $this->db->select('id_dpt');
        $this->db->from('antrian');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Ambil id_dpt dari hasil query
            $id_dpt = $query->row()->id_dpt;

            // Ambil nama dari tabel dpt berdasarkan id_dpt
            $this->db->select('nama');
            $this->db->from('dpt');
            $this->db->where('id', $id_dpt);
            $dpt_query = $this->db->get();

            if ($dpt_query->num_rows() > 0) {
                $nama = $dpt_query->row()->nama; // Ambil nama dari hasil query

                // Tandai antrian sebagai selesai
                $this->Antrian_model->mark_as_done($id);

                // Set flashdata untuk pesan sukses dengan nama yang selesai
                $this->session->set_flashdata('message', $nama . ' berhasil ditambahkan ke Daftar Hadir.');
                $this->session->set_flashdata('alert_type', 'alert-info');
            } else {
                // Jika id_dpt tidak ditemukan di tabel dpt
                $this->session->set_flashdata('message', 'Nama tidak ditemukan.');
                $this->session->set_flashdata('alert_type', 'alert-danger');
            }
        } else {
            // Jika id antrian tidak ditemukan
            $this->session->set_flashdata('message', 'Antrian tidak valid.');
            $this->session->set_flashdata('alert_type', 'alert-danger');
        }

        // Redirect ke halaman antrian
        redirect('antrian');
    }


    public function get_antrian_data()
    {
        // Ambil data antrian terbaru
        $antrian = $this->Antrian_model->get_all_antrian();

        // Ambil data progress
        $progress_data = $this->Antrian_model->get_progress_data();

        // Gabungkan semua data menjadi array
        $response = [
            'antrian' => $antrian,
            'progress' => [
                'maleChosen' => $progress_data['maleChosen'],
                'femaleChosen' => $progress_data['femaleChosen'],
                'totalMale' => $progress_data['totalMale'],
                'totalFemale' => $progress_data['totalFemale'],
            ],
        ];

        // Kirim data dalam format JSON
        echo json_encode($response);
    }




}
