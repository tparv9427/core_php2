<?php
require_once '../Database.php';
require_once 'ProductMedia.php';

$db = (new Database)->connect();
$deleteModel = new ProductMedia($db);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "delete"){
    if(isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])){
        $ids = implode(",",array_map('intval',$_POST['selected_ids']));
        $query = "DELETE FROM {$deleteModel->tableName} WHERE {$deleteModel->primaryKey} IN ({$ids})";
        $db->delete($query);
        header("Location: list.php?message=Selected media deleted successfully");
        exit;
    } else {
        header("Location: list.php?error=Please select at least one media item.");
        exit;
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM {$deleteModel->primaryKey} WHERE {$deleteModel->primaryKey} = {$id}";
    $db->delete($query);
    header("Location: list.php?message=Selected media deleted successfully");
    exit;
}

header("Loction: list.php");
exit;
?>