<?php

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];

    $checkQuery = "SELECT * from banner where bid = '$id'";
    $res = mysqli_query($conn, $checkQuery);
    $numRows = mysqli_num_rows($res);
    if ($numRows > 0) {
        $status = $_GET['status'];
        if ($status == 'Active') {
            $value = "Deactive";
        } else {
            $value = "Active";
        }

        $updateQuery = "UPDATE banner SET status='$value' where bid='$id'";
        mysqli_query($conn, $updateQuery);
        redirect('product');
    } else {
        redirect('product');
    }
}
$query = "select * from banner ORDER BY bid DESC";
$result = mysqli_query($conn, $query);



?>


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table</span> Banner</h4>

    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5 class="card-header text-start">All Banners</h5>
                </div>
                <div class="col text-end"><a href="banner-add" class="text-end btn btn-primary mt-3 btn-sm">Add Banner</a></div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Banner Name</th>
                            <th>File Name</th>

                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class=" table-border-bottom-0">

                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $i ?></strong></td>
                                <td><?= $row['banner_name'] ?></td>
                                <td><img src="public/upload/banner/<?php echo $row['banner_image'] ?>" width="80px" alt="<?= $row['banner_image'] ?>"></td>


                                <td colspan="2" class="text-center">
                                    <a class="btn btn-sm <?php echo $row['status'] == 'Active' ? 'btn-success' : 'btn-danger' ?>" href="banner&status=<?= $row['status'] ?>&id=<?= $row['bid'] ?>">
                                        <?= $row['status'] ?></a>
                                    <a class=" btn btn-primary btn-sm" href="banner-add&id=<?= $row['bid'] ?>">
                                        Edit</a>


                                </td>
                            </tr>
                        <?php
                            $i++;
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>