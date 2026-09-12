<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Mata Kuliah</h2>
        <a href="<?= base_url('/matakuliah/create') ?>" class="btn btn-primary">Tambah Mata Kuliah</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th style="width: 50px;">No</th>
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th style="width: 150px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($matakuliah)): ?>
                <?php $no = 1; foreach ($matakuliah as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['kode']) ?></td>
                        <td><?= e($row['nama_mk']) ?></td>
                        <td><?= e($row['sks']) ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('/matakuliah/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('/matakuliah/delete/' . $row['id']) ?>" method="POST" class="d-inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
