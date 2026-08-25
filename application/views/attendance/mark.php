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
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2 pe-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-semibold text-white">
                            <?= html_escape($this->session->userdata('name') ?? 'User'); ?>
                        </span>

                        <span class="badge bg-light text-success fw-semibold" style="font-size: 0.75rem;">
                            <?= html_escape(ucfirst($this->session->userdata('role_name') ?? 'User')); ?>
                        </span>

                        <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center shadow-sm ms-1" style="width: 38px; height: 38px;">
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

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Mark Attendance
            </h2>

            <p class="text-muted mb-0">
                <?= html_escape($subject->name); ?>
                ·
                <?= html_escape($subject->course_name); ?>
            </p>
        </div>

        <div>
            <a href="<?= site_url('/attendance'); ?>" class="btn btn-outline-success fw-semibold">
                Back to Attendance
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>

        <div class="alert alert-success">
            <?= html_escape($this->session->flashdata('success')); ?>
        </div>

    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger">
            <?= html_escape($this->session->flashdata('error')); ?>
        </div>

    <?php endif; ?>

    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="card border-0 shadow-sm rounded-3">

        <div class="card-header bg-white border-0 p-4">

            <div class="row align-items-end">

                <div class="col-md-4">

                    <label
                        for="attendance_date"
                        class="form-label fw-semibold">

                        Attendance Date

                    </label>

                    <form
                        method="get"
                        action="<?= site_url('/attendance/mark/' . $subject->id); ?>">

                        <div class="input-group">

                            <input
                                type="date"
                                name="date"
                                id="attendance_date"
                                class="form-control"
                                value="<?= html_escape($attendance_date); ?>"
                                required>

                            <button
                                type="submit"
                                class="btn btn-outline-success">

                                Load

                            </button>

                        </div>

                    </form>

                </div>

                <div class="col-md-8 text-md-end mt-3 mt-md-0">

                    <div class="text-muted">
                        <?= html_escape($subject->code); ?>
                        ·
                        Semester <?= html_escape($subject->semester); ?>
                        ·
                        <?= html_escape($subject->credits); ?> Credits
                    </div>

                </div>

            </div>

        </div>

        <div class="card-body p-0">

            <?php if (!empty($students)): ?>

                <form
                    method="post"
                    action="<?= site_url('/attendance/mark/' . $subject->id); ?>">

                    <input
                        type="hidden"
                        name="attendance_date"
                        value="<?= html_escape($attendance_date); ?>">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="px-4">
                                        Student
                                    </th>

                                    <th>
                                        Student Code
                                    </th>

                                    <th>
                                        Email
                                    </th>

                                    <th class="text-center">
                                        Status
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($students as $student): ?>

                                    <?php
                                    $status =
                                        isset($attendance[$student->id])
                                            ? $attendance[$student->id]
                                            : 'present';
                                    ?>

                                    <tr>

                                        <td class="px-4 fw-semibold">

                                            <?= html_escape(
                                                $student->name
                                            ); ?>

                                        </td>

                                        <td>

                                            <span class="badge bg-success-subtle text-success border border-success-subtle">

                                                <?= html_escape(
                                                    $student->student_code
                                                ); ?>

                                            </span>

                                        </td>

                                        <td>

                                            <?= html_escape(
                                                $student->email
                                            ); ?>

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center gap-3">

                                                <div class="form-check">

                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        name="status[<?= $student->id; ?>]"
                                                        value="present"
                                                        id="present_<?= $student->id; ?>"
                                                        <?= $status === 'present' ? 'checked' : ''; ?>>

                                                    <label
                                                        class="form-check-label text-success fw-semibold"
                                                        for="present_<?= $student->id; ?>">

                                                        Present

                                                    </label>

                                                </div>

                                                <div class="form-check">

                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        name="status[<?= $student->id; ?>]"
                                                        value="absent"
                                                        id="absent_<?= $student->id; ?>"
                                                        <?= $status === 'absent' ? 'checked' : ''; ?>>

                                                    <label
                                                        class="form-check-label text-danger fw-semibold"
                                                        for="absent_<?= $student->id; ?>">

                                                        Absent

                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                    <div class="p-4 border-top text-end">

                        <button
                            type="submit"
                            class="btn btn-success fw-semibold">
                            Save

                        </button>

                    </div>

                </form>

            <?php else: ?>

                <div class="text-center py-5 text-muted">

                    <i class="bi bi-people fs-1 d-block mb-2"></i>

                    No students found for this subject.

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>