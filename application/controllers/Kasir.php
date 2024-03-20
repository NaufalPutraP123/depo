<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
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
        $this->load->library('pagination');
        if ($this->session->userdata('masuk_sistem') != true) {
            $url=base_url('login');
            redirect($url);
        }
    }

    public function index()
    {
        $kode = $this->db->query("SELECT * FROM transaksi ORDER BY id DESC LIMIT 1");
        
        if ($kode->num_rows() > 0) {
            $ps = $kode->row();
            $kode_cus = $ps->id + 1;
        } else {
            $kode_cus = 1;
        }

        $this->data = [
            'title_web' => 'Kasir',
            'kat'       => $this->db->get('kategori')->result(),
            'no_bon'	=> 'B00'.$kode_cus,
            'pp'		=> $this->db->get('profil_toko', ['id' => 1])->row(),
            'halperpage'=> 12
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/kasir/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function store()
    {
        $no_bon = $this->input->post('no_bon');
       
        $voucher    = $this->input->post('voucher');
        $grandtotal = $this->input->post('grandtotal');
        $kembali    = $this->input->post('kembaliBayar');
        $dibayar    = $this->input->post('dibayar');

        if (!empty($grandtotal)) {
            $grandtotal = preg_replace('/[^a-zA-Z0-9\']/', '', $grandtotal);
        } else {
            $grandtotal = 0;
        }

        if (!empty($voucher)) {
            $voucher = preg_replace('/[^a-zA-Z0-9\']/', '', $voucher);
        } else {
            $voucher = 0;
        }

        if (!empty($kembali)) {
            $kembali = preg_replace('/[^a-zA-Z0-9\']/', '', $kembali);
        } else {
            $kembali = 0;
        }

        if (!empty($dibayar)) {
            $dibayar = preg_replace('/[^a-zA-Z0-9\']/', '', $dibayar);
        } else {
            $dibayar = 0;
        }

        if (in_array(
            htmlspecialchars($this->input->post("status", true), ENT_QUOTES),
            ['Lunas','Debit BCA','Debit Mandiri','Debit BNI']
        )) {
            if ($dibayar == 0) {
                echo 'Kurang';
                exit;
            } else {
                if ($dibayar < $grandtotal) {
                    echo 'Kurang';
                    exit;
                }
            }
        }

        $hasil_cart = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
        $total_qty = 0;
        $stok = 0;
        $grandmodal = 0;
        foreach ($hasil_cart as $isi) {
            $kode_menu = $isi['kode_menu'];
            $qty = $isi['qty'];
            $total_qty += $qty;
            $row = $this->db->query('select * from menu where id = ?', [$isi['id_menu']])->row();
            $stok = $row->stok - $qty;

            $up_stok[] = array(
                'id' => $isi['id_menu'],
                'stok' => $stok
            );

            $data_jual[] = array(
                'no_bon' => $no_bon,
                'kode_menu' => $kode_menu,
                'nama_menu' => $isi['nama'],
                'kategori'  => $isi['kategori'],
                'qty' => $qty,
                'harga_beli' => $isi['harga_beli'],
                'harga_jual' => $isi['harga_jual'],
                'keterangan' => $isi['keterangan'],
                'created_at' => date('Y-m-d H:i:s'),
                'date' => date('Y-m-d'),
                'periode' => date('Y-m'),
                'year' => date('Y'),
            );
            $grandmodal += $isi['harga_beli'] * $qty;
        }
        // update stok
        $total_array = count($up_stok);
        if ($total_array != 0) {
            $this->db->update_batch('menu', $up_stok, 'id');
        }
        
        // insert penjualan
        $total_array = count($data_jual);
        if ($total_array != 0) {
            $this->db->insert_batch('transaksi_produk', $data_jual);
        }
        // insert transaksi
        $data_trx = array(
            'no_bon' => $no_bon,
            'kasir_id' => $this->session->userdata('ses_id'),
            'customer_id' => htmlspecialchars($this->input->post("customer_id", true), ENT_QUOTES),
            'atas_nama' => htmlspecialchars($this->input->post("atas_nama", true), ENT_QUOTES),
            'pesanan' => htmlspecialchars($this->input->post("pesanan", true), ENT_QUOTES),
            'status' => htmlspecialchars($this->input->post("status", true), ENT_QUOTES),
            'diskon' => htmlspecialchars($this->input->post("diskon", true), ENT_QUOTES),
            'pajak' => htmlspecialchars($this->input->post("pajak", true), ENT_QUOTES),
            'voucher' => $voucher,
            'grandmodal' => $grandmodal,
            'grandtotal' => $grandtotal,
            'total_qty' => $total_qty,
            'dibayar' => $dibayar,
            'created_at' => date('Y-m-d H:i:s'),
            'date' => date('Y-m-d'),
            'periode' => date('Y-m'),
            'year' => date('Y'),
        );
        $this->db->insert('transaksi', $data_trx);

        $this->db->where('login_id', $this->session->userdata('ses_id'));
        $this->db->delete('keranjang');

        echo $no_bon;
    }

    public function show()
    {
        $no_bon = $this->input->get('id');
        $t  = $this->db->query("SELECT customer.nama, customer.hp, transaksi.* FROM 
                transaksi LEFT JOIN customer ON
                transaksi.customer_id=customer.id 
                WHERE transaksi.no_bon = ?", [$no_bon])->row();

        $tp = $this->db->get_where("transaksi_produk", ['no_bon' => $no_bon])->result();
        $this->data = [
            't'  => $t,
            'tp' => $tp,
            'pp' => $this->db->get('profil_toko', ['id' => 1])->row()
        ];

        $this->load->view('admin/kasir/cetak', $this->data);
    }

    public function print()
    {
        $id = $this->input->post('id');
        $os = $this->input->post('os');
        $print = $this->input->post('print');
        $driver = $this->input->post('driver');
        $cetak = $this->input->post('cetak');

        $no_bon = $this->input->get('id');
        $t  = $this->db->query("SELECT customer.nama, transaksi.* FROM 
                transaksi LEFT JOIN customer ON
                transaksi.customer_id=customer.id 
                WHERE transaksi.no_bon = ?", [$no_bon])->row();

        $tp = $this->db->get_where("transaksi_produk", ['no_bon' => $no_bon])->result();
        $this->data = [
            't'  => $t,
            'tp' => $tp,
            'cetak' => $cetak,
            'os' => $os,
            'pp' => $this->db->get('profil_toko', ['id' => 1])->row()
        ];

        $this->load->view('admin/kasir/print', $this->data);
    }

    public function add_cart()
    {
        $id = (int)$this->input->post('id');
        
        $menu = $this->db->query('SELECT kategori.kategori, menu.* FROM menu LEFT JOIN kategori ON menu.id_kategori = kategori.id 
			WHERE menu.id="'.(int)$this->input->post('id').'"')->row();
        $keranjang = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();
        $item = array(
            'id_menu' => $menu->id,
            'kode_menu' => $menu->kode_menu,
            'kategori' => $menu->kategori,
            'nama' => $menu->nama,
            'gambar' => $menu->gambar,
            'harga_beli'  => $menu->harga_pokok,
            'harga_jual'  => $menu->harga_jual,
            'login_id'  => $this->session->userdata('ses_id')
        );
        $stok = $menu->stok - $menu->stok_minim;
        if ($menu->stok_minim >= $menu->stok) {
            echo json_encode(['status' => 'gagal']);
        } else {
            if (!$keranjang) {
                $this->db->set('qty', 1);
                $this->db->insert('keranjang', $item);
                echo json_encode(['status' => 'sukses']);
            } else {
                $qty = $keranjang->qty +1;
                if ($stok >= $qty) {
                    $this->db->set('qty', $keranjang->qty +1);
                    $this->db->where('id_menu', $menu->id);
                    $this->db->where('login_id', $this->session->userdata('ses_id'));
                    $this->db->update('keranjang', $item);
                    echo json_encode(['status' => 'sukses']);
                } else {
                    echo json_encode(['status' => 'gagal']);
                }
            }
        }
    }

    public function cart()
    {
        $sql = "SELECT * FROM keranjang WHERE login_id = ? ORDER BY id ASC";
        $keranjang = $this->db->query($sql, [$this->session->userdata('ses_id')])->result_array();
        if (isset($keranjang)) {
            $this->data['items'] = $keranjang;
            $this->load->view('admin/kasir/keranjang', $this->data);
        } else {
            echo '<center><b class="text-danger">*** Belum ada item yang dipilih ***</b></center>';
        }
    }
    
    public function update_cart()
    {
        $id = (int)$this->input->get('id');
        $menu = $this->db->query('SELECT kategori.kategori, menu.* FROM menu LEFT JOIN kategori ON menu.id_kategori = kategori.id 
            WHERE menu.id="'.(int)$this->input->get('id').'"')->row();
        $keranjang = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();
        $stok = $menu->stok - $menu->stok_minim;
        if ($stok >= (int)$this->input->post('qt')) {
            if (isset($keranjang)) {
                $item = [
                    'id_menu' => $menu->id,
                    'kode_menu' => $menu->kode_menu,
                    'kategori' => $menu->kategori,
                    'nama' => $menu->nama,
                    'gambar' => $menu->gambar,
                    'keterangan' =>  $keranjang->keterangan,
                    'harga_beli'  => $menu->harga_pokok,
                    'harga_jual'  => $menu->harga_jual,
                ];
                if ($this->input->post('type') == 'minus') {
                    $this->db->set('qty', $keranjang->qty - 1);
                } elseif ($this->input->post('type') == 'keyup') {
                    if ($this->input->post('qt') > 0) {
                        $this->db->set('qty', $this->input->post('qt'));
                    } else {
                        $this->db->set('qty', 1);
                    }
                } else {
                    $qty = $keranjang->qty + 1;
                    if ($stok >= $qty) {
                        $this->db->set('qty', $keranjang->qty + 1);
                    } else {
                        echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Gagal !",
                                text: "Stok Product telah mencapai batas minim qty .",
                            })</script>';
                        exit;
                    }
                }
            }

            $this->db->where('id_menu', $menu->id);
            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->update('keranjang', $item);
        } else {
            echo '<script>
            Swal.fire({
                icon: "error",
                title: "Gagal !",
                text: "Stok Product telah mencapai batas minim qty .",
            })</script>';
        }
    }

    public function updateket_cart()
    {
        $id = (int)$this->input->get('id');
        $menu = $this->db->query('SELECT kategori.kategori, menu.* FROM menu LEFT JOIN kategori ON menu.id_kategori = kategori.id 
            WHERE menu.id="'.(int)$this->input->get('id').'"')->row();

        $keranjang = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();
        
        $item = [
            'keterangan' => $this->input->post('qt'),
        ];
        
        $this->db->where('id_menu', $menu->id);
        $this->db->where('login_id', $this->session->userdata('ses_id'));
        $this->db->update('keranjang', $item);
    }

    public function cart_table()
    {
        $keranjang = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
        
        if (isset($keranjang)) {
            $this->data['items'] = $keranjang;
            $this->load->view('admin/kasir/table', $this->data);
        } else {
            echo '<center><b class="text-danger">*** Belum ada item yang dipilih ***</b></center>';
        }
    }


    public function del_cart()
    {
        $id = $this->input->post('id_menu');
        $this->db->where('id_menu', $id);
        $this->db->where('login_id', $this->session->userdata('ses_id'));
        $this->db->delete('keranjang');
        // redirect('jual/tambah');
    }
}
