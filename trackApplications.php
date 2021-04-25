<?php
include "./database/DbConnection.php";
session_start();
$rollNumber = @$_SESSION['rollNumber'];
if (!$rollNumber || $rollNumber === "") {
    header("Location: ./error.php?error=Access Denied! Please login.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Applied Application Forms</title>
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
                    <div class="col-12">
                        <p>Applied Application Forms</p>
                    </div>
                    <div class="col-12 trackApplication d-flex justify-content-between">
                        <small><a href="./index.php">Back</a></small>
                        <small><a href="./actions//logout.php" class="text-danger">Logout</a></small>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 30px">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="head"><?php echo @$_SESSION['name']; ?> </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3 mb-md-3 m-lg-0">
                                    <small class="form-text text-muted mb-1"><b>ROLL NUMBER : </b><?php echo @$_SESSION['rollNumber']; ?></small>
                                    <small class="form-text text-muted mb-1"><b>MOBILE NUMBER : </b><?php echo @$_SESSION['mobileNumber']; ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            //Now fetch all the applied application forms
            $fetch = $conn->prepare("SELECT * FROM registrationforms WHERE rollNumber=:rno");
            $fetch->bindParam(':rno', $rollNumber);
            $fetch->setFetchMode(PDO::FETCH_OBJ);
            $fetch->execute();
            $index = 0;
            if ($fetch->rowCount() > 0) {
                while ($r = $fetch->fetch()) {
                    $index += 1;

            ?>
                    <div class="row" style="margin-bottom: 30px">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="head d-flex justify-content-between"><?php echo $index . ". " . @$r->application_id; ?> <small><a href="./viewApplication.php?applicationId=<?php echo @$r->application_id; ?>" class="text-success">VIEW</a></small></h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3 mb-md-3 m-lg-0">
                                            <small class="form-text text-muted mb-1"><b>YEAR</b></small>
                                            <small class="form-text text-muted mb-1"><?php echo @$r->year; ?></small>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-md-3 m-lg-0">
                                            <small class="form-text text-muted mb-1"><b>SEMESTER</b></small>
                                            <small class="form-text text-muted mb-1"><?php echo @$r->semester; ?></small>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-md-3 m-lg-0">
                                            <small class="form-text text-muted mb-1"><b>APPEARING AS</b></small>
                                            <small class="form-text text-muted mb-1"><?php echo @$r->appearingAs; ?></small>
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
    <script src="./js/app.js"></script>
</body>

</html>