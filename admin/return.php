<?php
include "../user/connection.php";
$id=$_GET["id"];
$bill_id="";
$product_company="";
$product_name="";
$product_unit="";
$packing_size="";
$price="";
$qty="";
$total=0;

$res=mysqli_query($link,"select * from billing_details where id=$id");
while($row=mysqli_fetch_array($res))
{
    $bill_id=$row["bill_id"];
    $product_company=$row["product_company"];
    $product_name=$row["product_name"];
    $product_unit=$row["product_unit"];
    $packing_size=$row["packing_size"];
    $price=$row["price"];
    $qty=$row["qty"];
    $total=$price * $qty;
}

//retrieving bill no from other table so we need a query to retrieve it
$bill_no="";
$res2=mysqli_query($link,"select * from billing_header where id=$bill_id");
while($row2=mysqli_fetch_array($res2))
{
    $bill_no=$row2["bill_no"];
}


$today_date=date('Y-m-d');

mysqli_query($link,"insert into return_products values(NULL,'$bill_no','$today_date','$product_company','$product_name','$product_unit','$packing_size','$price','$qty','$total')");


//to increase the stock quantity into the stock master table after returning(aka removing) it from the detailed bills
mysqli_query($link,"update stock_master set product_qty=product_qty+$qty where product_company='$product_company' && product_name='$product_name' && product_unit='$product_unit' && packing_size='$packing_size' ");


//delete query to delete the items from the detailed bills
mysqli_query($link,"delete from billing_details where id=$id");

?>


<script type="text/javascript">
    alert("Return of Product has been Recorded Successfully");
    window.location="view_bill_details.php?id=<?php echo $bill_id; ?>";
</script>