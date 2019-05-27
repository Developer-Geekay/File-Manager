<?php

require_once('config.php');

class DB_Class
{
    private $connection_status = false;
    private $mysql = '';
    private $result = '';

    public function db_connect()
    {
        $this->mysql = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_SCHEMA);
        if (!$this->mysql->connect_errno) {
            $this->connection_status = true;
            return $this->mysql;
        }else{
            echo $this->mysql->connect_error;
        }
    }

    public function db_free()
    {
        $this->mysql->close();
        $this->connection_status = false;
    }

    public function db_check()
    {
        return $this->connection_status;
    }

    public function db_query($query)
    {
        $this->result = $this->mysql->query($query);
        return $this->result;
    }

    public function result_array($type = 'array')
    {
        if ($type == 'array') {
            return $this->result->fetch_array(MYSQLI_NUM);
        } elseif ($type == 'assoc') {
            return $this->result->fetch_array(MYSQLI_ASSOC);
        } else {
            return $this->result->fetch_array(MYSQLI_BOTH);
        }
    }

    public function results($type = 'array')
    {
        if ($type == 'array') {
            return $this->result->fetch_all(MYSQLI_NUM);
        } elseif ($type == 'assoc') {
            return $this->result->fetch_all(MYSQLI_ASSOC);
        } else {
            return $this->result->fetch_all(MYSQLI_BOTH);
        }
    }

    public function db_row(){
        return $this->result->fetch_row();
    }

    public function db_field_count(){
        return $this->result->field_count;
    }

    public function db_num_rows(){
        return $this->result->num_rows;
    }

    public function db_free_result(){
        $this->result->close();
    }
}
