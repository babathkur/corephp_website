<?php
$id = '';
$err = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];
    $checkQuery = "SELECT * from subcategory where sid = '$id'";
    $result = mysqli_query($conn, $checkQuery);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $row = mysqli_fetch_assoc($result);
        $cat_name = $row['cat_id'];
        $subcat_name = $row['subcat_name'];
        $form_title = "Update";
        $button = "Update";
    } else {
        redirect('subcategory');
    }
} else {
    $cat_name = '';
    $subcat_name = '';
    $form_title = "Add";
    $button = "Add";
}

if (isset($_POST['submit'])) {
    $cat_name = $_POST['cat_name'];
    $subcat_name = $_POST['subcat_name'];
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");


    if ($id != '') {
        $query = "UPDATE  subcategory SET cat_id='$cat_name' , subcat_name='$subcat_name',updated_at='$updated_at' where sid='$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            redirect('subcategory');
        }
    } else {
        $checkQuery = "SELECT * from subcategory where cat_id = '$cat_name' AND subcat_name = '$subcat_name'";
        $result = mysqli_query($conn, $checkQuery);
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            $err = "Sub Category already exists";
        } else {
            $query = "INSERT INTO subcategory (cat_id,subcat_name,created_at) VALUES ('$cat_name','$subcat_name','$created_at')";

            $result = mysqli_query($conn, $query);

            if ($result) {
                redirect('subcategory');
            }
        }
    }
}

$category = mysqli_query($conn, "SELECT * from category");

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sub Category/</span> <?= $form_title ?></h4>

    <!-- Basic Layout -->
    <div class="row">


        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sub Category <?= $form_title ?></h5>
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
                    <form method="post">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="cat_name">Category Name</label>

                                <select name="cat_name" id="cat_name" class="form-select">
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
                                <div class="mb-3">
                                    <label class="form-label" for="subcat_name">Sub Category Name</label>
                                    <input type="text" class="form-control" name="subcat_name" id="subcat_name" value="<?= $subcat_name ?>" placeholder=" Enter Sub Category Name" />
                                </div>
                            </div>
                        </div>


                        <button type="submit" name="submit" class="btn btn-primary"><?= $button ?> Sub Category</button>
                        <a href="subcategory" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>