<?php
$id = '';
$err = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];
    $checkQuery = "SELECT * from category where cat_id = '$id'";
    $result = mysqli_query($conn, $checkQuery);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $row = mysqli_fetch_assoc($result);
        $cat_name = $row['cat_name'];
        $form_title = "Update";
        $button = "Update";
    } else {
        redirect('category');
    }
} else {
    $cat_name = '';
    $form_title = "Add";
    $button = "Add";
}

if (isset($_POST['submit'])) {
    $cat_name = $_POST['cat_name'];
    $created_at = date('Y-m-d H:i:s');
    if ($id != '') {
        $query = "UPDATE  category SET cat_name='$cat_name' where cat_id='$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            redirect('category');
        }
    } else {
        $checkQuery = "SELECT * from category where cat_name = '$cat_name'";
        $result = mysqli_query($conn, $checkQuery);
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            $err = "Category already exists";
        } else {
            $query = "INSERT INTO category(cat_name,created_at) VALUES('$cat_name','$created_at')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                redirect('category');
            }
        }
    }
}

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Category/</span> <?= $form_title ?></h4>

    <!-- Basic Layout -->
    <div class="row">


        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Category <?= $form_title ?></h5>
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
                        <div class="mb-3">
                            <label class="form-label" for="cat_name">Category Name</label>
                            <input type="text" class="form-control" name="cat_name" id="cat_name" value="<?= $cat_name ?>" placeholder=" Enter Category Name" />
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary"><?= $button ?> Category</button>
                        <a href="category" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>