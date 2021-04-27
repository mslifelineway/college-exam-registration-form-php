<?php
    include "./database/DbConnection.php";
    session_start();
    $rollNumber = @$_SESSION['rollNumber'];
    if (!$rollNumber || $rollNumber === "") {
        header("Location: ./error.php?error=Access Denied! Please login.");
    }

    $applicationId = @$_GET['applicationId'];
    if (!$applicationId || $applicationId === "") {
        header("Location: ./error.php?error=Access Denied! Something went wrong.");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Application Details | <?php echo $applicationId; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/header.css" />
</head>
<style>
    form > div {
        padding: 0 !important;
        padding-bottom: 28px !important;
    }
    form .grid-container {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        gap: 0;
    }
</style>
<body>
    <main class="fluid-container">
        <header class="d-print-none">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="logo">
                    <img src="./cdc_logo.png" alt="" />
                </div>
                <div class="app_status">
                    <a href="./actions//logout.php">
                        <button class="btn"> Sign out</button>
                    </a>
                </div>
            </div>
        </header>
        <div class="container">

            <?php
                //Now fetch all the applied application forms
                $fetch = $conn->prepare("SELECT * FROM registrationforms WHERE application_id=:apkId and rollNumber=:rno");
                $fetch->bindParam(':apkId', $applicationId);
                $fetch->bindParam(':rno', $rollNumber);
                $fetch->setFetchMode(PDO::FETCH_OBJ);
                $fetch->execute();
                if ($fetch->rowCount() > 0) {
                    while ($r = $fetch->fetch()) {
            ?>
                        <div class="heading">
                            <div class="row">
                                <div class="col-12">
                                    <p>Registration Number - <b><?php echo $applicationId; ?></b></p>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-print-none">
                                            <a href="./trackApplications.php"><button class="btn btn-light">Back</button></a>
                                        </div>
                                        <div class="d-print-none">
                                            <button class="btn btn-primary" onClick="window.print()">Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form>
                            <!-- Start Admission NO. -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">1. College</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3 mb-md-3 m-lg-0">
                                                    <small class="form-text text-muted mb-1">Collage Code</small>
                                                    <input type="text" class="form-control" value="<?php echo $r->collegeCode; ?>" disabled />
                                                </div>
                                                <div class="col-md-6 mb-0">
                                                    <small class="form-text text-muted mb-1">Roll Number</small>
                                                    <input type="text" class="form-control text-uppercase" name="rollNumber" value="<?php echo @$r->rollNumber; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Admission NO. -->

                            <!-- Start Name -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header d-md-flex">
                                            <h2 class="head">2. Name</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-12 col-md-4 mb-3 mb-md-3 m-lg-0">
                                                    <small class="form-text text-muted mb-1">Student Name</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->name; ?>" disabled />
                                                </div>
                                                <div class="form-group col-12 col-md-4 mb-3 mb-md-3 m-lg-0">
                                                    <small class="form-text text-muted mb-1">Father's Name</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->fatherName; ?>" disabled />

                                                </div>
                                                <div class="form-group col-12 col-md-4 mb-0">
                                                    <small class="form-text text-muted mb-1">Mother's Name</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->motherName; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Name -->

                            <!-- Start Photo -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header d-md-flex">
                                            <h2 class="head">3. Photo</h2>
                                        </div>
                                        <div class="card-body"">
                                            <img src="data:image/<?php echo @$image_type; ?>;base64,<?php echo base64_encode(@$r->image); ?>" alt="Image" class="userImage" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Photo -->

                            <!-- Start Courses -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">3. Courses</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-0 disabled">
                                                    <small class="form-text text-muted mb-1">Course</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->course; ?>" disabled />
                                                </div>
                                                <div class="form-group col-md-6 mb-0">
                                                    <small class="form-text text-muted mb-1">Combination</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->branch; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Courses -->

                            <!-- Start Gender -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">4. Gender</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col mb-0">
                                                    <div class="d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="<?php echo @$r->gender; ?>" checked disabled/>
                                                            <label class="form-check-label" for="maleRadios" checked> <?php echo @$r->gender; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Gender -->

                            <!-- Start Social Status -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">5. Social State</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" checked disabled />
                                                <label class="form-check-label" for="gridRadios3"> <?php echo @$r->socialState; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Social Status -->

                            <!-- Start Address -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">6. Address</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-12 mb-3">
                                                    <small class="form-text text-muted mb-1">House No.</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->houseNumber; ?>" disabled />
                                                </div>
                                                <div class="form-group col-12 mb-3">
                                                    <small class="form-text text-muted mb-1">ٍStreet</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->street; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-md-0 md-3">
                                                    <small class="form-text text-muted mb-1">City/District</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->city; ?>" disabled />
                                                </div>
                                                <div class="form-group col-md-4 mb-md-0 md-3">
                                                    <small class="form-text text-muted mb-1">State</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->state; ?>" disabled />
                                                </div>
                                                <div class="form-group col-md-4 mb-0">
                                                    <small class="form-text text-muted mb-1">Zip / Pin Code</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->zip; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Address -->

                            <!-- Start Contact -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">7. Contact</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-md-0 mb-3">
                                                    <small class="form-text text-muted mb-1">Email Address</small>
                                                    <input type="text" class="form-control" value="<?php echo @$r->email; ?>" disabled />
                                                </div>
                                                <div class="col-md-6 mb-0">
                                                    <small class="form-text text-muted mb-1">Mobile Number</small>
                                                    <input class="form-control" type="text" value="<?php echo @$r->mobileNumber; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Contact -->

                            <!-- Start DOB -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">8. Date of Birth</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col mb-md-0 mb-0">
                                                    <small class="form-text text-muted mb-1">Date Of Birth</small>
                                                    <input type="text" class="form-control" id="dob" name="dob" required value="<?php echo @$r->dob; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End DOB -->

                            <!-- Start Appearing -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">9. Appearing</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="appearing-container d-flex justify-content-around">
                                                <div class="year">
                                                    <div class="yearDesc">
                                                        <small class="form-text text-muted mb-1">Year of Appearing</small>
                                                    </div>
                                                    <div class="yearRatio">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="<?php echo @$r->year; ?>" checked disabled />
                                                            <label class="form-check-label" for="yearRadio1"><?php echo @$r->year; ?></label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="semester">
                                                    <div class="semDesc">
                                                        <small id="dob" class="form-text text-muted mb-1">Semester of Appearing</small>
                                                    </div>
                                                    <div class="semRatio">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="<?php echo @$r->semester; ?>" checked disabled />
                                                            <label class="form-check-label" for="semRadio1"><?php echo @$r->semester; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="appearing">
                                                    <div class="appDesc">
                                                        <small id="dob" class="form-text text-muted mb-1">Appearing As</small>
                                                    </div>
                                                    <div class="appRatio">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="<?php echo @$r->appearingAs; ?>" checked disabled/>
                                                            <label class="form-check-label" for="appRadio1"><?php echo @$r->appearingAs; ?></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Appearing -->

                            <!-- Start Subject -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="head">10. Subjects</h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="theory">
                                                <small class="form-text text-muted mb-1"> Theory </small>
                                                <div class="row">
                                                    <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                        <input type="text" class="form-control" value="<?php echo @$r->theory1; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                        <input type="text" class="form-control" value="<?php echo @$r->theory2; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                        <input type="text" class="form-control" value="<?php echo @$r->theory3; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2">
                                                        <input type="text" class="form-control" value="<?php echo @$r->theory4; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2">
                                                        <input type="text" class="form-control" value="<?php echo @$r->theory5; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2">
                                                        <input type="text" class="form-control" value="<?php echo @$r->theory6; ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="practical mt-3">
                                                <small class="form-text text-muted mb-1">Practical</small>
                                                <div class="row">
                                                    <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                        <input type="text" class="form-control" value="<?php echo @$r->practical1; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                        <input type="text" class="form-control" value="<?php echo @$r->practical2; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                        <input type="text" class="form-control" value="<?php echo @$r->practical3; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2">
                                                        <input type="text" class="form-control"  value="<?php echo @$r->practical4; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2">
                                                        <input type="text" class="form-control" value="<?php echo @$r->practical5; ?>" disabled />
                                                    </div>
                                                    <div class="col-4 col-md-2">
                                                        <input type="text" class="form-control" value="<?php echo @$r->practical6; ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
            <?php
                    }
                }
            ?>
        </div>
    </main>
    <script src="./js/jquery.slim.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>