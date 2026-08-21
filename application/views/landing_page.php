<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>College Management System</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
	<style>
		.hero-section {
			background: linear-gradient(135deg, #198754 0%, #7af88f 100%);
			color: white;
			padding: 100px 0;
		}

		.feature-card {
			border: none;
			transition: transform 0.2s ease-in-out;
		}

		.feature-card:hover {
			transform: translateY(-5px);
		}

		.feature-icon {
			font-size: 2.5rem;
			color: #278a30;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow sticky-top">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center fw-bold text-success" href="<?= base_url(); ?>">
				<i class="bi bi-book fs-2 me-2"></i> College Management System
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<a href="<?= site_url('auth/login'); ?>" class="btn btn-success fw-bold ms-auto">Get Started</a>
			</div>
		</div>
	</nav>

	<section class="hero-section text-center text-lg-start">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<h1 class="display-4 fw-bold mb-3">College Management Made Simple & Efficient</h1>
					<p class="lead mb-4">Streamline Student, Teacher and Department Management</p>
					<div class="d-flex flex-column flex-sm-row gap-3 mb-5">
						<a href="<?= site_url('auth/login'); ?>" class="btn btn-light btn-lg text-success fw-semibold">
							Access Portal <i class="bi bi-arrow-right ms-1"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-6 text-center">
					<img src="<?= base_url('application/assets/landing-page/landing-page-image.jpeg'); ?>"
						alt="Student Management System" class="img-fluid rounded-3 shadow-lg">
				</div>
			</div>
		</div>
	</section>

	<section id="features" class="py-3 my-5 bg-light">
		<div class="container py-4">
			<div class="text-center mb-5">
				<h2 class="fw-bold text-success">Key Modules</h2>
				<p class="text-muted">Everything you need to manage in a college day-to-day.</p>
			</div>
			<div class="row g-4">

				<div class="col-md-4">
					<div class="card feature-card h-100 shadow-sm p-4 text-center">
						<div class="mb-3">
							<i class="bi bi-people-fill feature-icon"></i>
						</div>
						<h5 class="fw-bold">Student Management</h5>
						<p class="text-muted">Register for courses and edit your profile</p>
					</div>
				</div>

				<div class="col-md-4">
					<div class="card feature-card h-100 shadow-sm p-4 text-center">
						<div class="mb-3">
							<i class="bi bi-person-badge-fill feature-icon"></i>
						</div>
						<h5 class="fw-bold">Teacher Management</h5>
						<p class="text-muted">Organize teacher profiles, departments and subjects</p>
					</div>
				</div>

				<div class="col-md-4">
					<div class="card feature-card h-100 shadow-sm p-4 text-center">
						<div class="mb-3">
							<i class="bi bi-calendar-check-fill feature-icon"></i>
						</div>
						<h5 class="fw-bold">Get Personalized Reports</h5>
						<p class="text-muted">Every report you could possibly need, just a few clicks away</p>
					</div>
				</div>

			</div>
		</div>
	</section>

	<footer class="bg-success text-white py-4 border-top">
		<div class="container text-center">
			<p class="mb-0 text-white">&copy; <?= date('Y'); ?> College Management System. All rights reserved.</p>
		</div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>