document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const departmentSelect = document.querySelector('select[name="department_id"]');
    const tableBody = document.querySelector('table tbody');
    const modalContent = document.getElementById('modalTeacherContent');

    let searchTimeout;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(function() {
                searchTeachers();
            }, 300);
        });
    }

    if (departmentSelect) {
        departmentSelect.addEventListener('change', function() {
            searchTeachers();
        });
    }

    function searchTeachers() {
        const search = searchInput ? searchInput.value.trim() : '';
        const departmentId = departmentSelect ? departmentSelect.value : '';

        const url = `${teacherSearchUrl}?search=${encodeURIComponent(search)}&department_id=${encodeURIComponent(departmentId)}`;

        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                </td>
            </tr>
        `;

        fetch(url)
            .then(response => response.json())
            .then(response => {
                if (response.status === 'success') {
                    renderTeachers(response.data);
                } else {
                    showNoTeachers();
                }
            })
            .catch(() => {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-5 text-danger">
                            Failed to load teachers.
                        </td>
                    </tr>
                `;
            });
    }

    function renderTeachers(teachers) {
        if (!teachers.length) {
            showNoTeachers();
            return;
        }

        tableBody.innerHTML = '';

        teachers.forEach(teacher => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="ps-4 fw-bold text-dark">
                    <i class="bi bi-person-circle text-success me-2"></i>
                    ${teacher.name}
                </td>

                <td>
                    <span class="badge bg-secondary-subtle text-secondary border">
                        ${teacher.employee_code}
                    </span>
                </td>

                <td>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        ${teacher.department_name || 'Not Assigned'}
                    </span>
                </td>

                <td>
                    ${teacher.email}
                </td>

                <td>
                    ${teacher.joining_date
                        ? new Date(teacher.joining_date).toLocaleDateString('en-IN', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        })
                        : 'N/A'}
                </td>

                <td>
                    ${teacher.status === 'active'
                        ? '<span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>'
                        : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactive</span>'}
                </td>

                <td class="text-end pe-4">
                    <button
                        class="btn btn-sm btn-outline-success me-1 btn-view-teacher fw-semibold"
                        data-id="${teacher.id}"
                        data-bs-toggle="modal"
                        data-bs-target="#viewTeacherModal">
                        View
                    </button>

                    ${teacherEditUrl
                        ? `<a href="${teacherEditUrl}${teacher.id}" class="btn btn-sm btn-success fw-semibold">Edit</a>`
                        : ''}
                </td>
            `;

            tableBody.appendChild(row);
        });
    }

    function showNoTeachers() {
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                    No teacher profiles found.
                </td>
            </tr>
        `;
    }

    document.addEventListener('click', function(event) {
        const button = event.target.closest('.btn-view-teacher');

        if (!button || !modalContent) {
            return;
        }

        const id = button.getAttribute('data-id');

        modalContent.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-success" role="status"></div>
            </div>
        `;

        fetch(`${teacherViewUrl}${id}`)
            .then(response => response.json())
            .then(response => {
                if (response.status === 'success') {
                    const teacher = response.data;

                    modalContent.innerHTML = `
                        <div class="text-center mb-3">
                            <div class="rounded-circle bg-success-subtle text-success d-inline-flex p-3 mb-2">
                                <i class="bi bi-person-badge fs-1"></i>
                            </div>

                            <h4 class="fw-bold mb-0">
                                ${teacher.name}
                            </h4>

                            <span class="badge bg-success-subtle text-success mt-1">
                                ${teacher.department_name || 'Department Not Assigned'}
                            </span>
                        </div>

                        <ul class="list-group list-group-flush border-top border-bottom my-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Employee Code:</strong>
                                <span>${teacher.employee_code || 'N/A'}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Email:</strong>
                                <span>${teacher.email || 'N/A'}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Phone:</strong>
                                <span>${teacher.phone || 'N/A'}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Status:</strong>
                                <span>${teacher.status}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Department:</strong>
                                <span>${teacher.department_name || 'N/A'}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Department Code:</strong>
                                <span>${teacher.department_code || 'N/A'}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Joining Date:</strong>
                                <span>
                                    ${teacher.joining_date
                                        ? new Date(teacher.joining_date).toLocaleDateString('en-IN', {
                                            day: '2-digit',
                                            month: 'short',
                                            year: 'numeric'
                                        })
                                        : 'N/A'}
                                </span>
                            </li>
                        </ul>
                    `;
                } else {
                    modalContent.innerHTML = `
                        <div class="alert alert-danger mb-0">
                            ${response.message}
                        </div>
                    `;
                }
            })
            .catch(() => {
                modalContent.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        Unable to load teacher information.
                    </div>
                `;
            });
    });
});