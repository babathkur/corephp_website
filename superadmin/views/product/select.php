<?php

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];

    $checkQuery = "SELECT * from product where pid = '$id'";
    $res = mysqli_query($conn, $checkQuery);
    $numRows = mysqli_num_rows($res);
    if ($numRows > 0) {
        $status = $_GET['status'];
        if ($status == 'Active') {
            $value = "Deactive";
        } else {
            $value = "Active";
        }

        $updateQuery = "UPDATE product SET status='$value' where pid='$id'";
        mysqli_query($conn, $updateQuery);
        redirect('product');
    } else {
        redirect('product');
    }
}
$query = "select product.* ,category.cat_name,subcategory.subcat_name,gst.gst_name from product
 INNER JOIN 
 category ON category.cat_id=product.cat_id
  INNER JOIN 
 subcategory ON subcategory.sid=product.subcat_id
  INNER JOIN 
 gst ON gst.id=product.gst
 ORDER BY product.product_name ASC";
$result = mysqli_query($conn, $query);



?>


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table</span> Products</h4>

    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5 class="card-header text-start">All Products</h5>
                </div>
                <div class="col text-end"><a href="product-add" class="text-end btn btn-primary mt-3 btn-sm">Add Product</a></div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
                            <th>Product Name</th>
                            <th>Product Short Name</th>
                            <th>Sku </th>
                            <th>Mrp</th>
                            <th>Discount</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>GST</th>
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
                                <td><?= $row['cat_name'] ?></td>
                                <td><?= $row['subcat_name'] ?></td>
                                <td><?= $row['product_name'] ?></td>
                                <td><?= $row['product_short_name'] ?></td>
                                <td><?= $row['sku_code'] ?></td>
                                <td><?= $row['mrp'] ?></td>
                                <td><?= $row['discount'] ?></td>
                                <td><?= $row['price'] ?></td>
                                <td><?= $row['qty'] ?></td>
                                <td><?= $row['gst_name'] ?></td>
                                <td><img src="public/upload/product/<?php echo $row['file_name'] ?>" width="80px" alt="<?= $row['product_name'] ?>"></td>


                                <td colspan="2" class="text-center">
                                    <a class="btn btn-sm <?php echo $row['status'] == 'Active' ? 'btn-success' : 'btn-danger' ?>" href="product&status=<?= $row['status'] ?>&id=<?= $row['pid'] ?>">
                                        <?= $row['status'] ?></a>
                                    <a class=" btn btn-primary btn-sm" href="product-add&id=<?= $row['pid'] ?>">
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