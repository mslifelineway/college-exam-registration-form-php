<?php
include "../database/DbConnection.php";
session_start();
if (isset($_POST['submit'])) {
    $rollNumber    = $_POST['rollNumber'];
    $mobileNumber    = $_POST['mobileNo'];

    //student login
    $slogin = $conn->prepare("SELECT * FROM students WHERE rollNumber=:rno AND mobileNumber=:mno");
    $slogin->bindParam(":rno", $rollNumber);
    $slogin->bindParam(":mno", $mobileNumber);
    $slogin->setFetchMode(PDO::FETCH_OBJ);
    $slogin->execute();

    if ($slogin->rowCount() > 0) {

        while ($r = $slogin->fetch()) {

            $_SESSION['id'] = $r->id;
            $_SESSION['name'] = $r->name;
            $_SESSION['mobileNumber'] = $r->mobileNumber;
            $_SESSION['rollNumber'] = $r->rollNumber;
        }

        header("Location: ../trackApplications.php");
    } else {
        header("Location: ../success.php?success=You have entered wrong credentials! <br> Please make sure your credentials are registered in college record!");
    }
} else {
    header("Location: ../error.php?error=Invalid Action!");
}
