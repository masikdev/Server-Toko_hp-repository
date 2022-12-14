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
        $id_pelanggan = $data->id_pelanggan;
        $id_hp = $data->id_hp;
        $nik = $data->nik;
        $nama = $data->nama;
        $alamat = $data->alamat;
        $no_hp = $data->no_hp;
        $aksi = $data->aksi;
        if ($aksi == 'tambah')
        {
            $data2 = array('id_pelanggan' => $id_pelanggan, 
                            'id_hp' => $id_hp,
                            'nik' => $nik, 
                            'nama' => $nama,
                            'alamat' => $alamat,
                            'no_hp' => $no_hp,
                        );
        $abc->tambah_pelanggan($data2); 
        } elseif ($aksi == 'ubah')
        {   $data2 = array('id_pelanggan' => $id_pelanggan,
                            'id_hp' => $id_hp,
                            'nik' => $nik, 
                            'nama' => $nama,
                            'alamat' => $alamat,
                            'no_hp' => $no_hp,
                        );
            $abc->ubah_pelanggan($data2);
        } elseif ($aksi == 'hapus')
        { $abc->hapus_pelanggan($id_pelanggan); 
        }

    unset($postdata, $data, $data2, $id_pelanggan, $id_hp, $nik, $nama, $alamat, $no_hp, $aksi, $abc);
    }   elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
    {   if (($_GET['aksi'] == 'tampil') and (isset($_GET['id_pelanggan']))) 
        {
            $id_hp = filter($_GET['id_pelanggan']);
            $data = $abc->tampil_pelanggan($id_pelanggan);
            echo json_encode($data);
        } else 
        {   $data = $abc->tampil_semua_pelanggan();
            echo json_encode($data);
        } 
        unset($postdata, $data, $id_pelanggan, $abc);               
    }
?>