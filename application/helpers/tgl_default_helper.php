<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('hari')) {
    function hari($lang)
    {
        if ($lang == 'indonesia') {
            $hari = Date('w');
            switch ($hari) {
                case 1:
                    $hari = "Senin";
                    break;
                case 2:
                    $hari = "Selasa";
                    break;
                case 3:
                    $hari = "Rabu";
                    break;
                case 4:
                    $hari = "Kamis";
                    break;
                case 5:
                    $hari = "Jum'at";
                    break;
                case 6:
                    $hari = "Sabtu";
                    break;
                case 7:
                    $hari = "Minggu";
                    break;
                default:
                    $hari = Date('l');
                    break;
            }
            return $hari;
        }
        if ($lang = 'english') {
            $hari = Date('l');
            return $hari;
        }
    }
}

function bln($lang)
{
    if ($lang == 'id') {
        $bln = date('m');
        if ($bln > 9) {
            $bulan = $bln;
        } else {
            $bln = explode('0', $bln);
            $bulan = $bln[0];
        }
        switch ($bulan) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
            default:
                $bulan = Date('F');
                break;
        }
        return $bulan;
    }
    if ($lang = 'en') {
        $bulan = Date('m');
        return $bulan;
    }
}

function bulan($tgl, $lang)
{
    if ($lang == 'id') {
        $bulan = $tgl;
        switch ($bulan) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
            default:
                $bulan = Date('F');
                break;
        }
        return $bulan;
    }
    if ($lang = 'en') {
        $bulan = Date('m');
        return $bulan;
    }
}

function date_default($lang)
{
    $tgl_default = hari($lang).", ".Date('d') . " " .bln($lang). " ".Date('Y');
    return $tgl_default;
}

function strlen_judul($judul, $leng)
{
    if (strlen($judul) > $leng) {
        return substr($judul, 0, $leng).'...';
    } else {
        return $judul;
    }
}

function time_explode_bulan($tgl, $lang)
{
    $tes = explode(' ', $tgl);
    $tglnow = $tes[0];
    $tgl = explode('-', $tglnow);
    return $tgl[2].' '.bulan($tgl[1], $lang).' '.$tgl[0].' '.$tes[1];
}

function time_explode_date($tglnow, $lang)
{
    $tgl = explode('-', $tglnow);
    return $tgl[2].' '.bulan($tgl[1], $lang).' '.$tgl[0];
}

function time_bulan($tglnow, $lang)
{
    $tgl = explode('-', $tglnow);
    return bulan($tgl[1], $lang).' '.$tgl[0];
}



function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'tahun',
        'm' => 'bulan',
        'w' => 'minggu',
        'd' => 'hari',
        'h' => 'jam',
        'i' => 'menit',
        's' => 'detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }
    return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
}
