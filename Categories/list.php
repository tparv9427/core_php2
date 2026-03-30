<?php
require_once '../Database.php';
require_once 'Category.php';

$db = (new Database())->connect();
$categoryModel = new Category($db);

$sql = "SELECT * FROM $categoryModel->tableName ORDER BY $categoryModel->primaryKey DESC";
$products = $db->fetchAll($sql) ?: [];

include 'grid.php';
?>