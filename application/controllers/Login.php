<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_login');
        $this->load->helper('tgl_default');
        $this->load->helper('alert');
    }
     
    public function index()
    {
        if ($this->session->userdata('masuk_sistem') == true) {
            $url=base_url('home');
            redirect($url);
        }
        
        $this->data['title_web'] = 'Login';
        $this->load->view('login/index', $this->data);
    }

    public function proses()
    {
        $user = htmlspecialchars($this->input->post('user', true), ENT_QUOTES);
        $pass = htmlspecialchars($this->input->post('pass', true), ENT_QUOTES);
        // auth
        $proses_login = $this->db->query("SELECT * FROM login WHERE user = ?", array($user));
        $row = $proses_login->num_rows();
        if ($row > 0) {
            $hasil_login = $proses_login->row_array();
            if (password_verify($pass, $hasil_login['pass'])) {
                // create session
                $this->session->set_userdata('masuk_sistem', true);
                $this->session->set_userdata('ses_id', $hasil_login['id']);
                $this->session->set_userdata('ses_user', $hasil_login['user']);
                $this->session->set_userdata('ses_nama', $hasil_login['nama_user']);
                $this->session->set_userdata('ses_level', $hasil_login['level']);
                $this->session->set_flashdata('success', '<strong>Hai '.$hasil_login['nama_user'].'!</strong> Selamat datang Kembali ..');
                redirect(base_url('home'));
            } else {
                $this->session->set_flashdata('failed', '<strong>Login Gagal,</strong> Periksa Kembali Password Anda !');
                redirect(base_url('login'));
            }
        } else {
            $this->session->set_flashdata('failed', '<strong>Login Gagal,</strong> Periksa Kembali Username dan Password Anda !');
            redirect(base_url('login'));
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}
