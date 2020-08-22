<?php

require_once 'config.php';

class Database extends PDO
{
    public function __construct()
    {
        parent::__construct('mysql' . ':host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    public function select($sql, $array = [], $fetchMode = PDO::FETCH_OBJ)
    {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue($key, $value);
        }

        $sth->execute();

        return $sth->fetchAll($fetchMode);
    }


    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames  = implode('`,`', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        return $sth->execute();
    }

    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key=:$key,";
        }

        $fieldDetails = rtrim($fieldDetails, ',');
        //Logger::debug("fieldDetails",$fieldDetails,"update");

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        //Logger::debug("sth",$sth,"update");
        return $sth->execute();
    }

    public function delete($table, $where, $limit = 1)
    {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

    public function getInsertedId()
    {
        return self::lastInsertId();
    }

    public function getError()
    {
        return self::errorInfo();
    }

}