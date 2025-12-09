<style>
    /* Container form */
form {
    max-width: 600px;
    background: #fafafa;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #ddd;
    margin: auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Input teks, select, textarea */
input[type="text"],
select,
textarea,
input[type="file"] {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
    width: 100%;
}

/* Tombol submit */
button {
    width: fit-content;
    padding: 10px 18px;
    background: #4CAF50;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 6px;
}

button:hover {
    background: #3e8e41;
}

/* Judul */
h2 {
    margin-bottom: 5px;
}

</style>
<form action="save_article.php" method="POST" enctype="multipart/form-data" enctype="multipart/form-data">
    <h2>Tulis Artikel</h2>

    Judul:<br>
    <input type="text" name="title" required><br><br>

    Kategori:<br>
    <select name="category">
        <option>Teknologi</option>
        <option>Pendidikan</option>
        <option>Umum</option>
    </select><br><br>

    Gambar Artikel:<br>
    <input type="file" name="image"><br><br>

    Isi Artikel:<br>
    <textarea name="content" rows="8" required></textarea><br><br>

    <button type="submit">Simpan</button>
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
