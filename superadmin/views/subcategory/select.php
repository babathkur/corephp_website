<?php

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];

    $checkQuery = "SELECT * from subcategory where sid = '$id'";
    $res = mysqli_query($conn, $checkQuery);
    $numRows = mysqli_num_rows($res);
    if ($numRows > 0) {
        $status = $_GET['status'];
        if ($status == 'Active') {
            $value = "Deactive";
        } else {
            $value = "Active";
        }

        $updateQuery = "UPDATE subcategory SET status='$value' where sid='$id'";
        mysqli_query($conn, $updateQuery);
        redirect('subcategory');
    } else {
        redirect('subcategory');
    }
}
$query = "select subcategory.* ,category.cat_name from subcategory INNER JOIN category ON category.cat_id=subcategory.cat_id";
$result = mysqli_query($conn, $query);



?>


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">All</span> Sub Categories</h4>

    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5 class="card-header text-start">All Category</h5>
                </div>
                <div class="col text-end"><a href="subcategory-add" class="text-end btn btn-primary mt-3 btn-sm">Add Sub Category</a></div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
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
                                <td><?= $row['cat_name'] ?></td>
                                <td><?= $row['subcat_name'] ?></td>

                                <td colspan="2" class="text-center">
                                    <a class="btn btn-sm <?php echo $row['status'] == 'Active' ? 'btn-success' : 'btn-danger' ?>" href="subcategory&status=<?= $row['status'] ?>&id=<?= $row['sid'] ?>">
                                        <?= $row['status'] ?></a>
                                    <a class=" btn btn-primary btn-sm" href="subcategory-add&id=<?= $row['sid'] ?>">
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