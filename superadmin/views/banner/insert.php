<?php
$id = '';
$err = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];
    $checkQuery = "SELECT * from banner where bid = '$id'";
    $result = mysqli_query($conn, $checkQuery);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $row = mysqli_fetch_assoc($result);
        $banner_name = $row['banner_name'];
        $file_name_edit = $row['banner_image'];

        $form_title = "Update";
        $button = "Update";
    } else {
        redirect('product');
    }
} else {
    $banner_name = '';
    $form_title = "Add";
    $button = "Add";
}

if (isset($_POST['submit'])) {
    $banner_name = $_POST['banner_name'];
    $file_name = $_FILES['banner_image'];
    $imageName = $file_name['name'];
    $created_at = date('Y-m-d H:i:s');

    // echo "<pre>";
    // print_r($file_name);
    // die;


    if ($id != '') {
        if ($imageName != '') {

            $imageTmpName = $file_name['tmp_name'];
            $imageType = $file_name['type'];
            $changeName = strtotime($created_at) . $imageName;
            move_uploaded_file($imageTmpName, "./public/upload/banner/" . $changeName);
        } else {
            $changeName = $file_name_edit;
        }

        $query = "UPDATE  banner SET banner_name='$banner_name',banner_image='$changeName' where bid='$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            redirect('banner');
        }
    } else {

        $imageName = $file_name['name'];
        $imageTmpName = $file_name['tmp_name'];
        $imageType = $file_name['type'];
        $changeName = strtotime($created_at) . $imageName;
        move_uploaded_file($imageTmpName, "./public/upload/banner/" . $changeName);
        $query = "INSERT INTO banner (banner_name,banner_image) VALUES ('$banner_name','$changeName')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            redirect('banner');
        }
    }
}

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Banner/</span> <?= $form_title ?></h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Banner <?= $form_title ?></h5>
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
                                <div class="mb-3">
                                    <label class="form-label" for="banner_name">Banner Name</label>
                                    <input type="text" class="form-control" name="banner_name" id="banner_name" value="<?= $banner_name ?>" placeholder="" />
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="banner_image">Image</label>
                                    <input type="file" class="form-control" name="banner_image" id="file_name" value="" placeholder="" />
                                </div>
                            </div>


                        </div>
                        <div>

                            <img src="public/upload/banner/<?= $file_name_edit ?>" width="100px">
                        </div>


                        <button type="submit" name="submit" class="btn btn-primary"><?= $button ?> Banner</button>
                        <a href="banner" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>