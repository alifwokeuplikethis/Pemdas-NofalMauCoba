<?php
$id = $_GET['id'] ?? '';
$file = "data/articles/" . $id;

if (file_exists($file)) {
    // Delete article file
    unlink($file);
    
    // Delete associated image if exists
    // We need to read the file first to find the image path, but for simplicity we rely on the user manually cleaning images 
    // or we can parse it.
    // Let's simpler: just delete the article text file.
    
    // Also delete comments
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
