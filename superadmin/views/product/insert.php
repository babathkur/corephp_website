<?php
$id = '';
$err = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];
    $checkQuery = "SELECT * from product where pid = '$id'";
    $result = mysqli_query($conn, $checkQuery);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $row = mysqli_fetch_assoc($result);
        $cat_name = $row['cat_id'];
        $subcat_name = $row['subcat_id'];
        $product_name = $row['product_name'];
        $product_short_name = $row['product_short_name'];
        $sku_code = $row['sku_code'];
        $mrp = $row['mrp'];
        $discount = $row['discount'];
        $price = $row['price'];
        $qty = $row['qty'];
        $gst = $row['gst'];
        $short_description = $row['short_description'];
        $long_decription = $row['long_decription'];
        $meta_title = $row['meta_title'];
        $meta_description = $row['meta_description'];
        $meta_keyword = $row['meta_keyword'];
        $file_name_edit = $row['file_name'];

        $form_title = "Update";
        $button = "Update";
    } else {
        redirect('product');
    }
} else {
    $cat_name = '';
    $subcat_name = '';
    $product_name = '';
    $product_short_name = '';
    $sku_code = '';
    $mrp = '';
    $discount = '';
    $price = '';
    $qty = '';
    $gst = '';
    $short_description = '';
    $long_decription = '';
    $meta_title = '';
    $meta_description = '';
    $meta_keyword = '';
    $form_title = "Add";
    $button = "Add";
}

if (isset($_POST['submit'])) {
    $cat_name = $_POST['cat_name'];
    $subcat_name = $_POST['subcat_name'];
    $product_name = $_POST['product_name'];
    $product_short_name = $_POST['product_short_name'];
    $sku_code = $_POST['sku_code'];
    if ($sku_code == '') {
        $sku_code = $product_name;
    }
    $mrp = $_POST['mrp'];
    $discount = $_POST['discount'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $gst = $_POST['gst'];
    $short_description = $_POST['short_description'];
    $long_decription = $_POST['long_decription'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");

    $file_name = $_FILES['file_name'];
    $imageName = $file_name['name'];

    // echo "<pre>";
    // print_r($file_name);
    // die;


    if ($id != '') {
        if ($imageName != '') {

            $imageTmpName = $file_name['tmp_name'];
            $imageType = $file_name['type'];
            $changeName = strtotime($created_at) . $imageName;
            move_uploaded_file($imageTmpName, "./public/upload/product/" . $changeName);
        } else {
            $changeName = $file_name_edit;
        }

        $query = "UPDATE  product SET cat_id='$cat_name' , subcat_id='$subcat_name',product_name='$product_name',product_short_name='$product_short_name',sku_code='$sku_code',mrp='$mrp',discount='$discount',price='$price',qty='$qty',gst='$gst',short_description='$short_description',long_decription='$long_decription',meta_title='$meta_title',meta_description='$meta_description',meta_keyword='$meta_keyword',updated_at='$updated_at',file_name='$changeName' where pid='$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            redirect('product');
        }
    } else {
        $checkQuery = "SELECT * from product where product_name = '$product_name'";
        $result = mysqli_query($conn, $checkQuery);
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            $err = "Product already exists";
        } else {
            $imageName = $file_name['name'];
            $imageTmpName = $file_name['tmp_name'];
            $imageType = $file_name['type'];
            $changeName = strtotime($created_at) . $imageName;
            move_uploaded_file($imageTmpName, "./public/upload/product/" . $changeName);
            $query = "INSERT INTO product 
            (cat_id,subcat_id, product_name,product_short_name,sku_code,mrp,discount,price,qty,gst,short_description,long_decription,meta_title,meta_description,meta_keyword,file_name,created_at)
             VALUES 
             ('$cat_name','$subcat_name','$product_name','$product_short_name','$sku_code','$mrp','$discount','$price','$qty','$gst','$short_description','$long_decription','$meta_title','$meta_description','$meta_keyword','$changeName','$created_at')";

            $result = mysqli_query($conn, $query);

            if ($result) {
                redirect('product');
            }
        }
    }
}

$category = mysqli_query($conn, "SELECT * from category");
$get_gst = mysqli_query($conn, "SELECT * from gst");
$subcategory = mysqli_query($conn, "select * from subcategory where cat_id = '$cat_name' ");

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product/</span> <?= $form_title ?></h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Product <?= $form_title ?></h5>
                </div>
                <div class="card-body">
                    <?php
                    if ($err != '') {
                    ?>
                        <div class="alert alert-primary w-25" role="alert">
                            <?= $err ?>
                        </div>
                    <?php
                    }
                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="cat_name">Category Name</label>

                                <select name="cat_name" id="cat_name" class="form-select" onchange="fetchSubCategory(this.value)">
                                    <option value="">select</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($category)) {
                                        $selected = $cat_name == $row['cat_id'] ? 'selected' : '';
                                    ?>
                                        <option <?= $selected ?> value="<?= $row['cat_id'] ?>"><?= $row['cat_name'] ?></option>
                                    <?php  }
                                    ?>
                                </select>
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="subcat_name">Sub Category Name</label>
                                <select name="subcat_name" id="subcat_name" class="form-select">
                                    <option value="">select</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($subcategory)) {
                                        $selected = $subcat_name == $row['sid'] ? 'selected' : '';
                                    ?>
                                        <option <?= $selected ?> value="<?= $row['sid'] ?>"><?= $row['subcat_name'] ?></option>
                                    <?php  }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name" value="<?= $product_name ?>" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="product_short_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_short_name" id="product_short_name" value="<?= $product_short_name ?>" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="sku_code">Sku code</label>
                                    <input type="text" class="form-control" name="sku_code" id="sku_code" value="<?= $sku_code ?>" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="mrp">Mrp</label>
                                    <input type="number" class="form-control" name="mrp" id="mrp" value="<?= $mrp ?>" onchange="discountCalculate()" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="discount">Discount (%)</label>
                                    <input type="number" class="form-control" name="discount" id="discount" value="<?= !empty($discount) ? $discount : 0 ?>" onchange="discountCalculate()" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="price">Price</label>
                                    <input type="number" class="form-control" name="price" id="price" readonly value="<?= $price ?>" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="qty">Qty</label>
                                    <input type="text" class="form-control" name="qty" id="qty" value="<?= $qty ?>" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="cat_name">GST</label>

                                <select name="gst" id="gst" class="form-select">
                                    <option value="">Select GST</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($get_gst)) {
                                        $selected = $gst == $row['id'] ? 'selected' : '';
                                    ?>
                                        <option <?= $selected ?> value="<?= $row['id'] ?>"><?= $row['gst_name'] ?></option>
                                    <?php  }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="short_description">Short Description</label>
                                    <input type="text" class="form-control" name="short_description" id="short_description" value="<?= $short_description ?>" placeholder="" />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="file_name">Image</label>
                                    <input type="file" class="form-control" name="file_name" id="file_name" value="" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="long_decription">Long Decription</label>
                                    <input type="text" class="form-control" name="long_decription" id="long_decription" value="<?= $long_decription ?>" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" id="meta_title" value="<?= $meta_title ?>" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta_description">Meta Description</label>
                                    <input type="text" class="form-control" name="meta_description" id="meta_description" value="<?= $meta_description ?>" placeholder="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta_keyword">Meta Keyword</label>
                                    <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" value="<?= $meta_keyword ?>" placeholder="" />
                                </div>
                            </div>

                        </div>
                        <div>

                            <img src="public/upload/product/<?= $file_name_edit ?>" width="100px">
                        </div>


                        <button type="submit" name="submit" class="btn btn-primary"><?= $button ?> Product</button>
                        <a href="product" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>