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
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/header.css" />
</head>

<body>
    <main class="fluid-container">
        <header>
            <div class="container">
                <div class="head">
                <div class="logo">
                    <img src="./cdc_logo.png" alt="CDC LOGO" />
                </div>
                <div class="app_status">
                    <a href="./actions//logout.php">
                        <button class="btn">Sign Out</button>
                    </a>
                </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="heading">
                <div class="row">
                    <div class="col-12">
                        <p>Applied Application Forms</p>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom: 30px">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="head mb-0"><?php echo @$_SESSION['name']; ?> </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p class="form-text text-muted mb-1"><b>ROLL NUMBER : </b><?php echo @$_SESSION['rollNumber']; ?></p>
                                    <p class="form-text text-muted mb-0"><b>MOBILE NUMBER : </b><?php echo @$_SESSION['mobileNumber']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-lg-none bg-info p-2 mb-2 rounded">
                <p class="m-0 text-info">Scroll horizontally to view all details</p>
            </div>
            <div class="table-responsive mb-2">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center text-md-left" scope="col">Application ID</th>
                            <th class="text-center text-md-left" scope="col">Acad. Year</th>
                            <th class="text-center text-md-left" scope="col">Acad. Sem</th>
                            <th class="text-center text-md-left" scope="col">Appearing As</th>
                            <th class="text-center text-md-left" scope="col">Theory Subjects</th>
                            <th class="text-center text-md-left" scope="col">Practical Subject</th>
                            <th class="text-center text-md-left" scope="col">Action</th>
                        </tr>
                    </thead>
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
                                if($index < 10) {
                                    $index = "0".$index;
                                }
                            ?>
                                <tbody>
                                    <tr>
                                        <td scope="row"><?php echo $index . ". " . @$r->application_id; ?></td>
                                        <td><?php echo @$r->year; ?></td>
                                        <td><?php echo @$r->semester; ?></td>
                                        <td><?php echo @$r->appearingAs; ?></td>
                                        <td><?php echo @$r->theory1 . ", " . @$r->theory2 . "," . @$r->theory3 . ", " . @$r->theory4 . ", " . @$r->theory5 . ", " . @$r->theory6; ?></td>
                                        <td><?php echo @$r->practical1 . ", " . @$r->practical2 . ", " . @$r->practical3 . ", " . @$r->practical4 . ", " . @$r->practical5 . ", " . @$r->practical6; ?></td>
                                        <td>
                                            <a href="./viewApplication.php?applicationId=<?php echo @$r->application_id; ?>" class="text-white">
                                                <button class="btn btn-primary text-uppercase">view</button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php
                            }
                        }
                    ?>
                </table>
                <?php
                    if ($fetch->rowCount() == 0) {
                        echo "<div class='bg-light p-3'><p class='m-0 font-weight-bold'>No such application found</p></div";
                    }
                ?>
            </div>
        </div>
    </main>
    <script src="./js/jquery.slim.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/app.js"></script>
</body>
</html>