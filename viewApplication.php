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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css" />
    <style>
        .userImage {
            max-width: 150px;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <main class="fluid-container">
        <header>
            <div class="container">
                <img src="./cdc_logo.png" alt="" />
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
                            <div class="col-12 trackApplication d-flex justify-content-between">
                                <small><a href="./trackApplications.php">Back</a></small>
                                <small><a href="./actions//logout.php" class="text-danger">Logout</a></small>
                            </div>
                        </div>
                    </div>
                    <div class="needs-validation">
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
                                                <input type="text" maxlength="3" id="collageId" class="form-control" value="<?php echo $r->collegeCode; ?>" readonly />
                                            </div>
                                            <div class="col-md-6 mb-0">
                                                <small class="form-text text-muted mb-1">Roll Number</small>
                                                <input id="rollNumber" type="text" class="form-control text-uppercase" name="rollNumber" value="<?php echo @$r->rollNumber; ?>" readonly />
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
                                        <small class="text-muted"> ( As per the qualifying examination certificate ) </small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-12 col-md-4 mb-3 mb-md-3 m-lg-0">
                                                <small class="form-text text-muted mb-1">Student Name</small>
                                                <input oninput="validateStudentName()" type="text" class="form-control text-uppercase" id="studentName" maxlength="25" name="studentName" required value="<?php echo @$r->name; ?>" readonly />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-12 col-md-4 mb-3 mb-md-3 m-lg-0">
                                                <small class="form-text text-muted mb-1">Father's Name</small>
                                                <input oninput="validateFathertName()" type="text" class="form-control text-uppercase" id="fatherName" name="fatherName" required value="<?php echo @$r->fatherName; ?>" readonly />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-12 col-md-4 mb-0">
                                                <small class="form-text text-muted mb-1">Mother's Name (Optional)</small>
                                                <input type="text" class="form-control text-uppercase" id="motherName" name="motherName" value="<?php echo @$r->motherName; ?>" readonly />
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
                                        <small class="text-muted"> ( File type .jpeg or .jpg , File size < 1MB ) </small>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 20px;">
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
                                            <div class="form-group col-md-6 mb-0">
                                                <small class="form-text text-muted mb-1">Combination</small>
                                                <select id="inputCombination" name="inputCombination" class="form-control" required>
                                                    <option value="<?php echo @$r->branch; ?>"><?php echo @$r->branch; ?>.</option>
                                                </select>
                                                <div class="invalid-feedback"></div>
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
                                                        <input class="form-check-input" type="radio" name="gender" id="maleRadios" value="<?php echo @$r->gender; ?>" checked />
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
                                        <ul id="social_state" class="grid-container">
                                            <li class="form-check">
                                                <input onchange="radioState()" class="form-check-input" type="radio" name="socialState" id="gridRadios3" value="<?php echo @$r->gender; ?>" checked />
                                                <label class="form-check-label" for="gridRadios3"> <?php echo @$r->socialState; ?></label>
                                            </li>
                                        </ul>
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
                                                <input type="text" class="form-control" name="address_one" id="address_one" value="<?php echo @$r->houseNumber; ?>" readonly />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-12 mb-3">
                                                <small class="form-text text-muted mb-1">ٍStreet</small>
                                                <input type="text" class="form-control" name="address_two" id="address_two" value="<?php echo @$r->street; ?>" readonly />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4 mb-md-0 md-3">
                                                <small class="form-text text-muted mb-1">City/District</small>
                                                <input type="text" class="form-control" id="city" name="city" value="<?php echo @$r->city; ?>" readonly />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-md-4 mb-md-0 md-3">
                                                <small class="form-text text-muted mb-1">State</small>
                                                <input type="text" class="form-control" id="state" name="state" value="<?php echo @$r->state; ?>" readonly />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-md-4 mb-0">
                                                <small class="form-text text-muted mb-1">Zip / Pin Code</small>
                                                <input type="text" class="form-control" id="pinCode" name="pinCode" value="<?php echo @$r->zip; ?>" readonly />
                                                <div class="invalid-feedback"></div>
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
                                                <input id="email" name="email" type="text" class="form-control" value="<?php echo @$r->email; ?>" readonly />
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-md-6 mb-0">
                                                <small class="form-text text-muted mb-1">Mobile Number ( Without Country Code )</small>
                                                <input class="form-control" type="text" value="<?php echo @$r->mobileNumber; ?>" readonly />
                                                <div class="invalid-feedback"></div>
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
                                                <small class="form-text text-muted mb-1">DOB Format ( Month/Day/Year )</small>
                                                <input type="text" class="form-control" id="dob" name="dob" required value="<?php echo @$r->dob; ?>" readonly />
                                                <div class="invalid-feedback"></div>
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
                                                        <input class="form-check-input" type="radio" name="yearofAppearing" id="yearRadio1" value="<?php echo @$r->year; ?>" checked />
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
                                                        <input class="form-check-input" type="radio" name="semofAppearing" id="semRadio1" value="<?php echo @$r->semester; ?>" checked />
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
                                                        <input class="form-check-input" type="radio" name="appearingAs" id="appRadio1" value="<?php echo @$r->appearingAs; ?>" checked />
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
                                                    <input type="text" class="form-control" id="theoryOne" name="theoryOne" maxlength="3" value="<?php echo @$r->theory1; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                    <input type="text" class="form-control" id="theoryTwo" name="theoryTwo" maxlength="3" value="<?php echo @$r->theory2; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                    <input type="text" class="form-control" id="theoryThree" name="theoryThree" maxlength="3" value="<?php echo @$r->theory3; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2">
                                                    <input type="text" class="form-control" id="theoryFour" name="theoryFour" maxlength="3" value="<?php echo @$r->theory4; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2">
                                                    <input type="text" class="form-control" id="theoryFive" name="theoryFive" maxlength="3" value="<?php echo @$r->theory5; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2">
                                                    <input type="text" class="form-control" id="theorySix" name="theorySix" maxlength="3" value="<?php echo @$r->theory6; ?>" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="practical mt-3">
                                            <small class="form-text text-muted mb-1">Practical</small>
                                            <div class="row">
                                                <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                    <input type="text" class="form-control" id="practicalOne" name="practicalOne" maxlength="3" value="<?php echo @$r->practical1; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                    <input type="text" class="form-control" id="practicalTwo" name="practicalTwo" maxlength="3" value="<?php echo @$r->practical2; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2 mb-3 mb-md-0">
                                                    <input type="text" class="form-control" id="practicalThree" name="practicalThree" maxlength="3" value="<?php echo @$r->practical3; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2">
                                                    <input type="text" class="form-control" id="practicalFour" name="practicalFour" maxlength="3" value="<?php echo @$r->practical4; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2">
                                                    <input type="text" class="form-control" id="practicalFive" name="practicalFive" maxlength="3" value="<?php echo @$r->practical5; ?>" readonly />
                                                </div>
                                                <div class="col-4 col-md-2">
                                                    <input type="text" class="form-control" id="practicalSix" name="practicalSix" maxlength="3" value="<?php echo @$r->practical6; ?>" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                }
            }
            ?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>