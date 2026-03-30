<?php
require_once '../Database.php';
require_once 'Product.php';

$db = (new Database)->connect();
$productModel = new Product($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST[$productModel->tableName]) && is_array($_POST[$productModel->tableName])){
        foreach($_POST[$productModel->tableName] as $key=>$value){
            $productModel->value($key,$value);
        }   
    }

    if($productModel->save()){
        header("Location: list.php?message=Saved successfully");
        exit;
    } else {
        header("Location: form.php?error=Failed to save product.");
        exit;
    }
}
header("Location: form.php");
exit;
?>