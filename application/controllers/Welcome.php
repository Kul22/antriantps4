<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    // Konstruktor untuk memuat model
    public function __construct()
    {
        parent::__construct();
        // Memuat model Antrian_model
        $this->load->model('Antrian_model');
    }

    // Fungsi index untuk menampilkan halaman utama
    public function index()
    {
        // Mengambil data antrian dari model
        $data['antrian'] = $this->Antrian_model->get_all_antrian();

        // Informasi tentang mencoblos
        $data['info_mencoblos'] = "Untuk mencoblos, pilih calon yang sudah terdaftar dan ikuti prosedur di tempat pemungutan suara.";

        // Menampilkan tampilan dengan data yang diterima
        $this->load->view('welcome_message', $data);
    }
}
