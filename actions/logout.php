<?php

session_start();
session_destroy();
header("Location:../../index.php?message=You have logged out!");
