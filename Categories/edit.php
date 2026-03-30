<?php
require_once '../Database.php';
require_once 'Category.php';

$db = (new Database())->connect();
$editModel = new Category($db);

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
        header("Location: form.php?id=" . ($_POST[$editModel->primaryKey] ?? '') . "&error=Failed to save category.");
        exit;
    }
}

$id = $_GET['id'] ?? '';
header("Location: form.php?id=$id");
exit;
?>