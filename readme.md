# College Management System

A role-based **College Management System** built with **PHP, CodeIgniter 3, MySQL, Bootstrap 5, and JavaScript**. The system provides separate functionality and access levels for Principals, HODs, Teachers, and Students.

## Features

### Authentication & Authorization

* User authentication and session management
* Role-based access control
* Four user roles:

  * Principal
  * HOD
  * Teacher
  * Student
* Restricted access to modules based on user role
* Active/inactive account status management

### Dashboard

The dashboard dynamically displays modules based on the logged-in user's role.

| Module                | Principal | HOD | Teacher | Student |
| --------------------- | :-------: | :-: | :-----: | :-----: |
| Teacher Management    |     ✓     |  ✓  |    -    |    -    |
| Student Management    |     ✓     |  ✓  |    ✓    |    -    |
| Course Management     |     ✓     |  ✓  |    ✓    |    ✓    |
| Subject Management    |     -     |  -  |    -    |    ✓    |
| Attendance Management |     -     |  -  |    ✓    |    ✓    |
| Audit Logs            |     ✓     |  -  |    -    |    -    |

### Teacher Management

* View teacher profiles
* Search teachers
* Filter teachers by department
* Edit teacher information
* Manage teacher account status
* Department-based teacher organization
* Principal-only teacher editing

### Student Management

* View student profiles
* Search students
* Filter students by course
* Edit student information
* Manage student account status
* Department-based access for teachers
* Principal and HOD access to all students
* Teachers can only access students belonging to their department

### Course Management

* View courses
* Manage course information
* Associate courses with departments
* Define course duration

### Subject Management

* View subjects
* Associate subjects with courses
* Store semester and credit information

### Attendance Management

* Mark student attendance
* View attendance records
* Track attendance by student and subject
* Prevent duplicate attendance records for the same student, subject, and date

### Audit Logging

The system maintains audit logs for important operations.

Logged information includes:

* User who performed the action
* Action performed
* Affected table
* Record ID
* Previous values
* New values
* Description
* IP address
* User agent
* Timestamp

## Role-Based Access

### Principal

The Principal has the highest level of access.

* Manage teachers
* Manage students
* Manage courses
* Manage subjects
* Manage attendance
* View audit logs
* Access all departments and students

### HOD

The HOD has administrative access to academic data.

* View and manage teachers
* View and manage students
* Manage courses
* Access students across departments
* Access academic information

### Teacher

Teachers have department-level access.

* View students belonging to their department
* Modify student information where permitted
* Manage attendance
* View courses
* Access relevant academic information

A teacher's department is determined through the relationship:

```text
Teacher
   ↓
teachers.department_id
   ↓
Department
   ↓
Courses
   ↓
Students
```

Therefore, a teacher assigned to the Computer Science department can access students enrolled in Computer Science courses but cannot access students from Electronics or Civil courses.

### Student

Students have restricted access to their academic information.

* View courses
* View enrolled subjects
* View attendance
* View personal profile

## Database Structure

The system uses MySQL with the following primary entities:

```text
roles
  │
  └── users
       ├── teachers
       │     └── departments
       │
       └── students
             └── courses
                   └── departments
                         └── subjects

students
   └── student_attendance
          └── subjects

teachers
   └── teacher_subjects
          └── subjects

users
   └── audit_logs
```

### Main Tables

| Table                | Purpose                                    |
| -------------------- | ------------------------------------------ |
| `roles`              | Stores system roles                        |
| `users`              | Stores authentication and user information |
| `departments`        | Stores college departments                 |
| `courses`            | Stores courses offered by departments      |
| `teachers`           | Stores teacher profiles                    |
| `students`           | Stores student profiles                    |
| `subjects`           | Stores course subjects                     |
| `teacher_subjects`   | Maps teachers to subjects                  |
| `student_attendance` | Stores attendance records                  |
| `audit_logs`         | Stores system activity and changes         |

## Technology Stack

### Backend

* PHP
* CodeIgniter 3
* MySQL

### Frontend

* HTML5
* CSS3
* Bootstrap 5
* Bootstrap Icons
* JavaScript

### Architecture

The application follows the **Model-View-Controller (MVC)** architecture provided by CodeIgniter 3.

```text
Request
   ↓
Controller
   ↓
Model
   ↓
MySQL Database
   ↓
Model
   ↓
Controller
   ↓
View
```

## Project Structure

```text
application/
├── controllers/
│   ├── Auth.php
│   ├── Dashboard.php
│   ├── Students.php
│   ├── Teachers.php
│   ├── Courses.php
│   ├── Subjects.php
│   ├── Attendance.php
│   └── Audit.php
├── models/
│   ├── User_model.php
│   ├── Student_model.php
│   ├── Teacher_model.php
│   ├── Course_model.php
│   ├── Subject_model.php
│   ├── Attendance_model.php
│   └── Audit_model.php
├── views/
│   ├── auth/
│   ├── dashboard/
│   ├── students/
│   ├── teachers/
│   ├── courses/
│   ├── subjects/
│   ├── attendance/
│   └── audit/
└── config/
```

## Installation

### Requirements

* PHP 7.4+
* MySQL 8.0+
* Apache or another PHP-compatible web server
* CodeIgniter 3

### 1. Clone the Repository

```bash
git clone https://github.com/ArvindJayan/College-Management-System.git
cd College-Management-System
```

### 2. Create the Database

Create the database in MySQL:

```sql
CREATE DATABASE cms_db;
```

Import the database schema provided in the project.

### 3. Configure Database Connection

Update the CodeIgniter database configuration:

```text
application/config/database.php
```

Configure:

```php
'hostname' => 'localhost',
'username' => 'your_username',
'password' => 'your_password',
'database' => 'cms_db',
'dbdriver' => 'mysqli'
```

### 4. Configure Base URL

Update:

```text
application/config/config.php
```

Set the application's base URL:

```php
$config['base_url'] = 'http://localhost/College-Management-System/';
```

### 5. Start the Application

Place the project inside your web server directory and access:

```text
http://localhost/College-Management-System/
```

## Database Relationships

### Departments and Courses

A department can have multiple courses.

```text
departments
     │
     └── courses
```

### Courses and Students

Each student belongs to a course.

```text
courses
     │
     └── students
```

### Courses and Subjects

Each course can contain multiple subjects.

```text
courses
     │
     └── subjects
```

### Teachers and Departments

Each teacher belongs to a department.

```text
departments
     │
     └── teachers
```

### Teachers and Subjects

Teachers can be assigned to subjects through the `teacher_subjects` relationship table.

```text
teachers
     │
     └── teacher_subjects
             │
             └── subjects
```

### Students and Attendance

Attendance records connect students with subjects.

```text
students
     │
     └── student_attendance
             │
             └── subjects
```

## Security

The application implements several security mechanisms:

* Session-based authentication
* Role-based authorization
* Form validation
* Input filtering
* Database foreign-key constraints
* Password hashing
* Account status checks
* Restricted department-level access
* Audit logging
* Unique constraints to prevent duplicate records
* Transaction-based updates for related database changes

## Audit Logging

Important changes are recorded in `audit_logs`.

For example, updating a student's profile can record:

```json
{
  "student_code": {
    "old": "CMS26CS001",
    "new": "CMS26CS101"
  },
  "course_id": {
    "old": 2,
    "new": 3
  }
}
```

The system records only the fields that actually changed, keeping the audit history concise and useful.

## Attendance Integrity

The attendance table prevents duplicate attendance records using:

```sql
UNIQUE KEY uq_student_subject_date
(student_id, subject_id, attendance_date)
```

This ensures that the same student cannot have multiple attendance records for the same subject on the same date.

## UI

The dashboard uses Bootstrap 5 with a responsive card-based interface.

The available modules are dynamically displayed according to the user's role, providing a different experience for administrators, faculty, and students.

## Future Improvements

Potential future enhancements include:

* Timetable management
* Examination management
* Grade management
* Assignment management
* Notifications
* Student result reports
* Faculty workload management
* Course enrollment management
* Attendance percentage calculation
* Pagination for large datasets
* REST API integration
* Email notifications
* Advanced reporting and analytics

## License

This project is intended for educational and development purposes.
