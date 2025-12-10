<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Artikel - Blog Sederhana</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container fade-in" style="max-width: 800px; padding-top: 2rem;">
    <div class="card">
        <div class="d-flex justify-between align-center mb-6">
            <h2>Tulis Artikel Baru</h2>
            <a href="index.php" class="btn btn-outline">⟵ Kembali</a>
        </div>

        <form action="save_article.php" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Judul Artikel</label>
                <input type="text" name="title" required placeholder="Contoh: Tips Belajar Coding">
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category">
                    <option>Teknologi</option>
                    <option>Pendidikan</option>
                    <option>Umum</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gambar Artikel</label>
                <input type="file" name="image" accept="image/*">
                <small class="text-muted">Format: JPG, PNG, GIF</small>
            </div>

            <div class="form-group">
                <label>Isi Artikel</label>
                <textarea name="content" rows="12" required placeholder="Tuliskan ide menarikmu di sini..."></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Artikel</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
