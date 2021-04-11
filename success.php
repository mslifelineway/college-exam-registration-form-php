<!DOCTYPE html>
<html lang="en">
	<?php 
		include "component/headerLinks.php";
	?>

	<body>
		<main class="fluid-container">
			<header>
				<div class="container">
					<img src="./cdc_logo.png" alt="" />
				</div>
			</header>
			<div class="container">
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
			</div>
		</main>

		<?php 
			include "component/footerScripts.php";
		?>
	</body>
</html>
