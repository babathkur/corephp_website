<?php
require '../helper/connection.php';
require '../helper/function.php';

if ($_GET['module'] == 'subcategory-fetch')
    include_once('views/ajax/subcategory_ajax.php');
else
    echo "NO ajax found";
