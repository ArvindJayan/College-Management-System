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

            <a
                class="navbar-brand fw-bold d-flex align-items-center"
                href="<?= site_url('/dashboard'); ?>">

                <i class="bi bi-book-half fs-3 me-2"></i>

                CMS Portal

            </a>


            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#dashNav">

                <span class="navbar-toggler-icon"></span>

            </button>


            <div
                class="collapse navbar-collapse"
                id="dashNav">

                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2 pe-0"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <span class="fw-semibold text-white">

                                <?= html_escape(
                                    $this->session->userdata('name') ?? 'User'
                                ); ?>

                            </span>


                            <span
                                class="badge bg-light text-success fw-semibold"
                                style="font-size: 0.75rem;">

                                <?= html_escape(
                                    $this->session->userdata('role_name') ?? 'User'
                                ); ?>

                            </span>


                            <div
                                class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center shadow-sm ms-1"
                                style="width: 38px; height: 38px; flex-shrink: 0;">

                                <i class="bi bi-person-fill fs-5"></i>

                            </div>

                        </a>


                        <ul
                            class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                            aria-labelledby="userDropdown">

                            <li>

                                <a
                                    class="dropdown-item py-2 d-flex align-items-center"
                                    href="<?= site_url('/profile'); ?>">

                                    <i class="bi bi-person-gear text-success me-2 fs-5"></i>

                                    My Profile

                                </a>

                            </li>


                            <li>

                                <hr class="dropdown-divider my-1">

                            </li>


                            <li>

                                <a
                                    class="dropdown-item py-2 d-flex align-items-center text-success fw-semibold"
                                    href="<?= site_url('/auth/logout'); ?>">

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

    <div class="container py-5">



        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">

                    Courses

                </h2>


                <p class="text-muted mb-0">

                    Manage college courses.

                </p>

            </div>


            <div class="d-flex gap-2">

                <a
                    href="<?= site_url('/dashboard'); ?>"
                    class="btn btn-outline-success fw-semibold">

                    Back to Dashboard

                </a>


                <?php $role_id = (int) $this->session->userdata('role_id'); ?>
                <?php if ($role_id == 1): ?>
                <a
                    href="<?= site_url('courses/create'); ?>"
                    class="btn btn-success fw-semibold">
                    Add Course

                </a>
                <?php endif; ?>

            </div>

        </div>

        <?php if ($this->session->flashdata('success')): ?>

            <div
                class="alert alert-success alert-dismissible fade show">

                <?= html_escape(
                    $this->session->flashdata('success')
                ); ?>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">

                </button>

            </div>

        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>

            <div
                class="alert alert-danger alert-dismissible fade show">

                <?= html_escape(
                    $this->session->flashdata('error')
                ); ?>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">

                </button>

            </div>

        <?php endif; ?>


        <div class="card border-0 shadow-sm rounded-3">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table
                        class="table table-hover align-middle mb-0">


                        <thead class="table-light">

                            <tr>

                                <th class='px-3'>
                                    Course
                                </th>


                                <th>
                                    Code
                                </th>


                                <th>
                                    Department
                                </th>


                                <th>
                                    Duration
                                </th>

                            <?php if ( $role_id == 1): ?>
                                <th class="text-end pe-4">
                                    Actions
                                </th>

                            </tr>
                            <?php endif; ?>
                        </thead>


                        <tbody>
                            <?php if (!empty($courses)): ?>
                                <?php foreach ($courses as $course): ?>

                                    <tr>

                                        <td class="fw-semibold px-3">

                                            <?= html_escape(
                                                $course->name
                                            ); ?>

                                        </td>


                                        <td>

                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle">

                                                <?= html_escape(
                                                    $course->code
                                                ); ?>

                                            </span>

                                        </td>


                                        <td>

                                            <?= html_escape(
                                                $course->department_name
                                            ); ?>


                                            <small class="text-muted d-block">

                                                <?= html_escape(
                                                    $course->department_code
                                                ); ?>

                                            </small>

                                        </td>


                                        <td>

                                            <?= html_escape(
                                                $course->duration_years
                                            ); ?>


                                            <?= (
                                                $course->duration_years == 1
                                            )
                                                ? 'Year'
                                                : 'Years';
                                            ?>

                                        </td>

                                        <?php if ( $role_id == 1): ?>
                                        <td class="text-end pe-4">


                                            <a
                                                href="<?= site_url(
                                                    'courses/edit/' .
                                                    $course->id
                                                ); ?>"
                                                class="btn btn-sm btn-success fw-semibold">

                                                <i class="bi bi-pencil me-1"></i>

                                                Edit

                                            </a>

                                            <a
                                                href="<?= site_url(
                                                    'courses/delete/' .
                                                    $course->id
                                                ); ?>"
                                                class="btn btn-sm btn-outline-danger fw-semibold"
                                                onclick="return confirm('Are you sure you want to delete this course?');">

                                                <i class="bi bi-trash me-1"></i>

                                                Delete

                                            </a>

                                        </td>
                                        <?php endif; ?>
                                    </tr>

                                <?php endforeach; ?>


                            <?php else: ?>


                                <!-- No Courses -->

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center py-5 text-muted">

                                        <i
                                            class="bi bi-book fs-1 d-block mb-2">
                                        </i>


                                        No courses found.

                                    </td>

                                </tr>


                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>