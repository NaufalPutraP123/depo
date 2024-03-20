<?php if (! defined('BASEPATH')) {
    exit('No direct script acess allowed');
}

class M_Admin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
    }

    public function get_table($table_name)
    {
        $get_user = $this->db->get($table_name);
        return $get_user->result_array();
    }

    public function rp($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }


    public function get_tableid($table_name, $where, $id)
    {
        $this->db->where($where, $id);
        $edit = $this->db->get($table_name);
        return $edit->result_array();
    }

    public function get_tableid_edit($table_name, $where, $id)
    {
        $this->db->where($where, $id);
        $edit = $this->db->get($table_name);
        return $edit->row();
    }

    public function add_multiple($table, $data = array())
    {
        $total_array = count($data);

        if ($total_array != 0) {
            $this->db->insert_batch($table, $data);
        }
    }

    public function insertTable($table_name, $data)
    {
        $tambah = $this->db->insert($table_name, $data);
        return $tambah;
    }

    public function LastinsertId($table_name, $data)
    {
        $this->db->insert($table_name, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update_table($table_name, $where, $id, $data)
    {
        $this->db->where($where, $id);
        $update = $this->db->update($table_name, $data);
        return $update;
    }

    public function delete_table($table_name, $where, $id)
    {
        $this->db->where($where, $id);
        $hapus = $this->db->delete($table_name);
        return $hapus;
    }

    public function delete_table_multiple($table_name, $where, $id)
    {
        if (!empty($id)) {
            $this->db->where_in($where, $id);
            $hapus = $this->db->delete($table_name);
            return $hapus;
        }
    }

    public function edit_table($table_name, $where, $id)
    {
        $this->db->where($where, $id);
        $edit = $this->db->get($table_name);
        return $edit->row();
    }

    public function CountTable($table_name)
    {
        $Count = $this->db->get($table_name);
        return $Count->num_rows();
    }

    public function CountTableId($table_name, $where, $id)
    {
        $this->db->where($where, $id);
        $Count = $this->db->get($table_name);
        return $Count->num_rows();
    }

    public function SelectTable($table_name, $query, $id, $orderby)
    {
        $this->db->select($query, false); // select('RIGHT(user.id_odojers,4) as kode', FALSE);
        $this->db->order_by($id, $orderby);
        $query = $this->db->get($table_name); // cek dulu apakah ada sudah ada kode di tabel.
        return $query;
    }

    public function SelectTableSQL($query)
    {
        $row = $this->db->query($query);
        return $row;
    }

    public function get_user($user)
    {
        $this->db->where('id_login', $user);
        $get_user = $this->db->get('tbl_login');
        return $get_user->row();
    }

    public function buat_kode($table_name, $kodeawal, $idkode, $orderbylimit)
    {
        $query = $this->db->query("select * from $table_name $orderbylimit"); // cek dulu apakah ada sudah ada kode di tabel.
      
        if ($query->num_rows() > 0) {
            //jika kode ternyata sudah ada.
            $hasil = $query->row();
            $kd = $hasil->$idkode;
            $cd = substr($kd, 6);
            $nomor = $query->num_rows();
            $kode = $cd + 1;
            $kodejadi = $kodeawal."00".$kode;    // hasilnya CUS-0001 dst.
            $kdj = $kodejadi;
        } else {
            //jika kode belum ada
            $kode = 0+1;
            $kodejadi = $kodeawal."00".$kode;    // hasilnya CUS-0001 dst.
            $kdj = $kodejadi;
        }
        return $kdj;
    }

    public function buat_kode_join($table_name, $kodeawal, $idkode)
    {
        $query = $this->db->query($table_name); // cek dulu apakah ada sudah ada kode di tabel.
        if ($query->num_rows() > 0) {
            //jika kode ternyata sudah ada.
            $hasil = $query->row();
            $kd = $hasil->$idkode;
            $cd = substr($kd, 6);
            $kode = $cd + 1;
            $kodejadi = $kodeawal."00".$kode;    // hasilnya CUS-0001 dst.
            $kdj = $kodejadi;
        } else {
            //jika kode belum ada
            $kode = 0+1;
            $kodejadi = $kodeawal."00".$kode;    // hasilnya CUS-0001 dst.
            $kdj = $kodejadi;
        }
        return $kdj;
    }

    public function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } elseif ($nilai <20) {
            $temp = $this->M_Admin->penyebut($nilai - 10). " belas";
        } elseif ($nilai < 100) {
            $temp = $this->M_Admin->penyebut($nilai/10)." puluh". $this->M_Admin->penyebut($nilai % 10);
        } elseif ($nilai < 200) {
            $temp = " seratus" . $this->M_Admin->penyebut($nilai - 100);
        } elseif ($nilai < 1000) {
            $temp = $this->M_Admin->penyebut($nilai/100) . " ratus" . $this->M_Admin->penyebut($nilai % 100);
        } elseif ($nilai < 2000) {
            $temp = " seribu" . $this->M_Admin->penyebut($nilai - 1000);
        } elseif ($nilai < 1000000) {
            $temp = $this->M_Admin->penyebut($nilai/1000) . " ribu" . $this->M_Admin->penyebut($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            $temp = $this->M_Admin->penyebut($nilai/1000000) . " juta" . $this->M_Admin->penyebut($nilai % 1000000);
        } elseif ($nilai < 1000000000000) {
            $temp = $this->M_Admin->penyebut($nilai/1000000000) . " milyar" . $this->M_Admin->penyebut(fmod($nilai, 1000000000));
        } elseif ($nilai < 1000000000000000) {
            $temp = $this->M_Admin->penyebut($nilai/1000000000000) . " trilyun" . $this->M_Admin->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    public function terbilang($nilai)
    {
        if ($nilai<0) {
            $hasil = "minus ". trim($this->M_Admin->penyebut($nilai));
        } else {
            $hasil = trim($this->M_Admin->penyebut($nilai));
        }
        return $hasil;
    }
}
