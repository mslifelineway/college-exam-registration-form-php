<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Application Form | Success</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="./css/style.css" />
</head>

<body>
	<main class="fluid-container">
		<header>
			<div class="container">
				<img src="./cdc_logo.png" alt="" />
			</div>
		</header>
		<div class="container">
			<div class="heading">
				<div class="row">
					<div class="col-12 successPage">
						<p><?php echo @$_GET['success']; ?></p>
					</div>
					<div class="col-2 trackApplication d-flex justify-content-between mx-auto">
						<small><a href="./index.php">Back</a></small>
						<small><a href="./login.php" class="text-danger">Login</a></small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 mx-auto my-5">
			<div class="error_modal">
				<div class="modal-content">
					<div class="modal-header alert-success text-success">
						<h5 class="modal-title">Success</h5>
					</div>
					<div class="modal-body">
						<p class="mb-0"><?php echo @$_GET['success']; ?></p>
					</div>
					<div class="modal-footer">
						<a href="index.php">
							<button type="button" class="btn ">Back</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</main>

	<?php
	include "component/footerScripts.php";
	?>
	<script src="./js/app.js"></script>
</body>

</html>