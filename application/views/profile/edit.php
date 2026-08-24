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
                                    ucfirst($this->session->userdata('role_name') ?? 'User')
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


        <!-- Header -->

        <div
            class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    Edit Profile
                </h2>

                <p class="text-muted mb-0">
                    Update your personal information.
                </p>

            </div>


            <div>

                <a
                    href="<?= site_url('/profile'); ?>"
                    class="btn btn-outline-success fw-semibold">

                    Back to Profile

                </a>

            </div>

        </div>


        <!-- Error Message -->

        <?php if (
            $this->session->flashdata('error')
        ): ?>

            <div
                class="alert alert-danger alert-dismissible fade show">

                <i class="bi bi-exclamation-circle me-2"></i>

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


        <!-- Validation Errors -->

        <?php if (
            validation_errors()
        ): ?>

            <div
                class="alert alert-danger">

                <?= validation_errors(); ?>

            </div>

        <?php endif; ?>


        <form
            method="post"
            action="<?= site_url('/profile/edit'); ?>">


            <!-- Account Information -->

            <div
                class="card border-0 shadow-sm rounded-3 mb-4">

                <div
                    class="card-header bg-white border-0 p-4">

                    <h5 class="fw-bold mb-0">

                        <i
                            class="bi bi-person-circle text-success me-2">
                        </i>

                        Account Information

                    </h5>

                </div>


                <div
                    class="card-body px-4 pb-4">

                    <div class="row g-4">


                        <!-- Name -->

                        <div class="col-md-6">

                            <label
                                for="name"
                                class="form-label fw-semibold">

                                Full Name

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                maxlength="50"
                                value="<?= html_escape(
                                    set_value(
                                        'name',
                                        $user->name
                                    )
                                ); ?>"
                                required>

                        </div>


                        <!-- Email -->

                        <div class="col-md-6">

                            <label
                                for="email"
                                class="form-label fw-semibold">

                                Email Address

                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                maxlength="100"
                                value="<?= html_escape(
                                    set_value(
                                        'email',
                                        $user->email
                                    )
                                ); ?>"
                                required>

                        </div>


                        <!-- Role -->

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold">

                                Role

                            </label>

                            <div>

                                <span
                                    class="badge bg-success-subtle text-success border border-success-subtle">

                                    <?= html_escape(
                                        ucfirst(
                                            $user->role_name
                                        )
                                    ); ?>

                                </span>

                            </div>

                            <small class="text-muted">
                                Your role cannot be changed here.
                            </small>

                        </div>


                        <!-- Status -->

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold">

                                Account Status

                            </label>

                            <div>

                                <?php if (
                                    $user->status === 'active'
                                ): ?>

                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle">

                                        Active

                                    </span>

                                <?php else: ?>

                                    <span
                                        class="badge bg-danger-subtle text-danger border border-danger-subtle">

                                        Inactive

                                    </span>

                                <?php endif; ?>

                            </div>

                            <small class="text-muted">
                                Account status cannot be changed here.
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Student Information -->

            <?php if ($user->student): ?>

                <div
                    class="card border-0 shadow-sm rounded-3 mb-4">

                    <div
                        class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">

                            <i
                                class="bi bi-mortarboard text-success me-2">
                            </i>

                            Student Information

                        </h5>

                    </div>


                    <div
                        class="card-body px-4 pb-4">

                        <div class="row g-4">


                            <!-- Student Code -->

                            <div class="col-md-6">

                                <label
                                    class="form-label fw-semibold">

                                    Student Code

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= html_escape(
                                        $user->student->student_code
                                    ); ?>"
                                    disabled>

                                <small class="text-muted">
                                    Student code cannot be changed.
                                </small>

                            </div>


                            <!-- Course -->

                            <div class="col-md-6">

                                <label
                                    class="form-label fw-semibold">

                                    Course

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= html_escape(
                                        $user->student->course_name ?? 'Not assigned'
                                    ); ?>"
                                    disabled>

                                <small class="text-muted">
                                    Course is managed by the college.
                                </small>

                            </div>


                            <!-- Department -->

                            <div class="col-md-6">

                                <label
                                    class="form-label fw-semibold">

                                    Department

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= html_escape(
                                        $user->student->department_name ?? 'Not assigned'
                                    ); ?>"
                                    disabled>

                                <small class="text-muted">
                                    Department is managed by the college.
                                </small>

                            </div>


                            <!-- Date of Birth -->

                            <div class="col-md-6">

                                <label
                                    for="dob"
                                    class="form-label fw-semibold">

                                    Date of Birth

                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="dob"
                                    name="dob"
                                    value="<?= html_escape(
                                        set_value(
                                            'dob',
                                            $user->student->dob
                                        )
                                    ); ?>">

                            </div>


                            <!-- Gender -->

                            <div class="col-md-6">

                                <label
                                    for="gender"
                                    class="form-label fw-semibold">

                                    Gender

                                </label>

                                <select
                                    class="form-select"
                                    id="gender"
                                    name="gender">

                                    <option value="">
                                        Select Gender
                                    </option>

                                    <option
                                        value="male"
                                        <?= set_select(
                                            'gender',
                                            'male',
                                            $user->student->gender === 'male'
                                        ); ?>>

                                        Male

                                    </option>

                                    <option
                                        value="female"
                                        <?= set_select(
                                            'gender',
                                            'female',
                                            $user->student->gender === 'female'
                                        ); ?>>

                                        Female

                                    </option>

                                    <option
                                        value="other"
                                        <?= set_select(
                                            'gender',
                                            'other',
                                            $user->student->gender === 'other'
                                        ); ?>>

                                        Other

                                    </option>

                                </select>

                            </div>


                            <!-- Phone -->

                            <div class="col-md-6">

                                <label
                                    for="phone"
                                    class="form-label fw-semibold">

                                    Phone

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                    maxlength="20"
                                    value="<?= html_escape(
                                        set_value(
                                            'phone',
                                            $user->student->phone
                                        )
                                    ); ?>">

                            </div>


                            <!-- Admission Date -->

                            <div class="col-md-6">

                                <label
                                    class="form-label fw-semibold">

                                    Admission Date

                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    value="<?= html_escape(
                                        $user->student->admission_date
                                    ); ?>"
                                    disabled>

                                <small class="text-muted">
                                    Admission date cannot be changed.
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>


            <!-- Teacher Information -->

            <?php if ($user->teacher): ?>

                <div
                    class="card border-0 shadow-sm rounded-3 mb-4">

                    <div
                        class="card-header bg-white border-0 p-4">

                        <h5 class="fw-bold mb-0">

                            <i
                                class="bi bi-person-workspace text-success me-2">
                            </i>

                            Teacher Information

                        </h5>

                    </div>


                    <div
                        class="card-body px-4 pb-4">

                        <div class="row g-4">


                            <!-- Employee Code -->

                            <div class="col-md-6">

                                <label
                                    class="form-label fw-semibold">

                                    Employee Code

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= html_escape(
                                        $user->teacher->employee_code
                                    ); ?>"
                                    disabled>

                                <small class="text-muted">
                                    Employee code cannot be changed.
                                </small>

                            </div>


                            <!-- Department -->

                            <div class="col-md-6">

                                <label
                                    class="form-label fw-semibold">

                                    Department

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= html_escape(
                                        $user->teacher->department_name ?? 'Not assigned'
                                    ); ?>"
                                    disabled>

                                <small class="text-muted">
                                    Department is managed by the college.
                                </small>

                            </div>


                            <!-- First Name -->

                            <div class="col-md-6">

                                <label
                                    for="first_name"
                                    class="form-label fw-semibold">

                                    First Name

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="first_name"
                                    name="first_name"
                                    maxlength="50"
                                    value="<?= html_escape(
                                        set_value(
                                            'first_name',
                                            $user->teacher->first_name
                                        )
                                    ); ?>"
                                    required>

                            </div>


                            <!-- Last Name -->

                            <div class="col-md-6">

                                <label
                                    for="last_name"
                                    class="form-label fw-semibold">

                                    Last Name

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="last_name"
                                    name="last_name"
                                    maxlength="50"
                                    value="<?= html_escape(
                                        set_value(
                                            'last_name',
                                            $user->teacher->last_name
                                        )
                                    ); ?>">

                            </div>


                            <!-- Phone -->

                            <div class="col-md-6">

                                <label
                                    for="teacher_phone"
                                    class="form-label fw-semibold">

                                    Phone

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="teacher_phone"
                                    name="teacher_phone"
                                    maxlength="20"
                                    value="<?= html_escape(
                                        set_value(
                                            'teacher_phone',
                                            $user->teacher->phone
                                        )
                                    ); ?>">

                            </div>


                            <!-- Joining Date -->

                            <div class="col-md-6">

                                <label
                                    class="form-label fw-semibold">

                                    Joining Date

                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    value="<?= html_escape(
                                        $user->teacher->joining_date
                                    ); ?>"
                                    disabled>

                                <small class="text-muted">
                                    Joining date cannot be changed.
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>


            <!-- Actions -->

            <div
                class="d-flex justify-content-end gap-2 mb-5">

                <a
                    href="<?= site_url('/profile'); ?>"
                    class="btn btn-outline-success fw-semibold">

                    Cancel

                </a>


                <button
                    type="submit"
                    class="btn btn-success fw-semibold">

                    <i
                        class="bi bi-check-lg me-1">
                    </i>

                    Save Changes

                </button>

            </div>


        </form>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>