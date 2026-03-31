<?php
require_once '../Database.php';
require_once 'CustomerGroups.php';

$db = (new Database())->connect();
$editModel = new CustomerGroups($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST[$editModel->primaryKey]) && !empty($_POST[$editModel->primaryKey])){
        $editModel->load($_POST[$editModel->primaryKey]);
    }
    if(isset($_POST[$editModel->tableName]) && is_array($_POST[$editModel->tableName])){
        foreach($_POST[$editModel->tableName] as $key=>$value){
            $editModel->value($key,$value);
        }
    }

    if(isset($_POST[$editModel->primaryKey]) && !empty($_POST[$editModel->primaryKey])){
        $editModel->data[$editModel->primaryKey] = $_POST[$editModel->primaryKey];
    }


    if ($customerGroupModel->save()) {
        header("Location: list.php?message=Updated successfully");
        exit;
    } else {
        header("Location: form.php?id=" . ($_POST['customer_group_id'] ?? '') . "&error=Failed to save customer group.");
        exit;
    }
}

$id = $_GET['id'] ?? '';
header("Location: form.php?id=$id");
exit;
?>
