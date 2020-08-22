<?php


class Users extends Model
{

    public $id;

    public function __construct($table = null)
    {
        parent::__construct($table);
    }

    function get($id)
    {
        return self::where("id", $id);
    }

    function getByUsername($username)
    {
        return self::where("username", $username);
    }

    public function getByEmail($email){
        return self::where("email", $email);
    }

}