<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .audit-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .audit-table {
            margin-bottom: 0;
        }

        .audit-table thead th {
            background-color: #f1f8f4;
            color: #495057;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            white-space: nowrap;
            padding: 0.9rem 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .audit-table tbody td {
            padding: 1rem;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .audit-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .audit-table tbody tr:hover {
            background-color: #f8faf9;
        }

        .actor-name {
            font-weight: 600;
            color: #212529;
        }

        .actor-role {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .action-badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.4rem 0.65rem;
            border-radius: 6px;
            white-space: nowrap;
        }

        .action-update {
            background-color: #e7f1ff;
            color: #0d6efd;
        }

        .action-status {
            background-color: #fff3cd;
            color: #856404;
        }

        .action-login {
            background-color: #d1e7dd;
            color: #146c43;
        }

        .action-logout {
            background-color: #e9ecef;
            color: #495057;
        }

        .action-default {
            background-color: #e9ecef;
            color: #495057;
        }

        .record-badge {
            font-size: 0.75rem;
            background-color: #f1f3f5;
            color: #495057;
            border: 1px solid #dee2e6;
            padding: 0.3rem 0.5rem;
            border-radius: 5px;
        }

        .table-name {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .description {
            max-width: 250px;
            color: #495057;
        }

        .date-time {
            white-space: nowrap;
            font-size: 0.8rem;
        }

        .date-time .date {
            font-weight: 600;
            color: #343a40;
        }

        .date-time .time {
            color: #6c757d;
        }

        .details-btn {
            font-size: 0.8rem;
        }

        .empty-state {
            padding: 4rem 1rem;
        }

        .empty-state i {
            font-size: 2.5rem;
            color: #adb5bd;
        }

        .table-container {
            overflow: visible;
        }

        .modal-json {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            font-size: 0.8rem;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .info-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 0.04em;
        }

        .changes-table th {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #6c757d;
        }

        .changes-table td {
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .pagination-container {
            border-top: 1px solid #dee2e6;
            padding: 1rem 1.5rem;
        }

        .pagination .page-link {
            color: #198754;
        }

        .pagination .page-item.active .page-link {
            background-color: #198754;
            border-color: #198754;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('dashboard'); ?>">
            <i class="bi bi-book-half fs-3 me-2"></i>
            CMS Portal
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="dashNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2"
                       href="#"
                       id="userDropdown"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">

                        <span class="fw-semibold">
                            <?= html_escape(
                                $this->session->userdata('name') ?? 'User'
                            ); ?>
                        </span>

                        <span class="badge bg-light text-success">
                            <?= html_escape(
                                ucfirst(
                                    $this->session->userdata('role_name') ?? 'User'
                                )
                            ); ?>
                        </span>

                        <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center shadow-sm"
                             style="width:38px;height:38px;">
                            <i class="bi bi-person-fill fs-5"></i>
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li>
                            <a class="dropdown-item py-2" href="<?= site_url('profile'); ?>">
                                <i class="bi bi-person-gear text-success me-2"></i>
                                My Profile
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item py-2 text-success fw-semibold"
                               href="<?= site_url('auth/logout'); ?>">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid px-4 py-4">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h3 class="fw-bold mb-0 ms-4">
                    Audit Logs
                </h3>
            </div>

            <p class="text-muted mb-0 ms-5">
                Review administrative activity and system changes.
            </p>
        </div>

        <a href="<?= site_url('dashboard'); ?>" class="btn btn-success fw-semibold">
            Go Back
        </a>

    </div>

    <div class="card audit-card shadow">

        <div class="card-header bg-white border-bottom py-3 px-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="fw-bold mb-1">
                        Activity History
                    </h6>

                    <small class="text-muted">
                        <?= $total_logs; ?>
                        <?= $total_logs === 1 ? 'record' : 'records'; ?>
                    </small>

                </div>

            </div>

        </div>

        <div class="table-container">

            <table class="table audit-table table-hover align-middle">

                <thead>

                    <tr>
                        <th>Date / Time</th>
                        <th>Actor</th>
                        <th>Action</th>
                        <th>Resource</th>
                        <th>Description</th>
                        <th></th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($logs)): ?>

                        <?php foreach ($logs as $log): ?>

                            <?php
                            switch ($log->action) {
                                case 'UPDATE_STUDENT':
                                    $badge_class = 'action-update';
                                    $action_label = 'Update Student';
                                    break;

                                case 'UPDATE_TEACHER':
                                    $badge_class = 'action-update';
                                    $action_label = 'Update Teacher';
                                    break;

                                case 'CHANGE_STATUS':
                                    $badge_class = 'action-status';
                                    $action_label = 'Change Status';
                                    break;

                                default:
                                    $badge_class = 'action-default';
                                    $action_label = ucwords(
                                        strtolower(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $log->action
                                            )
                                        )
                                    );
                                    break;
                            }
                            ?>

                            <tr>

                                <td>

                                    <div class="date-time">

                                        <div class="date">
                                            <?= html_escape(
                                                date(
                                                    'd M Y',
                                                    strtotime($log->created_at)
                                                )
                                            ); ?>
                                        </div>

                                        <div class="time">
                                            <?= html_escape(
                                                date(
                                                    'h:i A',
                                                    strtotime($log->created_at)
                                                )
                                            ); ?>
                                        </div>

                                    </div>

                                </td>

                                <td>

                                    <div class="actor-name">
                                        <?= html_escape(
                                            $log->actor_name ?? 'Unknown'
                                        ); ?>
                                    </div>

                                    <div class="actor-role">
                                        <?= html_escape(
                                            ucfirst(
                                                $log->actor_role ?? ''
                                            )
                                        ); ?>
                                    </div>

                                </td>

                                <td>

                                    <span class="action-badge <?= $badge_class; ?>">
                                        <?= html_escape(
                                            $action_label
                                        ); ?>
                                    </span>

                                </td>

                                <td>

                                    <div class="table-name">
                                        <?= html_escape(
                                            $log->table_name
                                        ); ?>
                                    </div>

                                    <div class="mt-1">
                                        ID:
                                        <?= (int)$log->record_id; ?>
                                    </div>

                                </td>

                                <td>

                                    <div class="description">
                                        <?= html_escape(
                                            $log->description
                                        ); ?>
                                    </div>

                                </td>

                                <td class="text-end">

                                    <button type="button"
                                            class="btn btn-sm btn-outline-success details-btn fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#logModal<?= (int)$log->id; ?>">

                                        Details

                                    </button>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6" class="text-center">

                                <div class="empty-state">

                                    <i class="bi bi-journal-x d-block mb-3"></i>

                                    <h6 class="fw-bold text-dark">
                                        No audit logs found
                                    </h6>

                                    <p class="text-muted mb-0">
                                        Administrative activity will appear here.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

        <?php if ($total_pages > 1): ?>

            <div class="pagination-container">

                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">

                        Showing
                        <?= (($current_page - 1) * $per_page) + 1; ?>
                        -
                        <?= min(
                            $current_page * $per_page,
                            $total_logs
                        ); ?>
                        of
                        <?= $total_logs; ?>

                    </small>

                    <nav aria-label="Audit log pagination">

                        <ul class="pagination pagination-sm mb-0">

                            <?php if ($current_page > 1): ?>

                                <li class="page-item">

                                    <a class="page-link"
                                       href="<?= site_url('audit') . '?page=' . ($current_page - 1); ?>">

                                        <i class="bi bi-chevron-left"></i>
                                        Previous

                                    </a>

                                </li>

                            <?php else: ?>

                                <li class="page-item disabled">

                                    <span class="page-link">

                                        <i class="bi bi-chevron-left"></i>
                                        Previous

                                    </span>

                                </li>

                            <?php endif; ?>

                            <?php for ($page = 1; $page <= $total_pages; $page++): ?>

                                <li class="page-item <?= $page === $current_page ? 'active' : ''; ?>">

                                    <a class="page-link"
                                       href="<?= site_url('audit') . '?page=' . $page; ?>">

                                        <?= $page; ?>

                                    </a>

                                </li>

                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>

                                <li class="page-item">

                                    <a class="page-link"
                                       href="<?= site_url('audit') . '?page=' . ($current_page + 1); ?>">

                                        Next
                                        <i class="bi bi-chevron-right"></i>

                                    </a>

                                </li>

                            <?php else: ?>

                                <li class="page-item disabled">

                                    <span class="page-link">

                                        Next
                                        <i class="bi bi-chevron-right"></i>

                                    </span>

                                </li>

                            <?php endif; ?>

                        </ul>

                    </nav>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php if (!empty($logs)): ?>

    <?php foreach ($logs as $log): ?>

        <?php
        switch ($log->action) {
            case 'UPDATE_STUDENT':
                $badge_class = 'action-update';
                $action_label = 'Update Student';
                break;

            case 'UPDATE_TEACHER':
                $badge_class = 'action-update';
                $action_label = 'Update Teacher';
                break;

            case 'CHANGE_STATUS':
                $badge_class = 'action-status';
                $action_label = 'Change Status';
                break;

            default:
                $badge_class = 'action-default';
                $action_label = ucwords(
                    strtolower(
                        str_replace(
                            '_',
                            ' ',
                            $log->action
                        )
                    )
                );
                break;
        }

        $old_values = json_decode(
            $log->old_values,
            TRUE
        ) ?: [];

        $new_values = json_decode(
            $log->new_values,
            TRUE
        ) ?: [];

        $field_labels = [
            'name' => 'Name',
            'student_code' => 'Student Code',
            'employee_code' => 'Employee Code',
            'course_id' => 'Course',
            'department_id' => 'Department',
            'dob' => 'Date of Birth',
            'gender' => 'Gender',
            'phone' => 'Phone',
            'admission_date' => 'Admission Date',
            'joining_date' => 'Joining Date',
            'status' => 'Status'
        ];
        ?>

        <div class="modal fade"
             id="logModal<?= (int)$log->id; ?>"
             tabindex="-1"
             aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-scrollable">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header">

                        <div>

                            <h5 class="modal-title fw-bold">
                                Audit Log Details
                            </h5>

                            <small class="text-muted">
                                Log #<?= (int)$log->id; ?>
                            </small>

                        </div>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="row g-3 mb-4">

                            <div class="col-md-4">

                                <div class="info-label">
                                    Action
                                </div>

                                <div class="mt-1">

                                    <span class="action-badge <?= $badge_class; ?>">
                                        <?= html_escape(
                                            $action_label
                                        ); ?>
                                    </span>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="info-label">
                                    Actor
                                </div>

                                <div class="mt-1 fw-semibold">
                                    <?= html_escape(
                                        $log->actor_name ?? 'Unknown'
                                    ); ?>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="info-label">
                                    Date
                                </div>

                                <div class="mt-1">
                                    <?= html_escape(
                                        $log->created_at
                                    ); ?>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="info-label">
                                    Resource
                                </div>

                                <div class="mt-1">

                                    <?= html_escape(
                                        $log->table_name
                                    ); ?>

                                    #

                                    <?= (int)$log->record_id; ?>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="info-label">
                                    IP Address
                                </div>

                                <div class="mt-1">
                                    <?= html_escape(
                                        $log->ip_address
                                    ); ?>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="info-label">
                                    User Agent
                                </div>

                                <div class="mt-1"
                                     title="<?= html_escape($log->user_agent); ?>">

                                    <?= html_escape(
                                        $log->user_agent
                                    ); ?>

                                </div>

                            </div>

                        </div>

                        <div class="mb-4">

                            <div class="info-label mb-2">
                                Description
                            </div>

                            <div>
                                <?= html_escape(
                                    $log->description
                                ); ?>
                            </div>

                        </div>

                        <div>

                            <div class="info-label mb-2">
                                Changes
                            </div>

                            <div class="table-responsive">

                                <table class="table table-bordered changes-table mb-0">

                                    <thead>

                                        <tr>
                                            <th>Field</th>
                                            <th>Previous</th>
                                            <th>New</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($new_values as $field => $new_value): ?>

                                            <tr>

                                                <td class="fw-semibold">

                                                    <?= html_escape(
                                                        $field_labels[$field]
                                                        ?? ucwords(
                                                            str_replace(
                                                                '_',
                                                                ' ',
                                                                $field
                                                            )
                                                        )
                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?= html_escape(
                                                        $old_values[$field]
                                                        ?? 'NULL'
                                                    ); ?>

                                                </td>

                                                <td>

                                                    <?= html_escape(
                                                        $new_value
                                                        ?? 'NULL'
                                                    ); ?>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-success fw-semibold"
                                data-bs-dismiss="modal">

                            Close

                        </button>

                    </div>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>