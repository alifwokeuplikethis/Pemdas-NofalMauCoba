<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca Artikel - Blog Sederhana</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container fade-in" style="max-width: 800px; padding-top: 2rem;">
    
    <div class="mb-4">
        <a href="index.php" class="btn btn-outline">⟵ Kembali ke Daftar</a>
    </div>

    <?php
    $id = $_GET['id'];
    $file = "data/articles/" . $id;

    if (!file_exists($file)) die("<div class='card p-4'>Artikel tidak ditemukan</div>");

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

    // Ambil isi artikel
    $content = "";
    while (($line = fgets($fp)) !== false) {
        $content .= $line;
    }
    fclose($fp);


    $title = htmlspecialchars($data['TITLE']);
    $category = htmlspecialchars($data['CATEGORY']);
    $content = nl2br(htmlspecialchars($content));
    ?>

    <article class="card mb-6">
        <?php if (!empty($data['IMAGE'])): ?>
            <img src="data/images/<?= htmlspecialchars($data['IMAGE']) ?>" class="w-full" style="max-height: 400px; object-fit: cover; border-radius: var(--radius); margin-bottom: 2rem;" alt="<?= $title ?>">
        <?php endif; ?>

        <div class="mb-4">
            <span class="tag mb-2"><?= $category ?></span>
            <h1 class="mb-2"><?= $title ?></h1>
            <div class="text-muted">Ditulis pada: <?= htmlspecialchars($data['CREATED_AT'] ?? '-') ?></div>
        </div>

        <div style="font-size: 1.1rem; line-height: 1.8; color: #334155;">
            <?= $content ?>
        </div>
        
        <div class="mt-8 pt-6 border-t" style="border-top: 1px solid var(--color-border);">
            <a href="delete_article.php?id=<?= $id ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus Artikel</a>
        </div>
    </article>

    <section class="card">
        <h3 class="mb-4">Komentar</h3>

        <div class="mb-6">
            <?php
            // ====================
            // BACA KOMENTAR TXT
            // ====================
            $commentFile = "data/comments/$id";

            if (file_exists($commentFile)) {
                $fp2 = fopen($commentFile, "r");
                $hasComments = false;

                while (($line = fgets($fp2)) !== false) {
                    $hasComments = true;
                    list($n,$m,$t) = explode("|", trim($line), 3);
                    ?>
                    <div class="comment-item">
                        <div class="d-flex justify-between align-center mb-1">
                            <strong><?= htmlspecialchars($n) ?></strong>
                            <small class="text-muted"><?= htmlspecialchars($t) ?></small>
                        </div>
                        <p><?= nl2br(htmlspecialchars($m)) ?></p>
                    </div>
                    <?php
                }
                fclose($fp2);
                
                if (!$hasComments) echo "<p class='text-muted'>Belum ada komentar.</p>";
            } else {
                echo "<p class='text-muted'>Belum ada komentar.</p>";
            }
            ?>
        </div>

        <h4 class="mb-4">Tulis Komentar</h4>
        <form method="POST" action="save_comment.php">
            <input type="hidden" name="id" value="<?= $id ?>">
            
            <div class="form-group grid-2">
                <div class="form-group mb-0">
                    <label>Nama</label>
                    <input type="text" name="name" required placeholder="Nama Anda">
                </div>
            </div>

            <div class="form-group">
                <label>Komentar</label>
                <textarea name="message" rows="4" required placeholder="Tulis komentar..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        </form>
    </section>

</div>

</body>
</html>