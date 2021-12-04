<?php 
session_start();
$sessionid=$_GET["sessionid"];
$b=array("company_name"=>"","product_name"=>"","unit"=>"","packing_size"=>"","price"=>"0","qty"=>"0");
$_SESSION["cart"][$sessionid]=$b;
?>