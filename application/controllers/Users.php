<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        $this->load->model('M_Datatables');
        $this->load->helper('tgl_default');
        $this->load->helper('alert');
        $this->load->library('form_validation');
        if ($this->session->userdata('masuk_sistem') != true) {
            $url=base_url('login');
            redirect($url);
        } else {
            if ($this->session->userdata('ses_level') == 'Users') {
                redirect(base_url('dashboard'));
            }
        }
    }
     
    public function index()
    {
        $this->data = [
            'id_user'	 => $this->session->userdata('ses_id'),
            'title_web'  => 'Daftar Users',
            'sidebar' 	 => 'users',
            'user'       => $this->db->query("SELECT * FROM login WHERE login.deleted_at IS NULL")->result_array()
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/users/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function data_users()
    {
        if ($this->input->method(true)=='POST'):
            $query = "SELECT * FROM login";
            $search = array('nama_user','user','telepon','level','alamat');
            $where  = null;
            $iswhere = 'login.deleted_at IS NULL';
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function tambah()
    {
        $this->data = [
            'id_user'	 => $this->session->userdata('ses_id'),
            'title_web'  => 'Tambah Users',
            'sidebar' 	 => 'users',
        ];
        
        $this->data['title_web'] = 'Tambah User ';
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/users/tambah', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function add()
    {
        $this->form_validation->set_rules("user", "User", "required|is_unique[login.user]");
        $this->form_validation->set_rules("pass", "Pass", "required");
        $this->form_validation->set_rules("nama", "Nama user", "required");
        $this->form_validation->set_rules("alamat", "Alamat", "required");
        $this->form_validation->set_rules("email", "Email", "required");
        $this->form_validation->set_rules("telepon", "Telepon", "required");
        $this->form_validation->set_rules("level", "Level", "required");

        if ($this->form_validation->run() != false) {
            $nama = htmlentities($this->input->post('nama', true));
            $user = htmlentities($this->input->post('user', true));
            $email = htmlentities($this->input->post('email', true));
            $level = htmlentities($this->input->post('level', true));
            $telepon = htmlentities($this->input->post('telepon', true));
            $alamat = htmlentities($this->input->post('alamat', true));
            $pass = htmlentities($this->input->post('pass', true));
            $passhash = password_hash($pass, PASSWORD_DEFAULT);
            
            $cek = $this->db->get_where("login", ["user" => $user]); // tulis id yang dituju
            if ($cek->num_rows() > 0) {
                $this->session->set_flashdata("failed", " Gagal tambah data, Username Telah di pakai ! ");
                redirect(base_url('users/tambah'));
            }
            
            $data = array(
                'nama_user'=>$nama,
                'user'=>$user,
                'pass'=>$passhash,
                'email' => $email,
                'level'=>$level,
                'telepon'=>$telepon,
                'alamat'=>$alamat,
                'tgl_bergabung'=>date('Y-m-d')
            );

            $upload_foto = $_FILES['gambar']['name'];
            if ($upload_foto) {
                // setting konfigurasi upload
                $nmfile = "user_".time();
                $config['upload_path'] = './assets/image/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $nmfile;
                // load library upload
                $this->load->library('upload', $config);
                // upload gambar
                if ($this->upload->do_upload('gambar')) {
                    $result1 = $this->upload->data();
                    $result = array('gambar'=>$result1);
                    $data1 = array('upload_data' => $this->upload->data());
                    $this->db->set('foto', $data1['upload_data']['file_name']);
                } else {
                    $this->session->set_flashdata("failed", " Gagal Insert Data ! ".$this->upload->display_errors());
                    redirect(base_url('users/tambah'));
                }
            } else {
                $this->db->set('foto', '-');
            }
            
            $this->db->insert('login', $data);

            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url('users'));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! ".validation_errors());
            redirect(base_url('users/tambah'));
        }
    }

    public function edit()
    {
        if ($this->uri->segment('3') == '') {
            echo '<script>alert("halaman tidak ditemukan");window.location="'.base_url('users').'";</script>';
        }
        $user =  $this->db->query("SELECT * FROM login WHERE login.deleted_at IS NULL AND 
            login.id = ? ", array($this->uri->segment('3')))->row();
        if (isset($user)) {
        } else {
            $this->session->set_flashdata("failed", " Tidak ditemukan data ID dari Users ! ");
            redirect(base_url('users'));
        }

        $this->data = [
            'id_user'	 => $this->session->userdata('ses_id'),
            'title_web'  => 'Edit Users',
            'sidebar' 	 => 'users',
            'user'       => $user,
        ];

        $this->data['title_web'] = 'Edit User ';
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/users/edit', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function upd()
    {
        $id = htmlentities($this->input->post('id', true));
        $user =  $this->db->get_where("login", array('id' => $id))->row();
        if ($this->input->post('user') == $user->user) {
            $is_unique =  '';
        } else {
            $is_unique =  '|is_unique[login.user]';
        }

        $this->form_validation->set_rules("user", "User", "required|trim".$is_unique);
        if ($this->form_validation->run() != false) {
            $nama = htmlentities($this->input->post('nama', true));
            $user = htmlentities($this->input->post('user', true));
            $email = htmlentities($this->input->post('email', true));
           
            $level = htmlentities($this->input->post('level', true));
            $telepon = htmlentities($this->input->post('telepon', true));
            $alamat = htmlentities($this->input->post('alamat', true));
            $id = htmlentities($this->input->post('id', true));
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
                'email' => $email,
                'level'=>$level,
                'telepon'=>$telepon,
                'alamat'=>$alamat,
            );
            $this->M_Admin->update_table('login', 'id', $id, $data);
            $this->session->set_flashdata('success', 'Berhasil Update User : '.$nama.' !');
            redirect(base_url('users/edit/'.$id));
        } else {
            $this->session->set_flashdata("failed", " Gagal  Update User ! ".validation_errors());
            redirect(base_url('users/edit/'.$id));
        }
    }
   
    public function delete()
    {
        $id =  strip_tags($this->input->get("id")); // parameter yang mau di update
        $cek =  $this->db->query("SELECT * FROM login WHERE login.deleted_at IS NULL AND 
            login.id = ? ", array($id));
        if ($cek->num_rows() > 0) {
            $data = [
                'deleted_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where("id", $id); // ubah id dan postnya
            $this->db->update("login", $data);
            $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
            redirect(base_url('users'));
        } else {
            $this->session->set_flashdata("failed", " Tidak ditemukan data ID dari Users ! ");
            redirect(base_url('users'));
        }
    }
}
