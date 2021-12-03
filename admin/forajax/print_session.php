<?php

session_start();

$max=0;

if (isset($_SESSION['cart'])) {
    //unset($_SESSION['cart']); // <- Yang Ni, Uncomment bila nak guna je. And after clear comment balik
    $max = count($_SESSION['cart']);
}

for ($i = 0; $i < $max; $i++) {
    if (isset($_SESSION['cart'][$i])) {
        $company_name = $_SESSION['cart'][$i]['company_name'] ?? '';
        $product_name = $_SESSION['cart'][$i]['product_name'] ?? '';
        $unit = $_SESSION['cart'][$i]['unit'] ?? '';
        $packing_size = $_SESSION['cart'][$i]['packing_size'] ?? '';
        $qty = $_SESSION['cart'][$i]['qty'] ?? '';

        echo $company_name . " " . $product_name . " " . $unit . " " . $packing_size . " " . $qty;
        echo "<br>";
    }
}
?>