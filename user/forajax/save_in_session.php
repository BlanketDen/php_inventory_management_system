<?php
session_start();
include "../../user/connection.php";
$company_name=$_GET["company_name"];
$product_name=$_GET["product_name"];
$unit=$_GET["unit"];
$packing_size=$_GET["packing_size"];
$price=$_GET["price"];
$qty=$_GET["qty"];
$total=$_GET["total"];



//primary code which are gonna be using the functions
if(isset($_SESSION['cart']))
{
//items that are found in the session array
    $max=sizeof($_SESSION['cart']);
    $check_available=0;
    $check_available=check_duplicate_product($company_name,$product_name,$unit,$packing_size);
    $available_qty=0;
    $check_the_qty=0;

    //to check if the product is a duplicate
    if($check_available==0)
    {
        $available_qty=check_qty($company_name,$product_name,$unit,$packing_size,$link);
        if($available_qty>=$qty)
        {
            $b=array("company_name"=>$company_name,"product_name"=>$product_name,"unit"=>$unit,"packing_size"=>$packing_size,"price"=>$price,"qty"=>$qty);
            array_push($_SESSION['cart'],$b);
        }
        else{
            echo "The Entered Quantity is not available!";
        }
    }
    else
    {
        $av_qty=0;
        $exist_qty=0;
        $exist_qty=check_the_qty($company_name,$product_name,$unit,$packing_size);
        $exist_qty=$exist_qty+$qty;
        $av_qty=check_qty($company_name,$product_name,$unit,$packing_size,$link);
        if($av_qty>=$exist_qty)
        {
            $check_product_no_session=check_product_no_session($company_name,$product_name,$unit,$packing_size);
            $b=array("company_name"=>$company_name,"product_name"=>$product_name,"unit"=>$unit,"packing_size"=>$packing_size,"price"=>$price,"qty"=>$exist_qty);
            $_SESSION['cart'][$check_product_no_session]=$b;
        }
        else
        {
            echo "The Entered Quantity is not Available";
        }

    }



}
//for any products that are not availble in the cart
else{
    $available_qty=check_qty($company_name,$product_name,$unit,$packing_size,$link);
    if($available_qty>=$qty)
    {
//if its available then this line should save it in the session array
        $_SESSION['cart']=array(array("company_name"=>$company_name,"product_name"=>$product_name,"unit"=>$unit,"packing_size"=>$packing_size,"price"=>$price,"qty"=>$qty));
    }
    else
    {
        echo "The Entered Quantity is not Available";
    }

}



function check_qty($product_company,$product_name,$product_unit,$packing_size,$link)
{

    $product_qty=0;
    $res=mysqli_query($link,"select * from stock_master where product_company='$product_company' && product_name='$product_name' && product_unit='$product_unit' && packing_size='$packing_size'");
    while($row=mysqli_fetch_array($res))
    {
        $product_qty=$row["product_qty"];
    }

    return $product_qty;

}

//second Function duplicate product is in session or not
function check_duplicate_product($product_company,$product_name,$product_unit,$packing_size)
{
    $found=0;
    $max=sizeof($_SESSION['cart']);
    for($i=0;$i<$max;$i++)
    {

        if(isset($_SESSION['cart'][$i]))
        {
            $company_name_session="";
            $product_name_session="";
            $unit_session="";
            $packing_size_session="";

            foreach($_SESSION['cart'][$i] as $key => $val)
            {
                if($key=="company_name")
                {
                    $company_name_session=$val;
                }
                else if($key=="product_name")
                {
                    $product_name_session=$val;
                }
                else if($key=="unit")
                {
                    $unit_session=$val;
                }
                else if($key=="packing_size")
                {
                    $packing_size_session=$val;
                }
            }
            //function to compare if it passes
            if($company_name_session==$product_company && $product_name_session==$product_name && $unit_session==$product_unit && $packing_size_session==$packing_size)
            {
                $found=$found+1;
            }

        }

    }

    return $found;

}

//load the product quantity from the session array
function check_the_qty($product_company,$product_name,$product_unit,$packing_size)
{
    $qty_found=0;
    $qty_session=0;
    $max=sizeof($_SESSION['cart']);
    for($i=0;$i<$max;$i++)
    {
        $company_name_session="";
        $product_name_session="";
        $unit_session="";
        $packing_size_session="";

        if(isset($_SESSION['cart'][$i]))
        {
            
            foreach($_SESSION['cart'][$i] as $key => $val)
            {
                if($key=="company_name")
                {
                    $company_name_session=$val;
                }
                else if($key=="product_name")
                {
                    $product_name_session=$val;
                }
                else if($key=="unit")
                {
                    $unit_session=$val;
                }
                else if($key=="packing_size")
                {
                    $packing_size_session=$val;
                }
                else if($key=="qty")
                {
                    $qty_session=$val;
                }
            }
            //function to compare if it passes
            if($company_name_session==$product_company && $product_name_session==$product_name && $unit_session==$product_unit && $packing_size_session==$packing_size)
            {
                $qty_found=$qty_session;
            }

        }

    }

    return $qty_found;
}

//last function to update the quantity if the same item is added again
function check_product_no_session($product_company,$product_name,$product_unit,$packing_size)
{
    $recordno=0;
    $max=sizeof($_SESSION['cart']);
    for($i=0;$i<$max;$i++)
    {

        if(isset($_SESSION['cart'][$i]))
        {
            $company_name_session="";
            $product_name_session="";
            $unit_session="";
            $packing_size_session="";

            foreach($_SESSION['cart'][$i] as $key => $val)
            {
                if($key=="company_name")
                {
                    $company_name_session=$val;
                }
                else if($key=="product_name")
                {
                    $product_name_session=$val;
                }
                else if($key=="unit")
                {
                    $unit_session=$val;
                }
                else if($key=="packing_size")
                {
                    $packing_size_session=$val;
                }
            }
            //function to compare if it passes
            if($company_name_session==$product_company && $product_name_session==$product_name && $unit_session==$product_unit && $packing_size_session==$packing_size)
            {
                $recordno=$i;
            }

        }

    }

    return $recordno;
}
?>