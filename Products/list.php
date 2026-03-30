<?php
require_once '../Database.php';
require_once 'Product.php';

$db = (new Database())->connect();
$productModel = new Product($db);

$sql = "SELECT * FROM $productModel->tableName ORDER BY $productModel->primaryKey DESC";
$products = $db->fetchAll($sql) ?: [];

include 'grid.php';
?>