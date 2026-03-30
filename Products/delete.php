<?php
require_once '../Database.php';
require_once 'Product.php';

$db = (new Database())->connect();
$deleteModel = new Product($db);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete'){
    if(isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {
        $ids = implode(',',array_map('intval',$_POST['selected_ids']));
        $query = "DELETE FROM {$deleteModel->tableName} WHERE {$deleteModel->primaryKey} IN ($ids)";
        $db->delete($query);
        header("Location: list.php?message=Deleted Successfully");
        exit;
    } else {
        header("Location: list.php?error=Please select at least one product.");
        exit;
    }
}

if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    $query = "DELETE FROM {$deleteModel->tableName} WHERE {$deleteModel->primaryKey} = $id";
    $db->delete($query);
    header("Location: list.php?message=Deleted Successfully");
    exit;
}

header("Location: list.php");
exit;
?>