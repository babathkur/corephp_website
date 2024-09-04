<?php
require '../helper/connection.php';
require '../helper/function.php';
if ($_GET['module'] != 'login') {
    include('include/header.php');
}
// print_r($_GET);

if ($_GET['module'] == 'dashboard')
    include_once('views/dashboard.php');

//route for category  ---------------------------------
elseif ($_GET['module'] == 'category')
    include_once('views/category/select.php');
elseif ($_GET['module'] == 'category-add')
    include_once('views/category/insert.php');

//route for sub category  ---------------------------------
elseif ($_GET['module'] == 'subcategory')
    include_once('views/subcategory/select.php');
elseif ($_GET['module'] == 'subcategory-add')
    include_once('views/subcategory/insert.php');

//route for gst ---------------------------------
elseif ($_GET['module'] == 'gst')
    include_once('views/gst/select.php');
elseif ($_GET['module'] == 'gst-add')
    include_once('views/gst/insert.php');

//route for product ---------------------------------
elseif ($_GET['module'] == 'product')
    include_once('views/product/select.php');
elseif ($_GET['module'] == 'product-add')
    include_once('views/product/insert.php');


//route for banner ---------------------------------
elseif ($_GET['module'] == 'banner')
    include_once('views/banner/select.php');
elseif ($_GET['module'] == 'banner-add')
    include_once('views/banner/insert.php');

elseif ($_GET['module'] == 'form')
    include_once('views/form.php');

//route for login and logout ---------------------------------
elseif ($_GET['module'] == 'login')
    include_once('views/login.php');
elseif ($_GET['module'] == 'logout')
    include_once('views/logout.php');
else
    echo "No Route Found";


if ($_GET['module'] != 'login')
    include('include/footer.php');
