<?php
require_once '../Database.php';
require_once 'CustomerGroups.php';

$db = (new Database)->connect();
$customerGroupModel = new CustomerGroups($db);

$query = "SELECT * FROM {$customerGroupModel->tableName} ORDER BY {$customerGroupModel->primaryKey} DESC";
$customer_groups = $db->fetchAll($query) ?: [];

include 'grid.php';
?>
