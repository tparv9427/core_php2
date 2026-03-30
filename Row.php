<?php

class Row
{
    public $tableName = "";
    public $primaryKey = "";
    public $db;
    public $data = [];

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function load($value, $column = null)
    {
        if ($column === null) {
            $column = $this->primaryKey;
        }
        $sql = "SELECT * FROM {$this->tableName} WHERE {$column} = '{$value}' LIMIT 1";
        
        $result = $this->db->fetchRow($sql);
        if ($result && is_array($result)) {
            $this->data = $result;
            return $this;
        }
        return false;
    }

    public function insert()
    {
        $vals = [];
        $cols = [];
        foreach($this->data as $key => $value){
            $vals[$key] = $value;
            $cols[$key] = $key;
        }


        $values = implode(",",$vals);
        $columns = implode(",",$cols);
        $query = "Insert into {$this->tableName}({$columns}) values ({$values});";
        $newId = $this->db->insert($query);
        if ($newId !== false) {
            $this->data[$this->primaryKey] = $newId;
            return $this;
        }
        return false;
    }

    public function update()
    {
        if(!isset($this->data[$this->primaryKey])){
            return false;
        }

        $primarykeyvalue = $this->data[$this->primaryKey];
        $updatecols = [];
        foreach($this->data as $key => $value){
            if($key === $this->primaryKey){
                continue;
            }
            $updatecols[$key] = $value;
        }
        $updatecols = implode(",",$updatecols);

        $query = "Update {$this->tableName} set {$updatecols} where {$this->primaryKey} = {$primarykeyvalue};";
        if($this->db->update($query)){
            return $this;
        }
        return false;
    }

    public function save()
    {
        if (isset($this->data[$this->primaryKey]) && !empty($this->data[$this->primaryKey])) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    public function value($key, $value = null)
    {
        if ($value !== null) {
            $this->data[$key] = $value;
            return $this;
        }

        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }
}
