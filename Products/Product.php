<?php
require_once "../Database.php";
require_once "../Row.php";
class Product extends Row{
    public $tableName = "product";
    public $primaryKey = "product_id";
    public function insert()
    {
        $this->data['created_date'] = date('Y-m-d H:i:s');
        return parent::insert();
    }

    public function update()
    {
        $this->data['updated_date'] = date('Y-m-d H:i:s');
        return parent::update();
    }
}
?>