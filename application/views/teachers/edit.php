<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>College Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('dashboard'); ?>">
                <i class="bi bi-building fs-3 me-2"></i>
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
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center"
                                    href="<?= site_url('profile'); ?>">
                                    <i class="bi bi-person-gear text-success me-2 fs-5"></i>
                                    My Profile
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>

                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center text-success fw-semibold"
                                    href="<?= site_url('auth/logout'); ?>">
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
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-dark mb-0">
                        Edit Teacher Record
                    </h4>

                    <a href="<?= site_url('teachers'); ?>" class="btn btn-outline-success fw-semibold">
                        Back to Directory
                    </a>
                </div>


                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-success text-white py-3">

                        <h5 class="mb-0 fw-bold">
                            <?= html_escape(
                                $teacher->name
                            ); ?>
                        </h5>

                        <small class="opacity-75">

                            Employee Code:
                            <?= html_escape(
                                $teacher->employee_code
                            ); ?>
                        </small>
                    </div>

                    <div class="card-body p-4">

                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2">
                                </i>
                                <strong>
                                    Please fix the following errors:
                                </strong>
                                <div class="small mt-2">

                                    <?= validation_errors(); ?>
                                </div>

                                <button type="button" class="btn-close" data-bs-dismiss="alert">
                                </button>
                            </div>

                        <?php endif; ?>

                        <form action="<?= site_url(
                            'teachers/edit/' . $teacher->id
                        ); ?>" method="POST">


                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Full Name

                                </label>

                                <input type="text" name="name" class="form-control focus-ring focus-ring-success" value="<?= set_value(
                                    'name',
                                    $teacher->name
                                ); ?>" maxlength="50" required>

                                <div class="form-text">

                                    Name used for login and display.

                                </div>

                            </div>


                            <div class="row">

                                <div class="col-md-6 mb-4">

                                    <label class="form-label fw-semibold">

                                        First Name

                                    </label>

                                    <input type="text" name="first_name"
                                        class="form-control focus-ring focus-ring-success" value="<?= set_value(
                                            'first_name',
                                            $teacher->first_name
                                        ); ?>" maxlength="50" required>

                                </div>


                                <div class="col-md-6 mb-4">

                                    <label class="form-label fw-semibold">

                                        Last Name

                                    </label>

                                    <input type="text" name="last_name"
                                        class="form-control focus-ring focus-ring-success" value="<?= set_value(
                                            'last_name',
                                            $teacher->last_name
                                        ); ?>" maxlength="50">

                                </div>

                            </div>

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Department

                                </label>


                                <select name="department_id" class="form-select focus-ring focus-ring-success" required>

                                    <option value="">
                                        Select Department
                                    </option>


                                    <?php if (!empty($departments)): ?>

                                        <?php foreach (
                                            $departments
                                            as $department
                                        ): ?>

                                            <option value="<?= $department->id; ?>" <?= (
                                                  (string) set_value(
                                                      'department_id',
                                                      $teacher->department_id
                                                  ) ===
                                                  (string) $department->id
                                              )
                                                  ? 'selected'
                                                  : ''; ?>>

                                                <?= html_escape(
                                                    $department->name
                                                ); ?>

                                                (<?= html_escape(
                                                    $department->code
                                                ); ?>)

                                            </option>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>

                            </div>

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Employee Code

                                </label>

                                <input type="text" name="employee_code" class="form-control bg-light" value="<?= html_escape(
                                    $teacher->employee_code
                                ); ?>" readonly>

                                <div class="form-text">

                                    Employee code cannot be changed here.

                                </div>

                            </div>

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Email

                                </label>

                                <input type="email" class="form-control bg-light" value="<?= html_escape(
                                    $teacher->email
                                ); ?>" readonly>

                                <div class="form-text">

                                    Email is managed through the user account.

                                </div>

                            </div>

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Phone

                                </label>

                                <input type="text" name="phone" class="form-control focus-ring focus-ring-success"
                                    value="<?= set_value(
                                        'phone',
                                        $teacher->phone
                                    ); ?>" maxlength="20" placeholder="Enter phone number">

                            </div>

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Joining Date

                                </label>

                                <input type="date" name="joining_date"
                                    class="form-control focus-ring focus-ring-success" value="<?= set_value(
                                        'joining_date',
                                        $teacher->joining_date
                                    ); ?>" required>

                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">
                                    Account Status
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    class="form-select focus-ring focus-ring-success"
                                    required
                                >
                                    <option
                                        value="active"
                                        <?= ($teacher->status === 'active') ? 'selected' : ''; ?>
                                    >
                                        Active
                                    </option>

                                    <option
                                        value="inactive"
                                        <?= ($teacher->status === 'inactive') ? 'selected' : ''; ?>
                                    >
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-2">

                                <a href="<?= site_url('teachers'); ?>" class="btn btn-outline-success fw-semibold">

                                    Cancel

                                </a>


                                <button type="submit" class="btn btn-success fw-semibold">

                                    Save Changes

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>