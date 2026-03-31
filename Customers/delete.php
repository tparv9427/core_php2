<?php
require_once '../Database.php';
require_once 'Customers.php';

$db = (new Database())->connect();
$deleteModel = new Customers($db);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete'){
    if(isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])){
        $ids = implode(",",array_map('intval', $_POST['selected_ids']));
        $query = "DELETE FROM {$deleteModel->tableName} WHERE {$deleteModel->primaryKey} IN ({$ids})";
        $db->delete($query);
        header("Location: list.php?message=Deleted successfully");  
        exit;
    } else {
        header("Location: list.php?error=Select at least one customer.");  
        exit;
    }
}

if($_GET['id']){
    $id = $_GET['id'];
    $query = "DELETE FROM {$deleteModel->tableName} WHERE {$deleteModel->primaryKey} = {$id}";
    $db->delete($query);
    header("Location: list.php?message=Deleted successfully");  
    exit;
}

header("Location: list.php");
exit;
?>
