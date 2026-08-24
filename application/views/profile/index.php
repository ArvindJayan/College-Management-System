<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>College Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>


<body class="bg-light">


    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm sticky-top">

        <div class="container">

            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('/dashboard'); ?>">

                <i class="bi bi-book-half fs-3 me-2"></i>

                CMS Portal

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

                                <?= html_escape(
                                    $this->session->userdata('name') ?? 'User'
                                ); ?>

                            </span>


                            <span class="badge bg-light text-success fw-semibold" style="font-size: 0.75rem;">

                                <?= html_escape(
                                    ucfirst($this->session->userdata('role_name') ?? 'User')
                                ); ?>

                            </span>


                            <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center shadow-sm ms-1"
                                style="width: 38px; height: 38px; flex-shrink: 0;">

                                <i class="bi bi-person-fill fs-5">
                                </i>

                            </div>

                        </a>


                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">

                            <li>

                                <a class="dropdown-item py-2 d-flex align-items-center"
                                    href="<?= site_url('/profile'); ?>">

                                    <i class="bi bi-person-gear text-success me-2 fs-5">
                                    </i>

                                    My Profile

                                </a>

                            </li>


                            <li>

                                <hr class="dropdown-divider my-1">

                            </li>


                            <li>

                                <a class="dropdown-item py-2 d-flex align-items-center text-success fw-semibold"
                                    href="<?= site_url('/auth/logout'); ?>">

                                    <i class="bi bi-box-arrow-right me-2 fs-5">
                                    </i>

                                    Logout

                                </a>

                            </li>

                        </ul>

                    </li>

                </ul>

            </div>

        </div>

    </nav>


    <div class="container py-5">


        <!-- Page Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    My Profile
                </h2>

                <p class="text-muted mb-0">
                    View your account and personal information.
                </p>

            </div>


            <div class="d-flex gap-2">

                <a href="<?= site_url('/dashboard'); ?>" class="btn btn-outline-success fw-semibold">

                    Back to Dashboard

                </a>


                <a href="<?= site_url('/profile/edit'); ?>" class="btn btn-success fw-semibold">

                    Edit Profile

                </a>

            </div>

        </div>


        <!-- Success Message -->

        <?php if (
            $this->session->flashdata('success')
        ): ?>

            <div class="alert alert-success alert-dismissible fade show">

                <i class="bi bi-check-circle me-2"></i>

                <?= html_escape(
                    $this->session->flashdata('success')
                ); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>


        <!-- Error Message -->

        <?php if (
            $this->session->flashdata('error')
        ): ?>

            <div class="alert alert-danger alert-dismissible fade show">

                <i class="bi bi-exclamation-circle me-2"></i>

                <?= html_escape(
                    $this->session->flashdata('error')
                ); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>


        <!-- Account Information -->

        <div class="card border-0 shadow-sm rounded-3 mb-4">

            <div class="card-header bg-white border-0 p-4">

                <h5 class="fw-bold mb-0">

                    <i class="bi bi-person-circle text-success me-2">
                    </i>

                    Account Information

                </h5>

            </div>


            <div class="card-body px-4 pb-4">

                <div class="row g-4">


                    <div class="col-md-6">

                        <label class="form-label text-muted small fw-semibold">

                            Full Name

                        </label>

                        <div class="fw-semibold">

                            <?= html_escape(
                                $user->name
                            ); ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label text-muted small fw-semibold">

                            Email Address

                        </label>

                        <div class="fw-semibold">

                            <?= html_escape(
                                $user->email
                            ); ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label text-muted small fw-semibold">

                            Role

                        </label>

                        <div>

                            <span class="badge bg-success-subtle text-success border border-success-subtle">

                                <?= html_escape(
                                    ucfirst($user->role_name)
                                ); ?>

                            </span>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label text-muted small fw-semibold">

                            Account Status

                        </label>

                        <div>

                            <?php if (
                                $user->status === 'active'
                            ): ?>

                                <span class="badge bg-success-subtle text-success border border-success-subtle">

                                    Active

                                </span>

                            <?php else: ?>

                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">

                                    Inactive

                                </span>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label text-muted small fw-semibold">

                            Account Created

                        </label>

                        <div>

                            <?= html_escape(
                                date(
                                    'd M Y',
                                    strtotime($user->created_at)
                                )
                            ); ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label text-muted small fw-semibold">

                            Last Updated

                        </label>

                        <div>

                            <?= html_escape(
                                date(
                                    'd M Y',
                                    strtotime($user->updated_at)
                                )
                            ); ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Student Information -->

        <?php if ($user->student): ?>

            <div class="card border-0 shadow-sm rounded-3 mb-4">

                <div class="card-header bg-white border-0 p-4">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-mortarboard text-success me-2">
                        </i>

                        Student Information

                    </h5>

                </div>


                <div class="card-body px-4 pb-4">

                    <div class="row g-4">


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Student Code

                            </label>

                            <div class="fw-semibold">

                                <?= html_escape(
                                    $user->student->student_code
                                ); ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Phone

                            </label>

                            <div>

                                <?= !empty(
                                    $user->student->phone
                                )
                                    ? html_escape(
                                        $user->student->phone
                                    )
                                    : 'Not provided';
                                ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Date of Birth

                            </label>

                            <div>

                                <?= !empty(
                                    $user->student->dob
                                )
                                    ? html_escape(
                                        date(
                                            'd M Y',
                                            strtotime(
                                                $user->student->dob
                                            )
                                        )
                                    )
                                    : 'Not provided';
                                ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Gender

                            </label>

                            <div>

                                <?= !empty(
                                    $user->student->gender
                                )
                                    ? html_escape(
                                        ucfirst(
                                            $user->student->gender
                                        )
                                    )
                                    : 'Not provided';
                                ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Course

                            </label>

                            <div class="fw-semibold">

                                <?= !empty(
                                    $user->student->course_name
                                )
                                    ? html_escape(
                                        $user->student->course_name
                                    )
                                    : 'Not assigned';
                                ?>

                            </div>

                            <?php if (
                                !empty(
                                $user->student->course_code
                            )
                            ): ?>

                                <small class="text-muted">

                                    <?= html_escape(
                                        $user->student->course_code
                                    ); ?>

                                </small>

                            <?php endif; ?>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Department

                            </label>

                            <div class="fw-semibold">

                                <?= !empty(
                                    $user->student->department_name
                                )
                                    ? html_escape(
                                        $user->student->department_name
                                    )
                                    : 'Not assigned';
                                ?>

                            </div>

                            <?php if (
                                !empty(
                                $user->student->department_code
                            )
                            ): ?>

                                <small class="text-muted">

                                    <?= html_escape(
                                        $user->student->department_code
                                    ); ?>

                                </small>

                            <?php endif; ?>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Admission Date

                            </label>

                            <div>

                                <?= !empty(
                                    $user->student->admission_date
                                )
                                    ? html_escape(
                                        date(
                                            'd M Y',
                                            strtotime(
                                                $user->student->admission_date
                                            )
                                        )
                                    )
                                    : 'Not provided';
                                ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php endif; ?>


        <!-- Teacher Information -->

        <?php if ($user->teacher): ?>

            <div class="card border-0 shadow-sm rounded-3 mb-4">

                <div class="card-header bg-white border-0 p-4">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-person-workspace text-success me-2">
                        </i>

                        Teacher Information

                    </h5>

                </div>


                <div class="card-body px-4 pb-4">

                    <div class="row g-4">


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Employee Code

                            </label>

                            <div class="fw-semibold">

                                <?= html_escape(
                                    $user->teacher->employee_code
                                ); ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Phone

                            </label>

                            <div>

                                <?= !empty(
                                    $user->teacher->phone
                                )
                                    ? html_escape(
                                        $user->teacher->phone
                                    )
                                    : 'Not provided';
                                ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                First Name

                            </label>

                            <div>

                                <?= html_escape(
                                    $user->teacher->first_name
                                ); ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Last Name

                            </label>

                            <div>

                                <?= !empty(
                                    $user->teacher->last_name
                                )
                                    ? html_escape(
                                        $user->teacher->last_name
                                    )
                                    : 'Not provided';
                                ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Department

                            </label>

                            <div class="fw-semibold">

                                <?= !empty(
                                    $user->teacher->department_name
                                )
                                    ? html_escape(
                                        $user->teacher->department_name
                                    )
                                    : 'Not assigned';
                                ?>

                            </div>

                            <?php if (
                                !empty(
                                $user->teacher->department_code
                            )
                            ): ?>

                                <small class="text-muted">

                                    <?= html_escape(
                                        $user->teacher->department_code
                                    ); ?>

                                </small>

                            <?php endif; ?>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label text-muted small fw-semibold">

                                Joining Date

                            </label>

                            <div>

                                <?= !empty(
                                    $user->teacher->joining_date
                                )
                                    ? html_escape(
                                        date(
                                            'd M Y',
                                            strtotime(
                                                $user->teacher->joining_date
                                            )
                                        )
                                    )
                                    : 'Not provided';
                                ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php endif; ?>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>