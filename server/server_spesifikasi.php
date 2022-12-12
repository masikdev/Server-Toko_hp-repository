<?php
    error_reporting(1);
    include "Database.php";
    $abc = new Database();

    if(isset($_SERVER['HTTP_ORIGIN'])){
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Acess-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }
    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Acess-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']})");
        exit(0);
    }
    $postdata = file_get_contents("php://input");

    function filter($data)
    {
        $data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
        return $data; 
        unset($data);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
        $data = json_decode($postdata);
        $id_spesifikasi = $data->id_spesifikasi;
        $ram_rom = $data->ram_rom;
        $os = $data->os ;
        $baterai = $data->baterai;
        $resolusi = $data->resolusi;
        $kamera = $data->kamera;
        $jaringan = $data->jaringan;
        $aksi = $data->aksi;
        if ($aksi == 'tambah')
        {
            $data2 = array('id_spesifikasi' => $id_spesifikasi, 
                            'ram_rom' => $ram_rom,
                            'os' => $os, 
                            'baterai' => $baterai,
                            'resolusi' => $resolusi,
                            'kamera' => $kamera,
                            'jaringan' => $jaringan,
                        );
        $abc->tambah_spesifikasi($data2); 
        } elseif ($aksi == 'ubah')
        {   $data2 = array('id_spesifikasi' => $id_spesifikasi,
                            'ram_rom' => $ram_rom,
                            'os' => $os, 
                            'baterai' => $baterai,
                            'resolusi' => $resolusi,
                            'kamera' => $kamera,
                            'jaringan' => $jaringan,
                        );
            $abc->ubah_spesifikasi($data2);
        } elseif ($aksi == 'hapus')
        { $abc->hapus_spesifikasi($id_spesifikasi); 
        }

    unset($postdata, $data, $data2, $id_spesifikasi, $ram_rom, $os, $baterai, $resolusi, $kamera, $jaringan, $aksi, $abc);
    }   elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
    {   if (($_GET['aksi'] == 'tampil') and (isset($_GET['id_spesifikasi']))) 
        {
            $id_spesifikasi = filter($_GET['id_spesifikasi']);
            $data = $abc->tampil_spesifikasi($id_spesifikasi);
            echo json_encode($data);
        } else 
        {   $data = $abc->tampil_semua_spesifikasi();
            echo json_encode($data);
        } 
        unset($postdata, $data, $id_spesifikasi, $abc);               
    }    
?>