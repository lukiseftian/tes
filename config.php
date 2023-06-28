<?php

// Buat koneksi
$koneksi = mysqli_connect("localhost", "root", "", "db_sekolah");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Gagal koneksi ke database: " . mysqli_connect_error();
    exit();
}

// URL induk
$main_url = "http://localhost/sekolah/";

function uploadimg($url)
{
    $namafile = $_FILES['image']['name'];
    $ukuran = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmp = $_FILES['image']['tmp_name'];

    // Cek file yang diupload
    $validExtension = ['jpg', 'jpeg', 'png'];
    $fileExtension = explode('.', $namafile);
    $fileExtension = strtolower(end($fileExtension));
    if (!in_array($fileExtension, $validExtension)) {
        header("location: " . $url . '?msg=notimage');
        die();
    }

    // Cek ukuran gambar
    if ($ukuran > 1000000) {
        header("location: " . $url . '?msg=oversize');
        die();
    }

    // Generate nama file gambar
    if ($url == 'profile-sekolah.php') {
        $namafilebaru = rand(0, 50) . '-bgLogin.' . $fileExtension;
    } else {
        $namafilebaru = rand(10, 1000) . '-' . $namafile;
    }
    // Upload gambar
    move_uploaded_file($tmp, "../asset/image/" . $namafilebaru);
    return $namafilebaru;
}

?>
