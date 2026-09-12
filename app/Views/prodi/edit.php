<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container mt-4" style="max-width: 560px;">
    <h2 class="mb-4">Edit Program Studi</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/prodi/update/' . $prodi['id']) ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Program Studi</label>
            <input type="text" name="nama" class="form-control" required value="<?= e($prodi['nama']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('/prodi') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
