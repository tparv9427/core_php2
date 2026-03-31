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
        $columnNames = "";
        $columnValues = "";

        foreach ($this->data as $column => $value) {
            $columnNames .= $column . ", ";
            $columnValues .= "'" . $value . "', ";
        }

        $columnNames = rtrim($columnNames, ", ");
        $columnValues = rtrim($columnValues, ", ");

        $sql = "INSERT INTO {$this->tableName} ($columnNames) VALUES ($columnValues)";

        $newId = $this->db->insert($sql);
        if ($newId !== false) {
            $this->data[$this->primaryKey] = $newId;
            return $this;
        }
        return false;
    }

    public function update()
    {
        if (!isset($this->data[$this->primaryKey])) {
            return false;
        }
        $primaryKeyValue = $this->data[$this->primaryKey];

        $updateString = "";
        foreach ($this->data as $column => $value) {
            if ($column === $this->primaryKey) {
                continue;
            }
            $updateString .= "$column = '{$value}', ";
        }
        $updateString = rtrim($updateString, ", ");

        $sql = "UPDATE {$this->tableName} SET {$updateString} WHERE {$this->primaryKey} = '{$primaryKeyValue}'";

        if ($this->db->update($sql)) {
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
