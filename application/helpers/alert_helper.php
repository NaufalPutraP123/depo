<?php

if (!function_exists('alert_failed')) {
    function alert_failed($html)
    {
        $alert = '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        ' . $html . '
                    </div>';
        return $alert;
    }
}

if (!function_exists('alert_success')) {
    function alert_success($html)
    {
        $alert = '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        ' . $html . '
                    </div>';
        return $alert;
    }
}

function cek_id($table, $col, $val)
{
    $sql = "SELECT * FROM $table WHERE $col = ? ORDER BY id DESC LIMIT 1";
    $ci = &get_instance();
    $cek = $ci->db->query($sql, [$val])->num_rows();
    if ($cek > 0) {
        return time();
    } else {
        return $val;
    }
}
