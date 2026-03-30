<?php
require_once '../Database.php';
require_once 'Product.php';

$db = (new Database())->connect();
$editModel = new Product($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST[$editModel->primaryKey]) && !empty($_POST[$editModel->primaryKey])) {
        $editModel->load($_POST[$editModel->primaryKey]);
    }

    if(isset($_POST[$editModel->primaryKey]) && is_array($_POST[$editModel->primaryKey])){
        foreach($_POST[$editModel->primaryKey] as $key => $value){
            $productModel->value($key,$value);
        }
    }
    if(isset($_POST[$editModel->primaryKey]) && !empty($_POST[$editModel->primaryKey])){
        $editModel->data[$editModel->primaryKey] = $_POST[$editModel->primaryKey];
    }

    if($editModel->save()){
        header("Location: list.php?message=Updated successfully");
        exit;
    } else {
        header("Location: form.php?id=" . ($_POST['product_id'] ?? '') . "&error=Failed to save product.");
        exit;
    }
}

$id = $_GET['id'] ?? '';
header("Location: form.php?id=$id");
exit;
?>