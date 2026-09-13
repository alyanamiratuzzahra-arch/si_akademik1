<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
=======
    <title>Login - Informasi Mahasiswa</title>
>>>>>>> fitur-login
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Login</h3>

                        <?php if (!empty($flash)): ?>
                            <div class="alert alert-<?= e($flash['type']) ?>">
                                <?= e($flash['message']) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('/login') ?>" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required placeholder="Masukkan username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan password">
                                <div class="form-chek mt-2">
                                    <input class="form-check-input" type="checkbox" id="showPassword">
                                    <label class="form-check-label" for="showPassword">Tampilkan Password</label>
                                </div>

                                <script>
                                    document.getElementById("showPassword").addEventListener("change", function() {
                                        const password =
                                    document.getElementById("password");

                                        if(this.checked) {
                                            password.type = "text";
                                        } else {
                                            password.type = "password";
                                        }
                                    })
                                </script>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        <p class="text-muted small mt-3 mb-0 text-center">
                            Demo: <code>admin</code> / <code>admin123</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
