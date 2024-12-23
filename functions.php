<?php
error_reporting(~E_NOTICE & ~E_DEPRECATED);
session_start();

include 'config.php';
include 'includes/ez_sql_core.php';
include 'includes/ez_sql_mysqli.php';
$db = new ezSQL_mysqli($config["username"], $config["password"], $config["database_name"], $config["server"]);

$mod = $_GET["m"] ?? '';
$act = $_GET["act"] ?? '';

function esc_field($str)
{
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
        return $str;
    else
        return addslashes($str);
}

function redirect_js($url)
{
    echo '<script type="text/javascript">window.location.replace("' . $url . '");</script>';
}

function print_msg($msg, $type = 'danger')
{
    echo ('<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $msg . '</div>');
}

function get_data($selected = array())
{
    global $db;
    $rows = $db->get_results("SELECT r.kode_penyakit, r.kode_gejala,  r.nilai  
        FROM bayes_aturan r  
        WHERE r.kode_gejala IN ('" . implode("','", $selected) . "') ORDER BY r.kode_penyakit, r.kode_gejala");
    $data = array();
    foreach ($rows as $row) {
        $data[$row->kode_penyakit][$row->kode_gejala] = $row->nilai;
    }
    return $data;
}

function bayes($data = array(), $bobot = array())
{
    $result = array();
    foreach ($data as $key => $val) {
        $result['kali'][$key] = $bobot[$key]->bobot;
        foreach ($val as $k => $v) {
            $result['kali'][$key] *= $v;
        }
    }

    $result['total'] = array_sum($result['kali']);
    foreach ($result['kali'] as $key => $val) {
        $result['hasil'][$key] = $val / $result['total'];
    }

    return $result;
}

function get_penyakit_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT kode_penyakit, nama_penyakit FROM bayes_penyakit ORDER BY kode_penyakit");
    foreach ($rows as $row) {
        if ($row->kode_penyakit == $selected)
            $a .= "<option value='$row->kode_penyakit' selected>[$row->kode_penyakit] $row->nama_penyakit</option>";
        else
            $a .= "<option value='$row->kode_penyakit'>[$row->kode_penyakit] $row->nama_penyakit</option>";
    }
    return $a;
}

function get_gejala_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT kode_gejala, nama_gejala FROM bayes_gejala ORDER BY kode_gejala");
    foreach ($rows as $row) {
        if ($row->kode_gejala == $selected)
            $a .= "<option value='$row->kode_gejala' selected>[$row->kode_gejala] $row->nama_gejala</option>";
        else
            $a .= "<option value='$row->kode_gejala'>[$row->kode_gejala] $row->nama_gejala</option>";
    }
    return $a;
}

function createSlug($string) {
    // Convert to lowercase
    $slug = strtolower($string);

    // Normalize accented characters to ASCII equivalents
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);

    // Remove special characters (non-alphanumeric characters except hyphen and space)
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

    // Replace spaces with hyphens
    $slug = preg_replace('/\s+/', '-', $slug);

    // Trim hyphens from the beginning and end of the slug
    $slug = trim($slug, '-');

    return $slug;
}
