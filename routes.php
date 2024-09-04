<?php
require 'helper/connection.php';
require 'helper/function.php';

include('include/header.php');
// print_r($_GET);

if ($_GET['module'] == 'home')
    include_once('views/home.php');

else
    echo "No Route Found";


if ($_GET['module'] != 'login')
    include('include/footer.php');
