<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>College Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

</head>


<body class="bg-light">


    <!-- Navbar -->

    <nav
        class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm sticky-top">

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

                <ul
                    class="navbar-nav ms-auto align-items-center">

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
                                style="width: 38px; height: 38px;">

                                <i
                                    class="bi bi-person-fill fs-5">
                                </i>

                            </div>

                        </a>


                        <ul
                            class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                            aria-labelledby="userDropdown">

                            <li>

                                <a
                                    class="dropdown-item py-2 d-flex align-items-center"
                                    href="<?= site_url('/profile'); ?>">

                                    <i
                                        class="bi bi-person-gear text-success me-2 fs-5">
                                    </i>

                                    My Profile

                                </a>

                            </li>


                            <li>

                                <hr
                                    class="dropdown-divider my-1">

                            </li>


                            <li>

                                <a
                                    class="dropdown-item py-2 d-flex align-items-center text-success fw-semibold"
                                    href="<?= site_url('/auth/logout'); ?>">

                                    <i
                                        class="bi bi-box-arrow-right me-2 fs-5">
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

        <div
            class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    My Subjects
                </h2>

                <p class="text-muted mb-0">
                    Subjects enrolled under your course.
                </p>

            </div>


            <div>

                <a
                    href="<?= site_url('/courses'); ?>"
                    class="btn btn-outline-success fw-semibold">

                    Back to Courses

                </a>

            </div>

        </div>


        <!-- Subjects -->

        <div
            class="card border-0 shadow-sm rounded-3">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table
                        class="table table-hover align-middle mb-0">


                        <thead class="table-light">

                            <tr>

                                <th class="px-3">
                                    Subject
                                </th>

                                <th>
                                    Code
                                </th>

                                <th>
                                    Semester
                                </th>

                                <th>
                                    Credits
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($subjects)): ?>

                                <?php foreach (
                                    $subjects as $subject
                                ): ?>

                                    <tr>


                                        <td class="fw-semibold px-3">

                                            <?= html_escape(
                                                $subject->name
                                            ); ?>

                                        </td>


                                        <td>

                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle">

                                                <?= html_escape(
                                                    $subject->code
                                                ); ?>

                                            </span>

                                        </td>


                                        <td>

                                            <span
                                                class="badge bg-light text-dark border">

                                                Semester
                                                <?= html_escape(
                                                    $subject->semester
                                                ); ?>

                                            </span>

                                        </td>


                                        <td>

                                            <?= html_escape(
                                                $subject->credits
                                            ); ?>

                                            Credits

                                        </td>


                                    </tr>

                                <?php endforeach; ?>


                            <?php else: ?>

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center py-5 text-muted">

                                        <i
                                            class="bi bi-book fs-1 d-block mb-2">
                                        </i>

                                        No subjects found.

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