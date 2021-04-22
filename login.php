<!DOCTYPE html>
<html>
	<?php 
		include "component/headerLinks.php";
	?>

	<body>
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
					<div class="card card-signin my-5">
						<div class="card-header">
							<h5 class="card-title text-center mb-0">Sign In</h5>
						</div>
						<div class="card-body p-0">
							<form action="#" method="" id="formSignInApp" class="form-signin" class="needs-validation" novalidate>
								<div class="form-label-group p-3">
									<label for="rollNumber">Roll Number</label>
									<input
										type="text"
										oninput="validateRollNumber()"
										id="rollNumber"
										class="form-control"
										placeholder="Enter Roll Number"
										maxlength="7"
										required
										autofocus
									/>
									<div class="invalid-feedback"></div>
								</div>
								<div class="form-label-group p-3">
									<label for="mobileNo">Mobile Number</label>
									<input
										oninput="validateMobile()"
										id="mobileNo"
										class="form-control"
										type="text"
										maxlength="10"
										inputmode="tel"
										placeholder="Enter Mobile Number"
										required
										autofocus
									/>
									<div class="invalid-feedback"></div>
								</div>
								<div class="my-3 px-3">
									<button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
			include "component/footerScripts.php";
		?>
		<script src="./js/signIn.js"></script>
	</body>
</html>
