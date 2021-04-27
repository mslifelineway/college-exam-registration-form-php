<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Application Form</title>
		<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet" />
		<link rel="stylesheet" href="./css/bootstrap.min.css" />
		<link rel="stylesheet" href="./css/style.css" />
		<link rel="stylesheet" href="./css/header.css" />
</head>

	<body>
		<main class="fluid-container">
			<?php
				include "component/head.php";
			?>

			<div class="container">
				<div class="col-6 mx-auto my-5">
					<div class="error_modal">
						<div class="modal-content">
							<div class="modal-header alert-warning text-warning">
								<h5 class="modal-title">Error</h5>
							</div>
							<div class="modal-body">
								<p class="mb-0"><?php echo @$_GET['suberror']; ?></p>
							</div>
							<div class="modal-footer">
								<a href="index.php">
									<button type="button" class="btn ">Backff</button>
								</a>
							</div>
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
