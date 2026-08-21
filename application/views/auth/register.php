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

<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-book-half me-2"></i>CMS Portal</h4>
                    <small>Create a new account</small>
                </div>
                <div class="card-body p-4">

                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(validation_errors()): ?>
                        <div class="alert alert-success alert-dismissible fade show small" role="alert">
                            <?= validation_errors(); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('/auth/register'); ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control focus-ring focus-ring-success" value="<?= set_value('name'); ?>" placeholder="Enter your full name" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control focus-ring focus-ring-success" value="<?= set_value('email'); ?>" placeholder="Enter your email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Role</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <select name="role_id" class="form-select focus-ring focus-ring-success" required>
                                    <option value="" disabled selected>Select</option>
                                    <?php foreach($roles as $role): ?>
                                        <option value="<?= $role->id; ?>" <?= set_select('role_id', $role->id); ?>>
                                            <?= ucfirst($role->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control focus-ring focus-ring-success" placeholder="Enter your password" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-secondary fw-semibold">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="confirm_password" class="form-control focus-ring focus-ring-success" placeholder="Re-enter your password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            Sign Up 
                        </button>
                    </form>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <span class="small text-muted">Already have an account?</span>
                    <a href="<?= site_url('/auth/login'); ?>" class="text-success fw-semibold small text-decoration-none ms-1">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>