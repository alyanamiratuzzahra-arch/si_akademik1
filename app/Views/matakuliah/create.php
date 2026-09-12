<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container mt-4" style="max-width: 560px;">
    <h2 class="mb-4">Tambah Mata Kuliah</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/matakuliah/store') ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control" required value="<?= e($old['kode'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Mata Kuliah</label>
            <input type="text" name="nama_mk" class="form-control" required value="<?= e($old['nama_mk'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">SKS</label>
            <input type="number" name="sks" class="form-control" min="1" max="6" required value="<?= e($old['sks'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('/matakuliah') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
