<?php
require_once '../Database.php';
require_once 'CustomerGroups.php';

$db = (new Database())->connect();
$addModel = new CustomerGroups($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST[$addModel->tableName]) && is_array($_POST[$addModel->tableName])){
        foreach($_POST[$addModel->tableName] as $key => $value){
            $addModel->value($key,$value);
        }
    }

    if ($addModel->save()) {
        header("Location: list.php?message=Saved successfully");
        exit;
    } else {
        header("Location: form.php?error=Failed to save customer group.");
        exit;
    }
}

header("Location: form.php");
exit;
?>
