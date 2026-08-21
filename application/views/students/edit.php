<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - College Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('/dashboard'); ?>">
                <i class="bi bi-book-half fs-3 me-2"></i> CMS Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="dashNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2 pe-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fw-semibold text-white">
                                <?= html_escape($this->session->userdata('name') ?? 'User'); ?>
                            </span>
                            <span class="badge bg-light text-success fw-semibold" style="font-size: 0.75rem;">
                                <?= html_escape($this->session->userdata('role_name') ?? 'User'); ?>
                            </span>
                            <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center shadow-sm ms-1" style="width: 38px; height: 38px; flex-shrink: 0;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="<?= site_url('/profile'); ?>">
                                    <i class="bi bi-person-gear text-success me-2 fs-5"></i>
                                    My Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center text-success fw-semibold" href="<?= site_url('/auth/logout'); ?>">
                                    <i class="bi bi-box-arrow-right me-2 fs-5"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-pencil-square text-success me-2"></i>
                Edit Student
            </h3>
            <a href="<?= site_url('students'); ?>" class="btn btn-outline-success fw-semibold">
                Go Back
            </a>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= html_escape($this->session->flashdata('success')); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= html_escape($this->session->flashdata('error')); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= site_url('students/update_student/' . $student->id); ?>" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Student Name</label>
                            <input type="text" id="name" name="name" class="form-control focus-ring focus-ring-success" value="<?= html_escape($student->name); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="student_code" class="form-label fw-semibold">Student Code</label>
                            <input type="text" id="student_code" name="student_code" class="form-control focus-ring focus-ring-success" value="<?= html_escape($student->student_code); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" id="email" name="email" class="form-control focus-ring focus-ring-success" value="<?= html_escape($student->email); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control focus-ring focus-ring-success" value="<?= html_escape($student->phone); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="course_id" class="form-label fw-semibold">Course</label>
                            <select id="course_id" name="course_id" class="form-select focus-ring focus-ring-success" required>
                                <option value="">Select Course</option>
                                <?php if (!empty($courses)): ?>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= $course->id; ?>" <?= ($student->course_id == $course->id) ? 'selected' : ''; ?>>
                                            <?= html_escape($course->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="gender" class="form-label fw-semibold">Gender</label>
                            <select id="gender" name="gender" class="form-select focus-ring focus-ring-success" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= ($student->gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?= ($student->gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?= ($student->gender === 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="dob" class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control focus-ring focus-ring-success" value="<?= html_escape($student->dob); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="admission_date" class="form-label fw-semibold">Admission Date</label>
                            <input type="date" id="admission_date" name="admission_date" class="form-control focus-ring focus-ring-success" value="<?= html_escape($student->admission_date); ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= site_url('students'); ?>" class="btn btn-outline-secondary fw-semibold">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-check-circle me-1"></i>
                            Update Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>