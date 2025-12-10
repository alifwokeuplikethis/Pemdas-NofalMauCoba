<?php
$id = $_GET['id'] ?? '';
$file = "data/articles/" . $id;

if (file_exists($file)) {
    unlink($file);

    $commentFile = "data/comments/" . $id;
    if (file_exists($commentFile)) {
        unlink($commentFile);
    }
    
    header("Location: index.php");
} else {
    echo "Artikel tidak ditemukan.";
    echo "<br><a href='index.php'>Kembali</a>";
}
?>
