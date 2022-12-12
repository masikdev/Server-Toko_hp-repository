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
        $id_hp = $data->id_hp;
        $id_spesifikasi = $data->id_spesifikasi;
        $namahp = $data->namahp;
        $merek = $data->merek;
        $harga = $data->harga;
        $aksi = $data->aksi;
        if ($aksi == 'tambah')
        {
            $data2 = array('id_hp' => $id_hp, 
                            'id_spesifikasi' => $id_spesifikasi,
                            'namahp' => $namahp, 
                            'merek' => $merek,
                            'harga' => $harga,
                        );
        $abc->tambah_hp($data2); 
        } elseif ($aksi == 'ubah')
        {   $data2 = array('id_hp' => $id_hp,
                            'id_spesifikasi' => $id_spesifikasi,
                            'namahp' => $namahp, 
                            'merek' => $merek,
                            'harga' => $harga,
                        );
            $abc->ubah_hp($data2);
        } elseif ($aksi == 'hapus')
        { $abc->hapus_hp($id_hp); 
        }

    unset($postdata, $data, $data2, $id_hp, $id_spesifikasi, $namahp, $merek, $harga, $aksi, $abc);
    }   elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
    {   if (($_GET['aksi'] == 'tampil') and (isset($_GET['id_hp']))) 
        {
            $id_hp = filter($_GET['id_hp']);
            $data = $abc->tampil_hp($id_hp);
            echo json_encode($data);
        } else 
        {   $data = $abc->tampil_semua_hp();
            echo json_encode($data);
        } 
        unset($postdata, $data, $id_hp, $abc);               
    }    
?>