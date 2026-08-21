<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>College Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f8f9fa;
        }

        .onboarding-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .onboarding-card {
            width: 100%;
            max-width: 700px;
            border: 0;
            border-radius: 16px;
            overflow: hidden;
        }

        .onboarding-header {
            background: #198754;
            color: white;
            padding: 30px;
        }

        .onboarding-body {
            padding: 35px;
        }

        .required::after {
            content: " *";
            color: #35dc4b;
        }
    </style>

</head>

<body>

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
                                    $this->session->userdata('role_name') ?? 'User'
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


    <div class="onboarding-wrapper">

        <div class="card shadow-sm onboarding-card">

            <div class="onboarding-header">

                <div class="d-flex align-items-center">

                    <div class="bg-white text-success rounded-circle p-3 me-3">

                        <?php if ($role_id === 3): ?>

                            <i class="bi bi-person-badge fs-3"></i>

                        <?php elseif ($role_id === 4): ?>

                            <i class="bi bi-person fs-3"></i>

                        <?php endif; ?>

                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            Complete Your Profile
                        </h3>

                        <p class="mb-0 opacity-75">
                            Please provide the required information to continue.
                        </p>

                    </div>

                </div>

            </div>


            <div class="onboarding-body">

                <?php if ($this->session->flashdata('error')): ?>

                    <div class="alert alert-danger alert-dismissible fade show">

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        <?= html_escape($this->session->flashdata('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>

                <?php endif; ?>


                <?= validation_errors(
                    '<div class="alert alert-danger">',
                    '</div>'
                ); ?>

                <?php if ($role_id === 3): ?>

                    <form action="<?= site_url('onboarding'); ?>" method="POST">

                        <h5 class="fw-bold mb-4">
                            Teacher Information
                        </h5>

                        <div class="mb-3">

                            <label for="employee_code" class="form-label fw-semibold required">

                                Employee Code

                            </label>

                            <input type="text" id="employee_code" name="employee_code" class="form-control" maxlength="20"
                                value="<?= set_value('employee_code'); ?>" placeholder="Enter employee code" required>

                        </div>



                        <div class="mb-3">

                            <label for="department_id" class="form-label fw-semibold required">

                                Department

                            </label>

                            <select id="department_id" name="department_id" class="form-select" required>

                                <option value="">
                                    Select Department
                                </option>

                                <?php if (!empty($departments)): ?>

                                    <?php foreach ($departments as $department): ?>

                                        <option value="<?= html_escape($department->id); ?>" <?= set_select(
                                              'department_id',
                                              $department->id
                                          ); ?>>

                                            <?= html_escape($department->name); ?>

                                            (<?= html_escape($department->code); ?>)

                                        </option>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </select>

                        </div>




                        <div class="mb-3">

                            <label for="first_name" class="form-label fw-semibold required">

                                First Name

                            </label>

                            <input type="text" id="first_name" name="first_name" class="form-control" maxlength="50"
                                value="<?= set_value('first_name'); ?>" placeholder="Enter first name" required>

                        </div>


                        <div class="mb-3">

                            <label for="last_name" class="form-label fw-semibold">

                                Last Name

                            </label>

                            <input type="text" id="last_name" name="last_name" class="form-control" maxlength="50"
                                value="<?= set_value('last_name'); ?>" placeholder="Enter last name">

                        </div>



                        <div class="mb-3">

                            <label for="phone" class="form-label fw-semibold">

                                Phone Number

                            </label>

                            <input type="tel" id="phone" name="phone" class="form-control" maxlength="20"
                                value="<?= set_value('phone'); ?>" placeholder="Enter phone number">

                        </div>


                        <div class="mb-4">

                            <label for="joining_date" class="form-label fw-semibold required">

                                Joining Date

                            </label>

                            <input type="date" id="joining_date" name="joining_date" class="form-control"
                                value="<?= set_value('joining_date'); ?>" required>

                        </div>


                        <button type="submit" class="btn btn-success w-100 fw-semibold py-2">

                            <i class="bi bi-check-circle me-2"></i>

                            Complete Teacher Profile

                        </button>

                    </form>



                <?php elseif ($role_id === 4): ?>

                    <form action="<?= site_url('onboarding'); ?>" method="POST">

                        <h5 class="fw-bold mb-4">
                            Student Information
                        </h5>


                        <div class="mb-3">

                            <label for="student_code" class="form-label fw-semibold required">

                                Student Code

                            </label>

                            <input type="text" id="student_code" name="student_code" class="form-control" maxlength="20"
                                value="<?= set_value('student_code'); ?>" placeholder="Enter student code" required>

                        </div>


                        <div class="mb-3">

                            <label for="course_id" class="form-label fw-semibold required">

                                Course

                            </label>

                            <select id="course_id" name="course_id" class="form-select" required>

                                <option value="">
                                    Select Course
                                </option>

                                <?php if (!empty($courses)): ?>

                                    <?php foreach ($courses as $course): ?>

                                        <option value="<?= html_escape($course->id); ?>" <?= set_select(
                                              'course_id',
                                              $course->id
                                          ); ?>>

                                            <?= html_escape($course->name); ?>

                                            <?php if (!empty($course->code)): ?>

                                                (<?= html_escape($course->code); ?>)

                                            <?php endif; ?>

                                        </option>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </select>

                        </div>



                        <div class="mb-3">

                            <label for="dob" class="form-label fw-semibold required">

                                Date of Birth

                            </label>

                            <input type="date" id="dob" name="dob" class="form-control" value="<?= set_value('dob'); ?>"
                                required>

                        </div>



                        <div class="mb-3">

                            <label for="gender" class="form-label fw-semibold required">

                                Gender

                            </label>

                            <select id="gender" name="gender" class="form-select" required>

                                <option value="">
                                    Select Gender
                                </option>

                                <option value="male" <?= set_select('gender', 'male'); ?>>

                                    Male

                                </option>

                                <option value="female" <?= set_select('gender', 'female'); ?>>

                                    Female

                                </option>

                                <option value="other" <?= set_select('gender', 'other'); ?>>

                                    Other

                                </option>

                            </select>

                        </div>



                        <div class="mb-3">

                            <label for="phone" class="form-label fw-semibold">

                                Phone Number

                            </label>

                            <input type="tel" id="phone" name="phone" class="form-control" maxlength="20"
                                value="<?= set_value('phone'); ?>" placeholder="Enter phone number">

                        </div>



                        <div class="mb-4">

                            <label for="admission_date" class="form-label fw-semibold required">

                                Admission Date

                            </label>

                            <input type="date" id="admission_date" name="admission_date" class="form-control"
                                value="<?= set_value('admission_date'); ?>" required>

                        </div>


                        <button type="submit" class="btn btn-success w-100 fw-semibold py-2">

                            <i class="bi bi-check-circle me-2"></i>

                            Complete Student Profile

                        </button>

                    </form>

                <?php endif; ?>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>