<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container mt-4" style="max-width: 640px;">
    <h2 class="mb-4">Tambah Mahasiswa</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/mahasiswa/store') ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" name="nim" class="form-control" required value="<?= e($old['nim'] ?? '') ?>">
            <small class="text-muted">Angkatan otomatis mengikuti 2 digit pertama NIM (contoh: NIM 22xxxxx → angkatan 2022).</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required value="<?= e($old['nama'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= e($old['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Program Studi</label>
            <select name="prodi_id" class="form-select" required>
                <option value="">-- Pilih Prodi --</option>
                <?php foreach ($prodi as $p): ?>
                    <option value="<?= e($p['id']) ?>" <?= (isset($old['prodi_id']) && (int)$old['prodi_id'] === (int)$p['id']) ? 'selected' : '' ?>>
                        <?= e($p['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('/mahasiswa') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
