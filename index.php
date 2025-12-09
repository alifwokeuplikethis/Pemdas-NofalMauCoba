
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
    }

    h2 {
        margin-bottom: 10px;
    }

    form {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    form input[type="text"],
form select {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}


    form button {
        padding: 7px 15px;
        border: none;
        background: #4CAF50;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }

    form button:hover {
        background: #45a049;
    }

    .article-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .thumb {
        width: 90px;
        height: 70px;
        border-radius: 5px;
        object-fit: cover;
        background: #ddd;
    }

    .article-item h3 {
        margin: 0;
    }

    .article-item small {
        color: #666;
    }

    a.add-btn {
        display: inline-block;
        padding: 8px 12px;
        background: #2196F3;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 15px;
    }

    a.add-btn:hover {
        background: #1976D2;
    }
</style>

<?php
$dir = "data/articles/";
$files = array_diff(scandir($dir), ['.','..']);

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

echo "<h2>Daftar Artikel</h2>";

echo '
<form method="GET">
    <input type="text" name="search" value="'.$search.'" placeholder="Search...">
    <select name="category">
        <option value="">Semua Kategori</option>
        <option '.($category=="Teknologi"?"selected":"").'>Teknologi</option>
        <option '.($category=="Pendidikan"?"selected":"").'>Pendidikan</option>
        <option '.($category=="Umum"?"selected":"").'>Umum</option>
    </select>
    <button type="submit">Cari</button>
</form>
';

foreach ($files as $file) {

    $path = $dir.$file;
    $fp = fopen($path, "r");
    $data = [];

    while (($line = fgets($fp)) !== false) {
        if (strpos($line, "CONTENT:") === 0) break;  
        list($key, $val) = explode("=", trim($line), 2);
        $data[$key] = $val;
    }
    fclose($fp);

    // Filter
    if ($search && stripos($data['TITLE'], $search) === false) continue;
    if ($category && $data['CATEGORY'] != $category) continue;

    // Thumbnail
    if (!empty($data['IMAGE'])) {
        echo "<img src='data/images/".$data['IMAGE']."' width='90' height='70' style='object-fit:cover; border-radius:5px;'><br>";
    }

    echo "<h3><a href='view.php?id=$file'>".$data['TITLE']."</a></h3>";
    echo "<small>Kategori: ".$data['CATEGORY']."</small><br><br>";
}

echo "<a href='create.php'>+ Tambah Artikel</a>";

