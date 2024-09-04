<?php
$id = $_POST['id'];
$query = "select * from subcategory where cat_id = $id ";
$result = mysqli_query($conn, $query);

$numRow = mysqli_num_rows($result);
$option = "<option>select sub cate</option>";
if ($numRow > 0) {
    while ($raw = mysqli_fetch_assoc($result)) {
        $option .= "<option value=" . $raw['sid'] . ">" . $raw['subcat_name'] . "</option>";
    }
}

echo $option;
