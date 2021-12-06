<?php 
session_start();
if(!isset($_SESSION["admin"]))
{
    ?>
    <script type="text/javascript">
        window.location="index.php";
    </script>
    <?php
}
?>
<?php
include "header.php";
include "../user/connection.php";
?>


<!--main-container-part-->
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>
                Returned Product List</a></div>
    </div>
    <!--End-breadcrumbs-->

    <!--Action boxes-->
    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
            <table class="table table-bordered">
                <tr>
                    <th>Bill No:</th>
                    <th>Date Returned</th>
                    <th>Product Company</th>
                    <th>Product Name</th>
                    <th>Product Unit</th>
                    <th>Packing Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php
                $res=mysqli_query($link,"select * from return_products order by id asc");
                while($row=mysqli_fetch_array($res))
                {
                    echo "<tr>";
                    echo "<td style='text-align:center;'>"; echo $row["bill_no"]; echo "</td>";
                    echo "<td style='text-align:center;'>"; echo $row["return_date"]; echo "</td>";
                    echo "<td style='text-align:center;'>"; echo $row["product_company"]; echo "</td>";
                    echo "<td style='text-align:center;'>"; echo $row["product_name"]; echo "</td>";
                    echo "<td style='text-align:center;'>"; echo $row["product_unit"]; echo "</td>";
                    echo "<td style='text-align:center;'>"; echo $row["packing_size"]; echo "</td>";
                    echo "<td style='text-align:center;'>"; echo $row["product_price"]; echo "</td>";
                    echo "<td style='text-align:center;'>"; echo $row["product_qty"]; echo "</td>";
                    echo "<td style='text-align:center;'>"; echo $row["total"]; echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

    </div>
</div>

<!--end-main-container-part-->

<?php
include "footer.php";
?>

