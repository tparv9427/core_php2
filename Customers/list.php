<?php
require_once '../Database.php';
require_once 'Customers.php';
require_once '../CustomerGroups/CustomerGroups.php';

$db = (new Database)->connect();
$customerModel = new Customers($db);
$customerGroupModel = new CustomerGroups($db);

$query = "SELECT c.*,cg.group_name FROM {$customerModel->tableName} c LEFT JOIN {$customerGroupModel->tableName} cg ON c.{$customerGroupModel->primaryKey} = cg.{$customerGroupModel->primaryKey} ORDER BY C.{$customerModel->primaryKey} DESC";
$db->fetchAll($query)?:[];
include 'grid.php';
?>