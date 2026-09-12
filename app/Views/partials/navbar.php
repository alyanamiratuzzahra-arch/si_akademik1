<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/mahasiswa') ?>">SI Akademik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/mahasiswa') ?>">Mahasiswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/prodi') ?>">Program Studi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/matakuliah') ?>">Mata Kuliah</a>
                </li>
            </ul>
            <span class="navbar-text me-3 text-white-50">
                <?= e($_SESSION['user'] ?? '') ?>
            </span>
            <a href="<?= base_url('/logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>
