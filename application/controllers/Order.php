<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
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
        if ($this->session->userdata('masuk_sistem') != true) {
            $url=base_url('login');
            redirect($url);
        }
    }
     
    public function index()
    {
        if (!empty((int)$this->input->get('jenis'))) {
            $jn = (int)$this->input->get('jenis');
            if ($jn == 1) {
                $title = 'Daftar Order ( Ditempat )';
                $date = date('Y-m-d');
            } elseif ($jn == 2) {
                $title = 'Daftar Order ( Booking )';
                $date = date('Y-m-d');
            } elseif ($jn == 3) {
                $title = 'Daftar Order ( Delivery )';
                $date = date('Y-m-d');
            } else {
                $title = 'Daftar Order ( Belum Lunas )';
                $date = "";
            }
        } else {
            $title = 'Daftar Order';
            $date = date('Y-m-d');
        }

        $this->data = [
            'title_web'  => $title,
            'date' => $date
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/order/daftar', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function data_order()
    {
        if ($this->input->method(true)=='POST'):
            $query = "SELECT customer.nama, login.nama_user, transaksi.* FROM transaksi 
                LEFT JOIN customer ON transaksi.customer_id = customer.id 
                LEFT JOIN login ON transaksi.kasir_id=login.id";
            $search = [
                    'nama',
                    'nama_user',
                    'no_bon',
                    'atas_nama',
                    'grandtotal',
                    'date',
                    'status',
                    'pesanan'
                ];
            if (!empty((int)$this->input->get('jenis'))) {
                $jn = (int)$this->input->get('jenis');
                if ($jn == 1) {
                    if (!empty($this->input->get('tgl'))) {
                        $where  = ['pesanan' => 'Ditempat','date' => $this->input->get('tgl')];
                    } else {
                        $where  = ['pesanan' => 'Ditempat','date' => date('Y-m-d')];
                    }
                } elseif ($jn == 2) {
                    if (!empty($this->input->get('tgl'))) {
                        $where  = ['pesanan' => 'Booking','date' => $this->input->get('tgl')];
                    } else {
                        $where  = ['pesanan' => 'Booking','date' => date('Y-m-d')];
                    }
                } elseif ($jn == 3) {
                    if (!empty($this->input->get('tgl'))) {
                        $where  = ['pesanan' => 'Delivery','date' => $this->input->get('tgl')];
                    } else {
                        $where  = ['pesanan' => 'Delivery','date' => date('Y-m-d')];
                    }
                } else {
                    if (!empty($this->input->get('tgl'))) {
                        $where  = ['status' => 'Bayar Nanti','date' => $this->input->get('tgl')];
                    } else {
                        $where  = ['status' => 'Bayar Nanti'];
                    }
                }
            } else {
                if (!empty($this->input->get('tgl'))) {
                    $where  = ['date' => $this->input->get('tgl')];
                } else {
                    $where  = ['date' => date('Y-m-d')];
                }
            }
            
        if ($this->session->userdata('ses_level') == 'Admin') {
            $iswhere = null;
        } else {
            $uid = $this->session->userdata('ses_id');
            $iswhere = " transaksi.kasir_id = '$uid' ";
        }
            
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }
    
    public function edit()
    {
        $id = (int)$this->uri->segment('3');
        $t  = $this->db->query("SELECT customer.nama, customer.hp, login.nama_user, transaksi.* FROM 
                transaksi LEFT JOIN customer ON transaksi.customer_id=customer.id 
                LEFT JOIN login ON transaksi.kasir_id=login.id
                WHERE transaksi.id = ?", [$id])->row();

        if (!isset($t)) {
            $this->session->set_flashdata("failed", "Data Tidak Tersedia ! ");
            redirect(base_url("order"));
        }
        
        $tp = $this->db->get_where("transaksi_produk", ['no_bon' => $t->no_bon])->result_array();
        $tp1 = $this->db->get_where("transaksi_produk", ['no_bon' => $t->no_bon])->result();
        $this->data = [
            'title_web'  => 'Edit Order',
            't'  => $t,
            'tp' => $tp,
            'tp1' => $tp1,
            'kat' => $this->db->get('kategori')->result(),
            'pp' => $this->db->get('profil_toko', ['id' => 1])->row()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/order/edit', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function updated()
    {
        $no_bon = $this->input->post('no_bon');
        $id = $this->input->post('idtrx');
       
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

        $hasil_cart = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
        if (isset($hasil_cart)) {
            $total_qty = 0;
            $stok = 0;
            $grmo = 0;
            foreach ($hasil_cart as $isi) {
                $kode_menu = $isi['kode_menu'];
                $qty = $isi['qty'];
                $total_qty += $qty;
                $grmo  += $isi['harga_beli'] * $qty;
                
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
            $trxs = $this->db->get_where('transaksi', ['id' =>(int)$id])->row();
            $ttl_qty = $total_qty + $trxs->total_qty;
            $grm = $grmo + $trxs->grandmodal;
            // update transaksi
            $data_trx = array(
                'pesanan' => htmlspecialchars($this->input->post("pesanan", true), ENT_QUOTES),
                'status' => htmlspecialchars($this->input->post("status", true), ENT_QUOTES),
                'diskon' => htmlspecialchars($this->input->post("diskon", true), ENT_QUOTES),
                'pajak' => htmlspecialchars($this->input->post("pajak", true), ENT_QUOTES),
                'voucher' => $voucher,
                'grandmodal' => $grm,
                'grandtotal' => $grandtotal,
                'total_qty' => $ttl_qty,
                'dibayar' => $dibayar,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', (int)$id);
            $this->db->update('transaksi', $data_trx);

            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->delete('keranjang');
            
            if (in_array(
                htmlspecialchars($this->input->post("status", true), ENT_QUOTES),
                ['Lunas','Debit BCA','Debit Mandiri','Debit BNI']
            )) {
                if ($dibayar == 0) {
                    // update transaksi
                    $data_trx = array(
                        'status' => 'Bayar Nanti',
                    );
                    $this->db->where('id', (int)$id);
                    $this->db->update('transaksi', $data_trx);

                    $this->session->set_flashdata("failed", " Gagal Update Status Orderan Lunas, Masukkan Angka Pembayaran Dahulu ! ");
                    redirect(base_url("order/edit/".(int)$id));
                    exit;
                }

                if ($dibayar < $grandtotal) {
                    $data_trx = array(
                        'status' => 'Bayar Nanti',
                    );
                    $this->db->where('id', (int)$id);
                    $this->db->update('transaksi', $data_trx);

                    $this->session->set_flashdata("failed", " Gagal Update Status Orderan Lunas, Angka Pembayaran Kurang dari total order ! ");
                    redirect(base_url("order/edit/".(int)$id));
                    exit;
                }
                
                $this->session->set_flashdata("success", " Berhasil Update Orderan ! ");
                redirect(base_url("order/edit/".(int)$id));
            } else {
                $this->session->set_flashdata("success", " Berhasil Update Orderan ! ");
                redirect(base_url("order/edit/".(int)$id));
            }
        } else {

            // update transaksi
            $data_trx = array(
                'pesanan' => htmlspecialchars($this->input->post("pesanan", true), ENT_QUOTES),
                'status' => htmlspecialchars($this->input->post("status", true), ENT_QUOTES),
                'diskon' => htmlspecialchars($this->input->post("diskon", true), ENT_QUOTES),
                'pajak' => htmlspecialchars($this->input->post("pajak", true), ENT_QUOTES),
                'voucher' => $voucher,
                'grandtotal' => $grandtotal,
                'dibayar' => $dibayar,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', (int)$id);
            $this->db->update('transaksi', $data_trx);

            if (in_array(
                htmlspecialchars($this->input->post("status", true), ENT_QUOTES),
                ['Lunas','Debit BCA','Debit Mandiri','Debit BNI']
            )) {
                if ($dibayar == 0) {
                    // update transaksi
                    $data_trx = array(
                        'status' => 'Bayar Nanti',
                    );
                    $this->db->where('id', (int)$id);
                    $this->db->update('transaksi', $data_trx);

                    $this->session->set_flashdata("failed", " Gagal Update Status Orderan Lunas, Masukkan Angka Pembayaran Dahulu ! ");
                    redirect(base_url("order/edit/".(int)$id));
                    exit;
                }

                if ($dibayar < $grandtotal) {
                    $data_trx = array(
                        'status' => 'Bayar Nanti',
                    );
                    $this->db->where('id', (int)$id);
                    $this->db->update('transaksi', $data_trx);

                    $this->session->set_flashdata("failed", " Gagal Update Status Orderan Lunas, Angka Pembayaran Kurang dari total order ! ");
                    redirect(base_url("order/edit/".(int)$id));
                    exit;
                }
                $this->session->set_flashdata("success", " Berhasil Update Orderan ! ");
                redirect(base_url("order/edit/".(int)$id));
            } else {
                $this->session->set_flashdata("success", " Berhasil Update Orderan ! ");
                redirect(base_url("order/edit/".(int)$id));
            }
        }
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
        if (!$keranjang) {
            $this->db->set('qty', 1);
            $this->db->insert('keranjang', $item);
        } else {
            $this->db->set('qty', $keranjang->qty +1);
            $this->db->where('id_menu', $menu->id);
            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->update('keranjang', $item);
        }
    }

    public function cart()
    {
        $keranjang = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
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
        if ($menu->stok > (int)$this->input->post('qt')) {
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
                        if ($this->input->post('qt') < $menu->stok) {
                            $this->db->set('qty', $this->input->post('qt'));
                        } else {
                            $this->db->set('qty', 1);

                            echo '<script>
                                    alert("Gagal !, Stok Product telah mencapai batas minim qty .");
                                </script>';
                        }
                    } else {
                        $this->db->set('qty', 1);
                    }
                } else {
                    $this->db->set('qty', $keranjang->qty + 1);
                }
            }

            $this->db->where('id_menu', $menu->id);
            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->update('keranjang', $item);
        } else {
            echo '<script>alert("Gagal !, Stok Product telah mencapai batas minim qty .");</script>';
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
        $id = (int)$this->input->get('id');
        $t  = $this->db->query("SELECT customer.nama, login.nama_user, transaksi.* FROM 
                transaksi LEFT JOIN customer ON transaksi.customer_id=customer.id 
                LEFT JOIN login ON transaksi.kasir_id=login.id
                WHERE transaksi.id = ?", [$id])->row();

        $this->data['t'] = $t;
        if (isset($keranjang)) {
            $this->data['items'] = $keranjang;
            $this->load->view('admin/order/table', $this->data);
        } else {
            $this->data['items'] = [];
            $this->load->view('admin/order/table', $this->data);
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

    public function hapus($id)
    {
        $cek = $this->db->get_where('transaksi', ['id' => $id])->row();
        $upd = $this->db->get_where('transaksi_produk', ['no_bon' => $cek->no_bon])->result();
        foreach ($upd as $r) {
            $this->db->query("UPDATE menu SET stok=stok+$r->qty WHERE kode_menu = '$r->kode_menu'");
        }
        $this->db->query("DELETE FROM transaksi WHERE id = $id");
        $this->db->query("DELETE FROM transaksi_produk WHERE no_bon = '$cek->no_bon'");

        $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
        redirect(base_url("laporan"));
    }

    // hapus item order
    public function hapus_item()
    {
        $id = (int)$this->input->get('id');
        $order_id = (int)$this->input->get('order_id');
        // getwhere transaksi_produk
        $edit = $this->db->get_where('transaksi_produk', ['id' => $id])->row();
        // edit qty produk
        $this->db->query("UPDATE menu SET stok=stok+$edit->qty WHERE kode_menu = ?",[$edit->kode_menu]);
        // edit qty transaksi 
        $this->db->query("UPDATE transaksi SET total_qty=total_qty-$edit->qty, 
                         grandmodal = grandmodal-".($edit->harga_beli * $edit->qty).",
                         grandtotal = grandtotal - ".($edit->harga_jual * $edit->qty).",
                         dibayar = dibayar - ".($edit->harga_jual * $edit->qty)." WHERE id = ?",[$order_id]);

        // delete transaksi_produk
        $this->db->where('id', $id);
        $this->db->delete('transaksi_produk');
        $this->session->set_flashdata("success", " Berhasil Hapus Orderan ! ");
        redirect(base_url("order/edit/".$order_id));
    }
}
