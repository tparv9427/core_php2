<?php
require_once '../Database.php';
require_once 'ProductMedia.php';
require_once '../Products/Product.php';


$db = (new Database)->connect();
$productMediaModel = new ProductMedia($db);
$productModel = new ProductMedia($db);

$query = "SELECT m.*,p.name AS product_name FROM {$productMediaModel->tableName} m LEFT JOIN {$productModel->tableName} p on m.{$productModel->primaryKey} = p.{$productModel->primaryKey} ORDER BY {$productMediaModel->primaryKey} DESC";
$product_medias = $db->fetchAll($query)?:[];
include 'grid.php';
?>