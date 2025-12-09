<style>
body {
    font-family: Arial, sans-serif;
    max-width: 700px;
    margin: auto;
    padding: 20px;
    line-height: 1.6;
}

/* Judul */
h2 {
    margin-bottom: 5px;
}

/* Info kecil */
small {
    color: #555;
}

/* Gambar artikel */
.article-img {
    max-width: 300px;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Area komentar */
.comment-box {
    background: #f3f3f3;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 10px;
}

/* Form */
form {
    margin-top: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fafafa;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 8px;
    margin: 5px 0 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

button {
    padding: 8px 16px;
    background: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #3e8f41;
}

/* Tombol hapus artikel */
.delete-btn {
    display: inline-block;
    margin-top: 15px;
    background: #d9534f;
    color: white;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 6px;
}

.delete-btn:hover {
    background: #c9302c;
}

/* Kembali */
.back-link {
    display: inline-block;
    margin-top: 15px;
    text-decoration: none;
}
</style>

<?php
$id = $_GET['id'];
$file = "data/articles/" . $id;

if (!file_exists($file)) die("Artikel tidak ditemukan");

// ====================
// BACA ARTIKEL TXT
// ====================
$fp = fopen($file, "r");
$data = [];

while (($line = fgets($fp)) !== false) {
    if (strpos($line, "CONTENT:") === 0) break;
    list($key, $val) = explode("=", trim($line), 2);
    $data[$key] = $val;
}

// Ambil isi artikel (setelah CONTENT:)
$content = "";
while (($line = fgets($fp)) !== false) {
    $content .= $line;
}
fclose($fp);


$title = htmlspecialchars($data['TITLE']);
$category = htmlspecialchars($data['CATEGORY']);
$content = nl2br(htmlspecialchars($content));

echo "<h2>$title</h2>";
echo "<small>Kategori: $category</small><br>";
echo "<small>".$data['CREATED_AT']."</small><br><br>";

if (!empty($data['IMAGE'])) {
    echo "<img src='data/images/".$data['IMAGE']."' style='max-width:300px;'><br><br>";
}

echo "<p>$content</p>";


// ====================
// BACA KOMENTAR TXT
// ====================
$commentFile = "data/comments/$id";

if (file_exists($commentFile)) {
    $fp2 = fopen($commentFile, "r");

    while (($line = fgets($fp2)) !== false) {
        list($n,$m,$t) = explode("|", trim($line), 3);

        echo "<b>".htmlspecialchars($n)."</b>: ".
             nl2br(htmlspecialchars($m)).
             " <small>($t)</small><br>";
    }

    fclose($fp2);
}
?>

<form method="POST" action="save_comment.php">
    <input type="hidden" name="id" value="<?= $id ?>">
    Nama:<br>
    <input type="text" name="name"><br>
    Komentar:<br>
    <textarea name="message"></textarea><br><br>
    <button type="submit">Kirim</button>
    <a href='index.php' 
style='
    display:inline-block;
    padding:8px 14px;
    background:#2d89ef;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-size:14px;
    margin-bottom:15px;
'
>⟵ Kembali</a>
</form>