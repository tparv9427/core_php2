<?php 

require_once '../Database.php';
require_once '../Row.php';

    class Customers extends Row {
        public $tableName = 'customer';
        public $primaryKey = 'customer_id';

        public function insert() {
            if(!isset($this->data['created_date'])) {
                $this->data['created_date'] = date('Y-m-d H:i:s');
            }
            return parent::insert();
        }

        public function update() {
            $this->data['updated_date'] = date('Y-m-d H:i:s');
            return parent::update();
        }
    }
?>