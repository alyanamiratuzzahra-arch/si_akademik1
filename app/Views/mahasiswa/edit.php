<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container mt-4" style="max-width: 640px;">

    <h2 class="mb-4">Edit Mahasiswa</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <form
        action="<?= base_url('/mahasiswa/update/' . urlencode($mahasiswa['nim'])) ?>"
        method="POST"
    >

        <!-- NIM -->
        <div class="mb-3">
            <label class="form-label">NIM</label>

            <input
                type="text"
                class="form-control"
                value="<?= e($mahasiswa['nim'] ?? '') ?>"
                disabled
            >
        </div>

        <!-- Nama -->
        <div class="mb-3">
            <label class="form-label">Nama</label>

            <input
                type="text"
                name="nama"
                class="form-control"
                required
                value="<?= e($mahasiswa['nama'] ?? '') ?>"
            >
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                required
                value="<?= e($mahasiswa['email'] ?? '') ?>"
            >
        </div>

        <!-- Program Studi -->
        <div class="mb-3">
            <label class="form-label">Program Studi</label>

            <select
                name="prodi_id"
                class="form-select"
                required
            >

                <option value="">-- Pilih Prodi --</option>

                <?php foreach ($prodi as $p): ?>

                    <option
                        value="<?= e($p['id']) ?>"
                        <?= ((int)($mahasiswa['prodi_id'] ?? 0) === (int)$p['id']) ? 'selected' : '' ?>
                    >
                        <?= e($p['nama']) ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </div>

        <!-- Angkatan -->
        <div class="mb-3">
            <label class="form-label">Angkatan</label>

            <input
                type="text"
                class="form-control"
                value="<?= e($mahasiswa['angkatan'] ?? '') ?>"
                disabled
            >

            <small class="text-muted">
                Otomatis mengikuti NIM, tidak bisa diubah manual.
            </small>
        </div>

        <!-- Tombol -->
        <button type="submit" class="btn btn-primary">
            Update
        </button>

        <a
            href="<?= base_url('/mahasiswa') ?>"
            class="btn btn-secondary"
        >
            Batal
        </a>

    </form>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>