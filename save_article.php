<?php

// Fungsi untuk alert & kembali
function fail($msg) {
    echo "<script>alert('$msg'); history.back();</script>";
    exit;
}

// ==========================
// SANITASI & VALIDASI INPUT
// ==========================

$title    = filter_var(trim($_POST['title']), FILTER_SANITIZE_SPECIAL_CHARS);
$content  = filter_var(trim($_POST['content']), FILTER_UNSAFE_RAW);
$category = filter_var(trim($_POST['category']), FILTER_SANITIZE_SPECIAL_CHARS);

// Validasi panjang judul
if (strlen($title) < 5) {
    fail("Judul terlalu pendek");
}
if (strlen($title) > 100) {
    fail("Judul terlalu panjang");
}

// Validasi konten
if (strlen($content) < 10) {
    fail("Konten terlalu sedikit");
}

// Validasi kategori
$allowedCategory = ["Teknologi","Pendidikan","Umum"];
if (!in_array($category, $allowedCategory)) {
    fail("Kategori tidak valid");
}


// ==========================
// VALIDASI GAMBAR
// ==========================
$imageName = "";

if (!empty($_FILES['image']['name'])) {

    $allowedExt = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt)) {
        fail("Format gambar tidak didukung");
    }

    $mime = mime_content_type($_FILES['image']['tmp_name']);
    if (!in_array($mime, ['image/jpeg','image/png','image/gif'])) {
        fail("File bukan gambar valid");
    }

    if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
        fail("Ukuran gambar maksimal 2MB");
    }

    $uploadDir = "data/images/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $imageName = time() . "_" . rand(1000,9999) . "." . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$imageName);
}


// ==========================
// SIMPAN ARTIKEL TXT
// ==========================
$articleDir = "data/articles/";
if (!is_dir($articleDir)) mkdir($articleDir, 0777, true);

$id = time() . ".txt";
$path = $articleDir . $id;

$fp = fopen($path, "w");
fwrite($fp, "TITLE=$title\n");
fwrite($fp, "CATEGORY=$category\n");
fwrite($fp, "IMAGE=$imageName\n");
fwrite($fp, "CREATED_AT=" . date("Y-m-d H:i:s") . "\n");
fwrite($fp, "CONTENT:\n");
fwrite($fp, $content);
fclose($fp);

header("Location: index.php");
exit;
?>
