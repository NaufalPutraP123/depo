<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        $this->load->model('M_Datatables');
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
            'title_web' => 'Data Customer',
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/customer/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }
    
    public function data_customer()
    {
        if ($this->input->method(true)=='POST'):
            $query = "SELECT * FROM customer";
            $search = array('kode_customer','nama','hp','alamat');
            $where  = null;
            $iswhere = null;
            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function cek_customer()
    {
        $id =  (int)$this->input->post("id"); // parameter yang mau di update
        $cek = $this->db->query("SELECT * FROM customer WHERE customer.id = ?", array($id)); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $data = $cek->row();
            $result[] = array(
                'id' 	=> $data->id,
                'nama'	=> $data->nama,
            );
            echo json_encode($result);
        } else {
            echo '';
        }
    }
    
    public function tambah()
    {
        $kode = $this->db->query("SELECT * FROM customer ORDER BY id DESC LIMIT 1");
        
        if ($kode->num_rows() > 0) {
            $ps = $kode->row();
            $kode_cus = $ps->id + 1;
        } else {
            $kode_cus = 1;
        }
        
        $this->data = [
            'title_web' => 'Tambah Customer',
            'kode'  	=> 'C000'.$kode_cus,
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/customer/tambah', $this->data);
        $this->load->view('layout/footer', $this->data);
    }
    
    public function store()
    {
        $this->form_validation->set_rules("kode_customer", "Kode customer", "required");
        $this->form_validation->set_rules("nama", "Nama", "required");

        /* $this->form_validation->set_rules("alamat", "Alamat", "required");
        $this->form_validation->set_rules("hp", "Hp", "required");
        $this->form_validation->set_rules("tgl_lahir", "Tgl lahir", "required");
        $this->form_validation->set_rules("keterangan", "Keterangan", "required"); */

        if ($this->form_validation->run() != false) {
            $data = [
                'kode_customer' => htmlspecialchars($this->input->post("kode_customer", true), ENT_QUOTES),
                'nama' => htmlspecialchars($this->input->post("nama", true), ENT_QUOTES),
                'alamat' => htmlspecialchars($this->input->post("alamat", true), ENT_QUOTES),
                'hp' => htmlspecialchars($this->input->post("hp", true), ENT_QUOTES),
                'keterangan' => htmlspecialchars($this->input->post("keterangan", true), ENT_QUOTES),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            
            $this->db->insert("customer", $data);
            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("customer"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! ".validation_errors());
            redirect(base_url("customer/tambah"));
        }
    }

    public function detail()
    {
        $id = (int)$this->uri->segment('3');
        $cek = $this->db->get_where("customer", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $edit = $cek->row();
        } else {
            $this->session->set_flashdata("failed", " Tidak ditemukan data ID dari Customer ! ");
            redirect(base_url('customer'));
        }
                
        $this->data = [
            'title_web' => 'Detail Customer',
            'edit'		=> $edit
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/customer/detail', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function edit()
    {
        $id = (int)$this->uri->segment('3');
        $cek = $this->db->get_where("customer", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $edit = $cek->row();
        } else {
            $this->session->set_flashdata("failed", " Tidak ditemukan data ID dari Customer ! ");
            redirect(base_url('customer'));
        }
                
        $this->data = [
            'title_web' => 'Edit Customer',
            'edit'		=> $edit
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/customer/edit', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function update()
    {
        $id = (int)$this->input->post("id"); // parameter yang mau di update
        $this->form_validation->set_rules("id", "Id", "required");
        $this->form_validation->set_rules("kode_customer", "Kode customer", "required");
        $this->form_validation->set_rules("nama", "Nama", "required");
        /* $this->form_validation->set_rules("alamat", "Alamat", "required");
        $this->form_validation->set_rules("hp", "Hp", "required");
        $this->form_validation->set_rules("tgl_lahir", "Tgl lahir", "required");
        $this->form_validation->set_rules("keterangan", "Keterangan", "required"); */
        if ($this->form_validation->run() != false) {
            $data = [
                'kode_customer' => htmlspecialchars($this->input->post("kode_customer", true), ENT_QUOTES),
                'nama' => htmlspecialchars($this->input->post("nama", true), ENT_QUOTES),
                'alamat' => htmlspecialchars($this->input->post("alamat", true), ENT_QUOTES),
                'hp' => htmlspecialchars($this->input->post("hp", true), ENT_QUOTES),
                'keterangan' => htmlspecialchars($this->input->post("keterangan", true), ENT_QUOTES),
            ];

            $this->db->where("id", $id); // ubah id dan postnya
            $this->db->update("customer", $data);
            $this->session->set_flashdata("success", " Berhasil Update Data ! ");
            redirect(base_url("customer/edit/".$id));
        } else {
            $this->session->set_flashdata("failed", " Gagal Update Data ! ".validation_errors());
            redirect(base_url("customer/edit/".$id));
        }
    }

    public function delete()
    {
        $id = (int)$this->input->get("id");
        $cek = $this->db->get_where("customer", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $this->db->where("id", $id); // tulis id yang dituju
            $this->db->delete("customer");
            $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
            redirect(base_url("customer"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Delete Data ! ".validation_errors());
            redirect(base_url("customer"));
        }
    }
}
