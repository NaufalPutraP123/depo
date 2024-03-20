<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan extends CI_Controller
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
        if (!empty($this->input->get('id'))) {
            $id     = (int)$this->input->get('id');
            $edit   = $this->db->query('SELECT * FROM keuangan_ledger WHERE id = ?', [$id])->row();
        } else {
            $edit = 0;
        }

        $this->data = [
            'title_web' => 'Ledger',
            'keuangan_ledger' => $this->db->query('SELECT * FROM keuangan_ledger')->result(),
            'edit' => $edit
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/keuangan/ledger/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function store()
    {
        $this->form_validation->set_rules("no_ledger", "No ledger", "required");
        $this->form_validation->set_rules("jenis", "Jenis", "required");
        if ($this->form_validation->run() != false) {
            $data = [
                'no_ledger' => htmlspecialchars($this->input->post("no_ledger", true), ENT_QUOTES),
                'keterangan' => htmlspecialchars($this->input->post("keterangan", true), ENT_QUOTES),
                'jenis' => htmlspecialchars($this->input->post("jenis", true), ENT_QUOTES),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert("keuangan_ledger", $data);
            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("keuangan"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! ".validation_errors());
            redirect(base_url("keuangan"));
        }
    }

    public function update()
    {
        $id =  (int)$this->input->post("id"); // parameter yang mau di update
        $this->form_validation->set_rules("no_ledger", "No ledger", "required");
        $this->form_validation->set_rules("jenis", "Jenis", "required");
        if ($this->form_validation->run() != false) {
            $data = [
                'no_ledger' => htmlspecialchars($this->input->post("no_ledger", true), ENT_QUOTES),
                'keterangan' => htmlspecialchars($this->input->post("keterangan", true), ENT_QUOTES),
                'jenis' => htmlspecialchars($this->input->post("jenis", true), ENT_QUOTES),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->where("id", $id); // ubah id dan postnya
            $this->db->update("keuangan_ledger", $data);
            $this->session->set_flashdata("success", " Berhasil Update Data ! ");
            redirect(base_url("keuangan?id=".$id));
        } else {
            $this->session->set_flashdata("failed", " Gagal Update Data ! ".validation_errors());
            redirect(base_url("keuangan?id=".$id));
        }
    }

    public function delete()
    {
        $id = (int)$this->input->get("id");
        $cek = $this->db->get_where("keuangan_ledger", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $this->db->where("id", $id); // tulis id yang dituju
            $this->db->delete("keuangan_ledger");
            $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
            redirect(base_url("keuangan"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Delete Data ! ".validation_errors());
            redirect(base_url("keuangan"));
        }
    }

    // keuangan lainnya

    public function lain()
    {
        error_reporting(0);
        $sql = "SELECT SUM(jumlah_masuk) AS masuk, SUM(jumlah_keluar) AS keluar FROM keuangan_lainnya";
        if (!empty($this->input->get('a') && $this->input->get('b'))) {
            $a          = $this->input->get('a');
            $b          = $this->input->get('b');
            $dtb1       = $this->db->query($sql.' WHERE no_ledger LIKE "%'.$this->input->get('no_ledger').'%" AND date BETWEEN "'.$a.'" AND "'.$b.'"');
            $url        = base_url('keuangan/data?no_ledger='.
                            htmlentities($this->input->get('no_ledger')).'&a='.
                            htmlentities($this->input->get('a')).'&b='.
                            htmlentities($this->input->get('b')));
            $url_pdf    = base_url('keuangan/excel?no_ledger='.
                            htmlentities($this->input->get('no_ledger')).'&a='.
                            htmlentities($this->input->get('a')).'&b='.
                            htmlentities($this->input->get('b')));
            $data_ledger = $this->db->query('SELECT * FROM keuangan_ledger WHERE no_ledger = ?', [$this->input->get('no_ledger')])->row();
            $nm_ledger   = $data_ledger->keterangan;
        } else {
            $dtb1 = $this->db->query($sql.' WHERE periode = ?', [date('Y-m')]);
            $url  = base_url('keuangan/data');
            $url_pdf = base_url('keuangan/excel');
            $nm_ledger   = '';
        }

        $ledger = $this->db->query('SELECT * FROM keuangan_ledger')->result();

        $this->data = [
            'title_web' => 'Keuangan Lainnya',
            'sidebar'   => 'keuangan',
            'tot'       => $dtb1->row(),
            'ledger'    => $ledger,
            'nm_ledger' => $nm_ledger,
            'url'       => $url,
            'url_pdf'   => $url_pdf,
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/keuangan/lain/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function edit()
    {
        $this->data = [
            'title_web' => 'Keuangan Lainnya',
            'sidebar'   => 'keuangan',
            'ledger' => $this->db->query('SELECT * FROM keuangan_ledger')->result(),
            'edit'      => $this->db->query('SELECT * FROM keuangan_lainnya WHERE id = ?', [(int)$this->uri->segment('3')])->row(),
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/keuangan/lain/edit', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function data()
    {
        if ($this->input->method(true)=='POST'):
            $query = "SELECT keuangan_ledger.keterangan as ket, keuangan_lainnya.* 
                        FROM keuangan_lainnya 
                        LEFT JOIN keuangan_ledger 
                        ON keuangan_lainnya.no_ledger = keuangan_ledger.no_ledger";
            $search = array('keuangan_lainnya.no_ledger','keuangan_ledger.keterangan','keuangan_lainnya.nama_urusan','keuangan_lainnya.jenis');
            $where  = null;
            if (!empty($this->input->get('a') && $this->input->get('b'))) {
                $a = $this->input->get('a');
                $b = $this->input->get('b');
                $iswhere = ' keuangan_lainnya.no_ledger LIKE "%'.$this->input->get('no_ledger').'%" AND keuangan_lainnya.date BETWEEN "'.$a.'" AND "'.$b.'"';
            } else {
                $iswhere = ' keuangan_lainnya.periode = "'.date('Y-m').'"';
            }
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function excel()
    {
        $query = "SELECT keuangan_ledger.keterangan as ket, keuangan_lainnya.* 
                        FROM keuangan_lainnya 
                        LEFT JOIN keuangan_ledger 
                        ON keuangan_lainnya.no_ledger = keuangan_ledger.no_ledger";
        if (!empty($this->input->get('a') && $this->input->get('b'))) {
            $a = $this->input->get('a');
            $b = $this->input->get('b');
            $iswhere = ' WHERE keuangan_lainnya.no_ledger LIKE "%'.$this->input->get('no_ledger').'%" AND keuangan_lainnya.date BETWEEN "'.$a.'" AND "'.$b.'"';
            $periode = 'PERIODE '.time_explode_date($this->input->get('a'), 'id').' s.d. '.time_explode_date($this->input->get('b'), 'id');
        } else {
            $iswhere = ' WHERE keuangan_lainnya.periode = "'.date('Y-m').'"';
            $periode = 'PERIODE '.bln('id').' '.date('Y');
        }

        $transaksi = $this->db->query($query.$iswhere)->result();

        $this->data = [
            'transaksi' => $transaksi,
            'periode' => $periode,
        ];

        $this->load->view('admin/keuangan/lain/excel', $this->data);
    }

    public function store_lain()
    {
        $this->form_validation->set_rules("no_ledger", "No ledger", "required");
        $this->form_validation->set_rules("nama_urusan", "Nama urusan", "required");
        $this->form_validation->set_rules("jenis", "Jenis", "required");
        if ($this->form_validation->run() != false) {
            if ($this->input->post('jumlah_masuk') != 0) {
                $jumlah_masuk = preg_replace('/[^A-Za-z0-9_]/', '', $this->input->post('jumlah_masuk'));
            } else {
                $jumlah_masuk = 0;
            }
            if ($this->input->post('jumlah_keluar') != 0) {
                $jumlah_keluar = preg_replace('/[^A-Za-z0-9_]/', '', $this->input->post('jumlah_keluar'));
            } else {
                $jumlah_keluar = 0;
            }

            $data = [
                'no_ledger' => htmlspecialchars($this->input->post("no_ledger", true), ENT_QUOTES),
                'nama_urusan' => htmlspecialchars($this->input->post("nama_urusan", true), ENT_QUOTES),
                'jenis' => htmlspecialchars($this->input->post("jenis", true), ENT_QUOTES),
                'jumlah_masuk' => $jumlah_masuk,
                'jumlah_keluar' => $jumlah_keluar,
                'created_at' => date('Y-m-d H:i:s'),
                'date' => date('Y-m-d'),
                'periode' => date('Y-m'),
                'year' => date('Y'),
                'keterangan' => htmlspecialchars($this->input->post("keterangan", true), ENT_QUOTES),
                'user_id' => $this->session->userdata('ses_id'),
            ];

            $this->db->insert("keuangan_lainnya", $data);
            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("keuangan/lain"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! ".validation_errors());
            redirect(base_url("keuangan/lain"));
        }
    }

    public function update_lain()
    {
        $this->form_validation->set_rules("no_ledger", "No ledger", "required");
        $this->form_validation->set_rules("nama_urusan", "Nama urusan", "required");
        $this->form_validation->set_rules("jenis", "Jenis", "required");
        $this->form_validation->set_rules("id", "id", "required");
        if ($this->form_validation->run() != false) {
            $id = (int)$this->input->post('id');
            if ($this->input->post('jumlah_masuk') != 0) {
                $jumlah_masuk = preg_replace('/[^A-Za-z0-9_]/', '', $this->input->post('jumlah_masuk'));
            } else {
                $jumlah_masuk = 0;
            }
            if ($this->input->post('jumlah_keluar') != 0) {
                $jumlah_keluar = preg_replace('/[^A-Za-z0-9_]/', '', $this->input->post('jumlah_keluar'));
            } else {
                $jumlah_keluar = 0;
            }

            $data = [
                'no_ledger' => htmlspecialchars($this->input->post("no_ledger", true), ENT_QUOTES),
                'nama_urusan' => htmlspecialchars($this->input->post("nama_urusan", true), ENT_QUOTES),
                'jenis' => htmlspecialchars($this->input->post("jenis", true), ENT_QUOTES),
                'jumlah_masuk' => $jumlah_masuk,
                'jumlah_keluar' => $jumlah_keluar,
                'date' => date('Y-m-d'),
                'periode' => date('Y-m'),
                'year' => date('Y'),
                'keterangan' => htmlspecialchars($this->input->post("keterangan", true), ENT_QUOTES),
                'user_id' => $this->session->userdata('ses_id'),
            ];

            $this->db->where('id', $id);
            $this->db->update("keuangan_lainnya", $data);
            $this->session->set_flashdata("success", " Berhasil Update Data ! ");
            redirect(base_url("keuangan/edit/".$id));
        } else {
            $this->session->set_flashdata("failed", " Gagal Update Data ! ".validation_errors());
            redirect(base_url("keuangan/edit/".$id));
        }
    }

    public function delete_lain()
    {
        $id = (int)$this->input->get("id");
        $cek = $this->db->get_where("keuangan_lainnya", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $this->db->where("id", $id); // tulis id yang dituju
            $this->db->delete("keuangan_lainnya");
            $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
            redirect(base_url("keuangan/lain"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Delete Data ! ".validation_errors());
            redirect(base_url("keuangan/lain"));
        }
    }
}
