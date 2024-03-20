<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        $this->load->helper('tgl_default');
        $this->load->helper('alert');
        if ($this->session->userdata('masuk_sistem') != true) {
            $url=base_url('login');
            redirect($url);
        }
    }
     
    public function index()
    {
        $this->data = [
            'id_user'	 => $this->session->userdata('ses_id'),
            'title_web'  => 'Edit Pengguna',
            'sidebar' 	 => 'pengguna',
            'user'       => $this->M_Admin->get_tableid_edit('login', 'id', $this->session->userdata('ses_id')),
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/user/edit', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function upd()
    {
        $id = $this->session->userdata('ses_id');
        $user =  $this->db->get_where("login", array('id' => $id))->row();
        if ($this->input->post('user') == $user->user) {
            $is_unique =  '';
        } else {
            $is_unique =  '|is_unique[login.user]';
        }
        $this->form_validation->set_rules("user", "User", "required|trim".$is_unique);
        if ($this->form_validation->run() != false) {
            $nama = htmlentities($this->input->post('nama', true));
            $email = htmlentities($this->input->post('email', true));
            $user = htmlentities($this->input->post('user', true));
            $telepon = htmlentities($this->input->post('telepon', true));
            $alamat = htmlentities($this->input->post('alamat', true));

            // setting konfigurasi upload
            $nmfile = "user_".time();
            $config['upload_path'] = './assets/image/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name'] = $nmfile;
            // load library upload
            $this->load->library('upload', $config);
            // upload gambar 1
            if ($this->upload->do_upload('gambar')) {
                $result1 = $this->upload->data();
                $result = array('gambar'=>$result1);
                $data1 = array('upload_data' => $this->upload->data());
                unlink('./assets/image/'.$this->input->post('foto'));
                $this->db->set('foto', $data1['upload_data']['file_name']);
            }

            if (!empty($this->input->post('pass'))) {
                $pass = htmlentities($this->input->post('pass'));
                $passhash = password_hash($pass, PASSWORD_DEFAULT);
                $this->db->set('pass', $passhash);
            }

            $data = array(
                'nama_user'=>$nama,
                'user'=>$user,
                'email'=>$email,
                'telepon'=>$telepon,
                'alamat'=>$alamat,
            );
            $this->M_Admin->update_table('login', 'id', $id, $data);
            $this->session->set_flashdata('success', 'Berhasil Update User : '.$nama.' !');
            redirect(base_url('user'));
        } else {
            $this->session->set_flashdata("failed", " Gagal  Update User ! ".validation_errors());
            redirect(base_url('user'));
        }
    }
}
