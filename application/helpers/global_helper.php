<?php

function getnama($username) {
    $ci = &get_instance();
    $sql = "SELECT nama_lengkap FROM login WHERE username='$username'";
    $query = $ci->db->query($sql);
    $data = $query->row();
    return $data->nama_lengkap;
}

function getjabatan($username) {
    $ci = &get_instance();
    $sql = "SELECT jabatan FROM login WHERE username='$username'";
    $query = $ci->db->query($sql);
    $data = $query->row();
    return $data && !empty($data->jabatan) ? $data->jabatan : '-';
}

function checkabsensi($username, $tgl, $checkinout) {
    $ci = &get_instance();
    $sql = "SELECT waktu, keterangan FROM absen WHERE username='$username' AND DATE(waktu)='$tgl' AND checkinout='$checkinout'";
    $query = $ci->db->query($sql);
    $data = $query->row();
    return $data->waktu . '|' . $data->keterangan;
}

function rmspace($string) {
	return preg_replace('/\s+/', '', $string);
}

function format_tanggal($waktu)
{
	$tanggal = date('j', strtotime($waktu));
	$bulan_array = array(
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember',
	);
	$bl = date('n', strtotime($waktu));
	$bulan = $bulan_array[$bl];
	$tahun = date('Y', strtotime($waktu));
	return "$tanggal $bulan $tahun";
}

function format_hari_tanggal($waktu)
{
	$hari_array = array(
		'Minggu',
		'Senin',
		'Selasa',
		'Rabu',
		'Kamis',
		'Jumat',
		'Sabtu'
	);
	$hr = date('w', strtotime($waktu));
	$hari = $hari_array[$hr];
	$tanggal = date('j', strtotime($waktu));
	$bulan_array = array(
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember',
	);
	$bl = date('n', strtotime($waktu));
	$bulan = $bulan_array[$bl];
	$tahun = date('Y', strtotime($waktu));
	$jam = date('H:i:s', strtotime($waktu));
	return "$hari, $tanggal $bulan $tahun";
}

function getRomawi($bln) {
	switch ($bln) {
		case 1: return "I"; break;
		case 2: return "II"; break;
		case 3: return "III"; break;
		case 4: return "IV"; break;
		case 5: return "V"; break;
		case 6: return "VI"; break;
		case 7: return "VII"; break;
		case 8: return "VIII"; break;
		case 9: return "IX"; break;
		case 10: return "X"; break;
		case 11: return "XI"; break;
		case 12: return "XII"; break;
	}
}

function time_elapsed_string($datetime, $full = false)
{
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function countDays($a, $b) {
	$start = new DateTime($a);
	$end = new DateTime($b);
	$end->modify('+1 day');
	$interval = $end->diff($start);
	$days = $interval->days;
	$period = new DatePeriod($start, new DateInterval('P1D'), $end);
	$holidays = array('2012-09-07');
	return $days; // 4
}

function countDaysWW($a, $b) {
	$start = new DateTime($a);
	$end = new DateTime($b);
	$end->modify('+1 day');
	$interval = $end->diff($start);
	$days = $interval->days;
	$period = new DatePeriod($start, new DateInterval('P1D'), $end);
	$holidays = array('2012-09-07');
	foreach($period as $dt) {
		$curr = $dt->format('D');
		if ($curr == 'Sat' || $curr == 'Sun') {
			$days--;
		} elseif (in_array($dt->format('Y-m-d'), $holidays)) {
			$days--;
		}
	}
	return $days; // 4
}

if(!function_exists('bulan'))
{
    function bulan($bulan)
    {
    Switch ($bulan){
        case 1 : $bulan="Januari";
            Break;
        case 2 : $bulan="Februari";
            Break;
        case 3 : $bulan="Maret";
            Break;
        case 4 : $bulan="April";
            Break;
        case 5 : $bulan="Mei";
            Break;
        case 6 : $bulan="Juni";
            Break;
        case 7 : $bulan="Juli";
            Break;
        case 8 : $bulan="Agustus";
            Break;
        case 9 : $bulan="September";
            Break;
        case 10 : $bulan="Oktober";
            Break;
        case 11 : $bulan="November";
            Break;
        case 12 : $bulan="Desember";
            Break;
        }
    return $bulan;
    }
}

if(!function_exists('hari'))
{
    function hari($hari)
    {
    Switch ($hari){
        case 1 : $hari="Senin";
            Break;
        case 2 : $hari="Selasa";
            Break;
        case 3 : $hari="Rabu";
            Break;
        case 4 : $hari="Kamis";
            Break;
        case 5 : $hari="Jumat";
            Break;
        case 6 : $hari="Sabtu";
            Break;
        case 7 : $hari="Minggu";
            Break;
        }
    return $hari;
    }
}

function penyebut($nilai)
{
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if ($nilai < 20) {
		$temp = penyebut($nilai - 10) . " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}

function terbilang($nilai)
{
	if ($nilai < 0) {
		$hasil = "minus " . trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}
	return $hasil;
}

if(!function_exists('decimal'))
{
    function decimal($val, $tail=2) 
    {
        return number_format($val, $tail);
    }
}

?>
