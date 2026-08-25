<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Colege Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2 pe-0" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fw-semibold text-white">
                                <?= html_escape($this->session->userdata('name') ?? 'User'); ?>
                            </span>

                            <span class="badge bg-light text-success fw-semibold" style="font-size: 0.75rem;">
                                <?= html_escape(ucfirst($this->session->userdata('role_name')) ?? 'User'); ?>
                            </span>

                            <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center shadow-sm ms-1"
                                style="width: 38px; height: 38px; flex-shrink: 0;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center"
                                    href="<?= site_url('/profile'); ?>">
                                    <i class="bi bi-person-gear text-success me-2 fs-5"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center text-success fw-semibold"
                                    href="<?= site_url('/auth/logout'); ?>">
                                    <i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-md-7">

                <div class="mb-4">

                    <a href="<?= site_url('courses'); ?>" class="text-decoration-none text-success">
                        Back to Courses

                    </a>

                    <h2 class="fw-bold mt-3 mb-1">
                        Add Course
                    </h2>

                    <p class="text-muted">
                        Create a new course.
                    </p>

                </div>


                <?= validation_errors(
                    '<div class="alert alert-danger">',
                    '</div>'
                ); ?>


                <?php if ($this->session->flashdata('error')): ?>

                    <div class="alert alert-danger">

                        <?= html_escape(
                            $this->session->flashdata('error')
                        ); ?>

                    </div>

                <?php endif; ?>


                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <form action="<?= site_url('courses/create'); ?>" method="POST">


                            <div class="mb-3">

                                <label for="department_id" class="form-label fw-semibold">

                                    Department

                                </label>

                                <select id="department_id" name="department_id" class="form-select" required>

                                    <option value="">
                                        Select Department
                                    </option>

                                    <?php if (!empty($departments)): ?>

                                        <?php foreach (
                                            $departments as $department
                                        ): ?>

                                            <option value="<?= html_escape(
                                                $department->id
                                            ); ?>" <?= set_select(
                                                 'department_id',
                                                 $department->id
                                             ); ?>>

                                                <?= html_escape(
                                                    $department->name
                                                ); ?>

                                                (
                                                <?= html_escape(
                                                    $department->code
                                                ); ?>
                                                )

                                            </option>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>

                            </div>

                            <div class="mb-3">

                                <label for="name" class="form-label fw-semibold">

                                    Course Name

                                </label>

                                <input type="text" id="name" name="name" class="form-control" maxlength="50"
                                    value="<?= set_value('name'); ?>" placeholder="e.g. Computer Engineering" required>

                            </div>

                            <div class="mb-3">

                                <label for="code" class="form-label fw-semibold">

                                    Course Code

                                </label>

                                <input type="text" id="code" name="code" class="form-control" maxlength="20"
                                    value="<?= set_value('code'); ?>" placeholder="e.g. CMS26CS1" required>

                            </div>



                            <div class="mb-4">

                                <label for="duration_years" class="form-label fw-semibold">

                                    Duration (Years)

                                </label>

                                <input type="number" id="duration_years" name="duration_years" class="form-control"
                                    min="1" max="255" value="<?= set_value(
                                        'duration_years'
                                    ); ?>" placeholder="e.g. 4" required>

                            </div>


                            <div class="d-flex justify-content-end gap-2">

                                <a href="<?= site_url('courses'); ?>" class="btn btn-outline-success">

                                    Cancel

                                </a>

                                <button type="submit" class="btn btn-success fw-semibold">
                                    Create Course

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>