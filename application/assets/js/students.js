document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const tableBody = document.querySelector('table tbody');
    const modalContent = document.getElementById('modalstudentContent');

    let searchTimeout;

    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);

            const search = this.value.trim();

            searchTimeout = setTimeout(function() {
                searchStudents(search);
            }, 300);
        });
    }

    function searchStudents(search) {
        const url = `${studentSearchUrl}?search=${encodeURIComponent(search)}`;

        tableBody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                </td>
            </tr>
        `;

        fetch(url)
            .then(response => response.json())
            .then(response => {
                if (response.status === 'success') {
                    renderStudents(response.data);
                } else {
                    showNoStudents();
                }
            })
            .catch(() => {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-5 text-danger">
                            Failed to load students.
                        </td>
                    </tr>
                `;
            });
    }

    function renderStudents(students) {
        if (!students.length) {
            showNoStudents();
            return;
        }

        tableBody.innerHTML = '';

        students.forEach(student => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="ps-4 fw-bold text-dark">
                    <i class="bi bi-person-square text-success me-2"></i>
                    ${student.name}
                </td>
                <td>${student.student_code}</td>
                <td>${student.email}</td>
                <td>
                    <span class="badge bg-secondary-subtle text-dark border">
                        ${student.course_name}
                    </span>
                </td>
                <td>${student.phone}</td>
                <td>
                    <span class="badge bg-secondary-subtle text-dark border">
                        ${student.gender}
                    </span>
                </td>
                <td>
                    ${student.status === 'active'
                        ? '<span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>'
                        : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactive</span>'
                    }
                </td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-outline-success me-1 btn-view-student fw-semibold"
                        data-id="${student.id}"
                        data-bs-toggle="modal"
                        data-bs-target="#viewstudentModal">
                        View
                    </button>
                    <a href="${studentEditUrl}${student.id}"
                        class="btn btn-sm btn-success fw-semibold">
                        Edit
                    </a>
                </td>
            `;

            tableBody.appendChild(row);
        });
    }

    function showNoStudents() {
        tableBody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                    No student records found.
                </td>
            </tr>
        `;
    }

    document.addEventListener('click', function(event) {
        const button = event.target.closest('.btn-view-student');

        if (!button || !modalContent) {
            return;
        }

        const id = button.getAttribute('data-id');

        modalContent.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-success" role="status"></div>
            </div>
        `;

        fetch(`${studentViewUrl}${id}`)
            .then(response => response.json())
            .then(response => {
                if (response.status === 'success') {
                    const student = response.data;

                    modalContent.innerHTML = `
                        <div class="text-center mb-3">
                            <div class="rounded-circle bg-success-subtle text-success d-inline-flex p-3 mb-2">
                                <i class="bi bi-person fs-1"></i>
                            </div>
                            <h4 class="fw-bold mb-0">${student.name}</h4>
                            <span class="text-muted small">${student.email}</span>
                        </div>
                        <ul class="list-group list-group-flush border-top border-bottom my-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Student Code:</strong>
                                <span>${student.student_code}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Course:</strong>
                                <span>${student.course_name}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Course Code:</strong>
                                <span>${student.course_code}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Phone:</strong>
                                <span>${student.phone}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Gender:</strong>
                                <span>${student.gender}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Status:</strong>
                                <span>${student.status}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Date of Birth:</strong>
                                <span>${student.dob}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Admission Date:</strong>
                                <span>${student.admission_date}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Registered Since:</strong>
                                <span>${student.registered_since}</span>
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
                        Failed to load student details.
                    </div>
                `;
            });
    });
});