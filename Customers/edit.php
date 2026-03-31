<?php
require_once '../Database.php';
require_once 'Customer.php';

$db = (new Database)->connect();
$editModel = new Customers($db);

if($_SERVER['REQUEST_METHOD'] === 'POST' ){
    if(isset($_POST[$editModel->primaryKey]) && !empty($_POST[$editModel->primaryKey])){
        $editModel->load($_POST[$editModel->primaryKey]);
    }

    if(isset($_POST[$editModel->tableName]) && is_array($_POST[$editModel->tableName])){
        foreach($_POST[$editModel->tableName] as $key => $value){
            $editModel->value($key,$value);
        }
    }

    if(isset($_POST[$editModel->primaryKey]) && !empty($_POST[$editModel->primaryKey])){
        $editModel->data[$editModel->primaryKey] = $_POST[$editModel->primaryKey];
    }

    if($editModel->save()){
        header("Location: list.php?message=Saved successfully");
        exit;
        } else {
        header("Location: form.php?". ($_POST[$editModel->primaryKey] ?? "") ."&error=Failed to save customer");
        exit;
    }

$id = $_GET['id'];
header("Location: from.php?id={$id}");
exit;
}
?>