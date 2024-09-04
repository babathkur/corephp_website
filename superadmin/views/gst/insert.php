<?php
$id = '';
$err = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];
    $checkQuery = "SELECT * from gst where id = '$id'";
    $result = mysqli_query($conn, $checkQuery);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $row = mysqli_fetch_assoc($result);
        $gst_name = $row['gst_name'];
        $gst_per = $row['gst_per'];
        $form_title = "Update";
        $button = "Update";
    } else {
        redirect('gst');
    }
} else {
    $gst_name = '';
    $gst_per = '';
    $form_title = "Add";
    $button = "Add";
}

if (isset($_POST['submit'])) {
    $gst_name = $_POST['gst_name'];
    $gst_per = $_POST['gst_per'];

    // $created_at = date('Y-m-d H:i:s');
    if ($id != '') {
        $query = "UPDATE  gst SET gst_name='$gst_name',gst_per='$gst_per' where id='$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            redirect('gst');
        }
    } else {
        $checkQuery = "SELECT * from gst where gst_per = '$gst_per'";
        $result = mysqli_query($conn, $checkQuery);
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            $err = "GST % already exists";
        } else {
            $query = "INSERT INTO gst(gst_name,gst_per) VALUES('$gst_name','$gst_per')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                redirect('gst');
            }
        }
    }
}

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">GST/</span> <?= $form_title ?></h4>

    <!-- Basic Layout -->
    <div class="row">


        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">GST <?= $form_title ?></h5>
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
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="gst_name">GST Name</label>
                                        <input type="text" class="form-control" name="gst_name" id="gst_name" value="<?= $gst_name ?>" placeholder=" Enter GST Name" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="gst_per">GST [%]</label>
                                        <input type="text" class="form-control" name="gst_per" id="gst_per" value="<?= $gst_per ?>" placeholder=" Enter GST percentage" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary"><?= $button ?> GST</button>
                        <a href="gst" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>