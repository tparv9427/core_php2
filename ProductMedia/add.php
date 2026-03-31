<?php
require_once '../Database.php';
require_once 'ProductMedia.php';

$db = (new Database)->connect();
$productMediaModel = new ProductMedia($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST[$productMediaModel->tableName]) && is_array($_POST[$productMediaModel->tableName])){
        foreach($_POST[$productMediaModel->tableName] as $key => $value){
            $productMediaModel->value($key,$value);
        }
    }

    if($productMediaModel->save()){
        header("Location: list.php?message=Saved Successfully");
        exit;
    } else {
        header("Location: list.php?message=Saved Successfully");
        exit;
    }
}

header("Location: form.php");
exit;
?>