<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
        if (!empty(htmlentities($this->input->get('a',true)))) {
            $a = htmlentities($this->input->get('a',true));
            $b = htmlentities($this->input->get('b',true));
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir');
                $user = $this->db->get_where('login', ['id'=> $ks])->row();
                $iswhere = ' WHERE transaksi.date BETWEEN "'.$a.'" AND "'.$b.'" AND kasir_id = '.$ks.' AND status != "Bayar Nanti"';
                $periode = 'Kasir : '.$user->nama_user.' Periode '.time_explode_date(htmlentities($this->input->get('a',true)), 'id').' s.d. '.time_explode_date(htmlentities($this->input->get('b',true)), 'id');
                $urlexcel = base_url('laporan/excel?kasir='.$ks.'&a='.$a.'&b='.$b);
            } else {
                $iswhere = ' WHERE transaksi.date BETWEEN "'.$a.'" AND "'.$b.'" AND status != "Bayar Nanti"';
                $periode = 'Periode '.time_explode_date(htmlentities($this->input->get('a',true)), 'id').' s.d. '.time_explode_date(htmlentities($this->input->get('b',true)), 'id');
                $urlexcel = base_url('laporan/excel?a='.$a.'&b='.$b);
            }
        } else {
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir');
                $user = $this->db->get_where('login', ['id'=> $ks])->row();
                $iswhere = ' WHERE kasir_id = '.$ks.' AND status != "Bayar Nanti"';
                $periode = 'Kasir : '.$user->nama_user;
                $urlexcel = base_url('laporan/excel?kasir='.$ks);
            } else {
                $iswhere = ' WHERE periode = "'.date('Y-m').'" AND status != "Bayar Nanti"';
                $periode = 'Periode '.bln('id').' '.date('Y');
                $urlexcel = base_url('laporan/excel');
            }
        }

        $total = $this->db->query('SELECT SUM(grandtotal) as gr, SUM(grandmodal) as gm, SUM(total_qty) as qty FROM transaksi'.$iswhere)->row();
        $this->data = [
            'title_web' => 'Laporan',
            'periode' => $periode,
            'total' => $total,
            'urlexcel' => $urlexcel
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/laporan/index', $this->data);
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
            if ($this->session->userdata('ses_level') == 'Admin') {
                $where = null;
            } else {
                $where = array('transaksi.kasir_id' => $this->session->userdata('ses_id'));
            }

        if (!empty(htmlentities($this->input->get('a',true)))) {
            $a = htmlentities($this->input->get('a',true));
            $b = htmlentities($this->input->get('b',true));
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir');
                $iswhere = 'transaksi.date BETWEEN "'.$a.'" AND "'.$b.'" AND kasir_id ="'.$ks.'"';
            } else {
                $iswhere = 'transaksi.date BETWEEN "'.$a.'" AND "'.$b.'"';
            }
        } else {
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir');
                $iswhere = ' kasir_id ="'.$ks.'"';
            } else {
                $iswhere = ' periode = "'.date('Y-m').'"';
            }
        }

        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function excel()
    {
        $query = "SELECT customer.nama, login.nama_user, transaksi.* FROM transaksi 
                LEFT JOIN customer ON transaksi.customer_id = customer.id 
                LEFT JOIN login ON transaksi.kasir_id=login.id";

        if (!empty(htmlentities($this->input->get('a',true)))) {
            $a = htmlentities($this->input->get('a',true));
            $b = htmlentities($this->input->get('b',true));
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir');
                $user = $this->db->get_where('login', ['id'=> $ks])->row();
                $iswhere = ' WHERE transaksi.date BETWEEN "'.$a.'" AND "'.$b.'" AND kasir_id = '.$ks.' AND status != "Bayar Nanti"';
                $periode = 'Kasir : '.$user->nama_user.' Periode '.time_explode_date(htmlentities($this->input->get('a',true)), 'id').' s.d. '.time_explode_date(htmlentities($this->input->get('b',true)), 'id');
            } else {
                $iswhere = ' WHERE transaksi.date BETWEEN "'.$a.'" AND "'.$b.'" AND status != "Bayar Nanti"';
                $periode = 'Periode '.time_explode_date(htmlentities($this->input->get('a',true)), 'id').' s.d. '.time_explode_date(htmlentities($this->input->get('b',true)), 'id');
            }
        } else {
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir');
                $user = $this->db->get_where('login', ['id'=> $ks])->row();
                $iswhere = ' WHERE kasir_id = '.$ks.' AND status != "Bayar Nanti"';
                $periode = 'Kasir : '.$user->nama_user;
            } else {
                $iswhere = ' WHERE periode = "'.date('Y-m').'" AND status != "Bayar Nanti"';
                $periode = 'Periode '.bln('id').' '.date('Y');
            }
        }
        $transaksi = $this->db->query($query.$iswhere)->result();

        $this->data = [
            'transaksi' => $transaksi,
            'periode' => $periode,
        ];

        $this->load->view('admin/laporan/excel', $this->data);
    }

    public function cash()
    {
        if (!empty($this->input->get('m'))) {
            $m = $this->input->get('m');
            $y = $this->input->get('y');
            $iswhere = ' WHERE periode = "'.$y.'-'.$m.'" ';
            $periode = 'Periode '.bulan($m, 'id').' '.$y;
        } else {
            $iswhere = ' WHERE periode = "'.date('Y-m').'" ';
            $periode = 'Periode '.bln('id').' '.date('Y');
        }

        $total = $this->db->query('SELECT SUM(grandtotal) as gr, SUM(grandmodal) as gm, SUM(total_qty) as qty FROM transaksi'.$iswhere.' AND transaksi.status != "Bayar Nanti"')->row();
        $this->data = [
            'title_web' => 'Cash Flow ',
            'periode' => $periode,
            'total' => $total,
            'keuangan' => $this->db->query('SELECT keuangan_ledger.keterangan as ket, keuangan_lainnya.* 
                            FROM keuangan_lainnya 
                            LEFT JOIN keuangan_ledger 
                            ON keuangan_lainnya.no_ledger = keuangan_ledger.no_ledger '.$iswhere)->result()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/laporan/cash', $this->data);
        $this->load->view('layout/footer', $this->data);
    }
    
    public function pdf()
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');
        if (!empty($this->input->get('m'))) {
            $m = $this->input->get('m');
            $y = $this->input->get('y');
            $iswhere = ' WHERE periode = "'.$y.'-'.$m.'"';
            $periode = 'Periode '.bulan($m, 'id').' '.$y;
        } else {
            $iswhere = ' WHERE periode = "'.date('Y-m').'"';
            $periode = 'Periode '.bln('id').' '.date('Y');
        }
        $total = $this->db->query('SELECT SUM(grandtotal) as gr, SUM(grandmodal) as gm, SUM(total_qty) as qty FROM transaksi'.$iswhere.' AND transaksi.status != "Bayar Nanti"')->row();
        // title dari pdf
        $this->data['title_pdf'] = 'Cash Flow '.$periode;
        $this->data['keuangan'] = $this->db->query('SELECT keuangan_ledger.keterangan as ket, keuangan_lainnya.* 
                FROM keuangan_lainnya 
                LEFT JOIN keuangan_ledger 
                ON keuangan_lainnya.no_ledger = keuangan_ledger.no_ledger '.$iswhere)->result();
        $this->data['periode'] = $periode;
        $this->data['total'] = $total;
        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_cash_flow_'.date('Y-m-d');
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
        $html = $this->load->view('admin/laporan/pdf', $this->data, true);
        
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    // laporan perproduk
    public function produk()
    {
        if (!empty($this->input->get('nama',true))) {
            $nama = ' AND nama_menu LIKE "%'.$this->input->get('nama',true).'%"';
        } else {
            $nama = '';
        }
        
        if ($this->session->userdata('ses_level') == 'Admin') {
            $auth = '';
        } else {
            $uid = $this->session->userdata('ses_id');
            $auth = " AND transaksi.kasir_id = $uid";
        }

        if (!empty(htmlentities($this->input->get('a',true)))) {
            $a = htmlentities($this->input->get('a',true));
            $b = htmlentities($this->input->get('b',true));
            $iswhere = 'WHERE transaksi_produk.date BETWEEN "'.$a.'" AND "'.$b.'" '.$nama." ".$auth;
            $periode = 'Periode '.time_explode_date(htmlentities($this->input->get('a',true)), 'id').' s.d. '.time_explode_date(htmlentities($this->input->get('b',true)), 'id');
            $urlexcel = base_url('laporan/produk_excel?a='.$a.'&b='.$b);
        } else {
            $iswhere = ' WHERE transaksi_produk.periode = "'.date('Y-m').'" '.$nama." ".$auth;
            $periode = 'Periode '.bln('id').' '.date('Y');
            $urlexcel = base_url('laporan/produk_excel');
        }

        $total = $this->db->query('SELECT SUM(transaksi_produk.harga_beli * qty) as hb, 
                        SUM(transaksi_produk.harga_jual* qty) as hj, 
                        SUM(transaksi_produk.qty) as qty,
                        transaksi.kasir_id  FROM transaksi_produk 
                        LEFT JOIN transaksi ON transaksi_produk.no_bon=transaksi.no_bon '.$iswhere)->row();
        $this->data = [
            'title_web' => 'Laporan',
            'periode' => $periode,
            'total' => $total,
            'urlexcel' => $urlexcel
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/laporan/produk', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function data_produk()
    {
        if ($this->input->method(true)=='POST'):
            $query = "SELECT customer.nama, login.nama_user, transaksi.atas_nama, 
                transaksi.pesanan,transaksi.status,transaksi.customer_id, 
                transaksi_produk.* FROM transaksi_produk 
                LEFT JOIN transaksi ON transaksi_produk.no_bon=transaksi.no_bon 
                LEFT JOIN customer ON transaksi.customer_id = customer.id 
                LEFT JOIN login ON transaksi.kasir_id=login.id";
            $search = [
                    'kode_menu',
                    'nama',
                    'nama_user',
                    'transaksi_produk.no_bon',
                    'atas_nama',
                    'pesanan',
                    'nama_menu',
                    'kategori',
                ];
            
            if ($this->session->userdata('ses_level') == 'Admin') {
                $where = null;
            } else {
                $where = array('transaksi.kasir_id' => $this->session->userdata('ses_id'));
            }

        if (!empty(htmlentities($this->input->get('a',true)))) {
            $a = htmlentities($this->input->get('a',true));
            $b = htmlentities($this->input->get('b',true));
            $iswhere = 'transaksi_produk.date BETWEEN "'.$a.'" AND "'.$b.'"';
        } else {
            $iswhere = ' transaksi_produk.periode = "'.date('Y-m').'"';
        }

        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function produk_excel()
    {
        $query = "SELECT customer.nama, login.nama_user, transaksi.atas_nama, 
            transaksi.pesanan,transaksi.status,transaksi.customer_id,
            transaksi_produk.* FROM transaksi_produk 
            LEFT JOIN transaksi ON transaksi_produk.no_bon=transaksi.no_bon 
            LEFT JOIN customer ON transaksi.customer_id = customer.id 
            LEFT JOIN login ON transaksi.kasir_id=login.id";
        if (!empty(htmlentities($this->input->get('a',true)))) {
            $a = htmlentities($this->input->get('a',true));
            $b = htmlentities($this->input->get('b',true));
            $iswhere = ' WHERE transaksi_produk.date BETWEEN "'.$a.'" AND "'.$b.'"';
            $periode = 'PERIODE '.time_explode_date(htmlentities($this->input->get('a',true)), 'id').' s.d. '.time_explode_date(htmlentities($this->input->get('b',true)), 'id');
        } else {
            $iswhere = ' WHERE transaksi_produk.periode  = "'.date('Y-m').'"';
            $periode = 'PERIODE '.bln('id').' '.date('Y');
        }

        $transaksi = $this->db->query($query.$iswhere)->result();

        $this->data = [
            'transaksi' => $transaksi,
            'periode' => $periode,
        ];

        $this->load->view('admin/laporan/produk_excel', $this->data);
    }

    public function terlaris()
    {
        if (!empty(htmlentities($this->input->get('a',true)))) {
            $a = htmlentities($this->input->get('a',true));
            $b = htmlentities($this->input->get('b',true));
            $periode = 'Periode '.time_explode_date(htmlentities($this->input->get('a',true)), 'id').' s.d. '.time_explode_date(htmlentities($this->input->get('b',true)), 'id');
            $urlexcel = base_url('laporan/laris_excel?a='.$a.'&b='.$b);
        } else {
            $periode = 'Periode '.bln('id').' '.date('Y');
            $urlexcel = base_url('laporan/laris_excel');
        }
        $this->data = [
            'title_web' => 'Laporan',
            'periode' => $periode,
            'urlexcel' => $urlexcel
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/laporan/laris', $this->data);
        $this->load->view('layout/footer', $this->data);
    }
}
