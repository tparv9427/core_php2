<?php
require_once '../Database.php';
require_once 'ProductMedia.php';

$db = (new Database())->connect();
$productMediaModel = new ProductMedia($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST[$productMediaModel->primaryKey]) && !empty($_POST[$productMediaModel->primaryKey])) {
        $productMediaModel->load($_POST[$productMediaModel->primaryKey]);
    }
    
    if(isset($_POST[$productMediaModel->tableName]) && is_array($_POST[$productMediaModel->tableName])) {
        foreach($_POST[$productMediaModel->tableName] as $key => $value){
            $productMediaModel->value($key,$value);
        }
    }
    if(isset($_POST[$productMediaModel->primaryKey]) && !empty($_POST[$productMediaModel->primaryKey])) {
        $productMediaModel->data[$_POST[$productMediaModel->primaryKey]] = $_POST[$productMediaModel->primaryKey];
    }

    if($productMediaModel->save()){
        header("Location: list.php?message=Media updated successfully");
        exit;
    } else {
        header("Location: form.php?id=" . ($_POST['product_media_id'] ?? '') . "&error=Failed to update product media.");
        exit;
    }
}

$id = $_GET['id'] ?? '';
header("Location: form.php?id=$id");
exit;
?>
