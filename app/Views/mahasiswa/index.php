<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Mahasiswa</h2>

        <a href="<?= base_url('/mahasiswa/create') ?>" class="btn btn-primary">
            + Tambah Mahasiswa
        </a>
    </div>

    <!-- Flash Message -->
    <?php if (!empty($flash)): ?>
    <div
        class="alert alert-<?= e($flash['type'] ?? 'info') ?> alert-dismissible fade show"
        role="alert"
    >
        <?= e($flash['message'] ?? '') ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
<?php endif; ?>

    <!-- Form Pencarian -->
    <form action="<?= base_url('/mahasiswa') ?>" method="GET" class="mb-4">
        <div class="input-group">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari berdasarkan NIM atau Nama..."
                value="<?= e($search ?? '') ?>"
            >

            <button class="btn btn-outline-secondary" type="submit">
                Cari
            </button>

            <?php if (!empty($search)): ?>
                <a
                    href="<?= base_url('/mahasiswa') ?>"
                    class="btn btn-outline-danger"
                >
                    Reset
                </a>
            <?php endif; ?>

        </div>
    </form>

    <div class="table-responsive">

        <table class="table table-bordered table-striped align-middle">

            <thead class="table-dark">
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Program Studi</th>
                    <th>Angkatan</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($mahasiswa)): ?>

                    <?php foreach ($mahasiswa as $row): ?>

                        <tr>

                            <td>
                                <?= e($row['nim'] ?? '-') ?>
                            </td>

                            <td>
                                <?= e($row['nama'] ?? '-') ?>
                            </td>

                            <td>
                                <?= e($row['email'] ?? '-') ?>
                            </td>

                            <td>
                                <?= e($row['prodi_nama'] ?? '-') ?>
                            </td>

                            <td>
                                <?= e($row['angkatan'] ?? '-') ?>
                            </td>

                            <td>

                                <a
                                    href="<?= base_url('/mahasiswa/edit/' . urlencode($row['nim'])) ?>"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    action="<?= base_url('/mahasiswa/delete/' . urlencode($row['nim'])) ?>"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?');"
                                >

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="text-center">
                            Data mahasiswa tidak ditemukan.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>