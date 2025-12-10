<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Sederhana</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container fade-in">
    <header class="main-header d-flex justify-between align-center">
        <div>
            <h1>Blog Sederhana</h1>
            <p class="text-muted">Tempat berbagi cerita dan pengetahuan</p>
        </div>
        <a href='create.php' class="btn btn-primary">+ Tambah Artikel</a>
    </header>

    <?php
    $dir = "data/articles/";
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    
    $files = array_diff(scandir($dir), ['.','..']);
    
    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    ?>

    <section class="mb-6 card">
        <form method="GET" class="d-flex gap-2" style="flex-wrap: wrap;">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari artikel..." style="flex: 1; min-width: 200px;">
            <select name="category" style="width: auto;">
                <option value="">Semua Kategori</option>
                <option <?= $category=="Teknologi"?"selected":"" ?>>Teknologi</option>
                <option <?= $category=="Pendidikan"?"selected":"" ?>>Pendidikan</option>
                <option <?= $category=="Umum"?"selected":"" ?>>Umum</option>
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </section>

    <div class="grid grid-2 grid-3">
        <?php
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
            if ($search && stripos($data['TITLE'] ?? '', $search) === false) continue;
            if ($category && ($data['CATEGORY'] ?? '') != $category) continue;
            ?>

            <article class="card article-card flex-col">
                <?php if (!empty($data['IMAGE'])): ?>
                    <img src="data/images/<?= htmlspecialchars($data['IMAGE']) ?>" alt="<?= htmlspecialchars($data['TITLE']) ?>" loading="lazy">
                <?php else: ?>
                    <div style="width: 100%; height: 200px; background: #e2e8f0; border-radius: var(--radius); margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                        No Image
                    </div>
                <?php endif; ?>

                <div class="article-content">
                    <span class="tag mb-2"><?= htmlspecialchars($data['CATEGORY'] ?? 'Umum') ?></span>
                    <h3 class="mb-2">
                        <a href="view.php?id=<?= $file ?>"><?= htmlspecialchars($data['TITLE'] ?? 'Tanpa Judul') ?></a>
                    </h3>
                    <div class="article-meta">
                        <?= isset($data['CREATED_AT']) ? htmlspecialchars($data['CREATED_AT']) : '' ?>
                    </div>
                </div>
            </article>

        <?php } ?>
    </div>
    
    <?php if (empty($files)): ?>
        <div class="card text-center text-muted" style="text-align: center; padding: 3rem;">
            <p>Belum ada artikel. Jadilah yang pertama menulis!</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
