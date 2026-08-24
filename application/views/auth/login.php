<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-success bg-opacity-10">

<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-book-half me-2"></i>CMS Portal</h4>
                    <small>Sign in to your account</small>
                </div>

                <div class="card-body p-4">

                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form id="loginForm" action="<?= site_url('auth/login'); ?>" method="POST">

                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary fw-semibold">
                                Email Address
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control focus-ring focus-ring-success"
                                    placeholder="Enter your email"
                                    autocomplete="email"
                                    required
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-secondary fw-semibold">
                                Password
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    class="form-control focus-ring focus-ring-success outline-success"
                                    autocomplete="current-password"
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            Sign In
                        </button>

                    </form>
                </div>

                <div class="card-footer bg-white text-center py-3">
                    <span class="small text-muted">Don't have an account?</span>

                    <a
                        href="<?= site_url('/auth/register'); ?>"
                        class="text-success fw-semibold small text-decoration-none ms-1"
                    >
                        Register
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('application/assets/js/validation.js'); ?>"></script>
<script src="<?= base_url('application/assets/js/login.js'); ?>"></script>

</body>
</html>