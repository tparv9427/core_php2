<?php
require_once '../Database.php';
require_once 'Customers.php';

$db = (new Database)->connect();
$addModel = new Customers($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST[$addModel->tableName]) && is_array($_POST[$addModel->tableName])){
        foreach($_POST[$addModel->tableName] as $key => $value){
            $addModel->value($key,$value);
        }
    }

    if($addModel->save()){
        header("Location: list.php?message=Customer added successfully");
        exit;
    } else {
        header("Location: list.php?message=Customer added successfully");
        exit;            
    }
}
header("Location: form.php");
exit;
?>