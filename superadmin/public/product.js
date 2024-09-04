function fetchSubCategory(cat_id) {
    // let subcat_id = id;

    $.ajax({
        url: "ajax.php?module=subcategory-fetch",
        method: "POST",
        data: { id: cat_id },
        success: function (response) {
            console.log(response);
            document.querySelector("#subcat_name").innerHTML = response;
        }
    });
}

function discountCalculate() {

    let mrp = parseFloat(document.querySelector('#mrp').value);
    let discount = parseFloat(document.querySelector('#discount').value);
    let price = document.querySelector('#price').value;
    let calculation = (mrp * discount) / 100;
    let priceCalculate = mrp - calculation;
    document.querySelector('#price').value = Math.round(priceCalculate);
    console.log(calculation);
}