<?php

require_once 'Database.php';
require_once 'Logger.php';

class Model
{

    private static $db;
    private static $table;
    private        $has_many;

    public function __construct($table = null)
    {
        self::$table = $table;
    }

    private static function getConnection()
    {
        self::$db = new Database();
    }

    public static function where($field, $value)
    {
        self::getConnection();

        $sql = "SELECT * FROM " . static::$table . " WHERE " . $field . "= :" . $field;

        return self::$db->select($sql, array($field => $value));
    }

    public function getAll()
    {
        self::getConnection();
        $sql = "SELECT * FROM " . static::$table . ";";

        return $results = self::$db->select($sql, []);
    }

    public function save()
    {
        self::getConnection();

        $values = get_object_vars($this);

        $has_many = self::checkRelationship("has_many", $values);

        $result = self::$db->update(static::$table, $values, "id = " . $values["id"]);

        if ($result) {
            $result = array('error' => 0, 'message' => 'Objeto Actualizado');
        } else {
            $result = array('error' => 1, 'message' => self::$db->getError());
        }

        if ($has_many) {
            $rStatus = self::saveRelationships($has_many);
            if ($rStatus["error"]) {
                (new Logger)->alert("Error saving relationships", $rStatus["trace"], "save");
            }
        }
        (new Logger)->debug("result", $result, "save");

        return $result;
    }

    public function create($values = [])
    {

        self::getConnection();



        $has_many = self::checkRelationship("has_many", $values);

        //Logger::debug("db",self::$db);
        $result = self::$db->insert(static::$table, $values);

        if ($result) {
            $result   = array('error' => 0, 'getID' => self::$db->getInsertedId(), 'message' => 'Objeto Creado');
            $this->id = $result["getID"];
        } else {
            $result = array('error' => 1, 'getID' => null, 'message' => self::$db->getError());
        }

        if ($has_many) {
            $rStatus = self::saveRelationships($has_many);
            if ($rStatus["error"]) {
                (new Logger)->alert("Error saving relationships", $rStatus["trace"], "create");
            }
        }

        return $result;
    }

    public function has_many($rName, $obj)
    {
        if (isset($this->has_many[$rName])) {

            $rule = $this->has_many[$rName];
            if (get_class($obj) == $rule["class"]) {
                if (isset($this->id) && isset($obj->id)) {
                    $rule["relationships"][] = array(
                        $rule['join_self_as'] => $this->id,//id_user=>1
                        $rule['join_other_as'] => $obj->id
                    );
                    $this->has_many[$rName]  = $rule;
                } else {
                    print("Se requieren llaves primarias para la relación");
                }
            } else {
                print("No se cumple con el tipo de objeto");
            }

        } else {
            print("No existe este tipo de relación");
        }

    }

    public function checkRelationship($rType, &$data)
    {

        if (isset($data[$rType])) {
            $relationship = $data[$rType];
            unset($data[$rType]);
            return $relationship;
        } else {
            return false;
        }

    }

    public function saveRelationships($relationships)
    {
        $log = array("error" => 0, "trace" => array());
        foreach ($relationships as $name => $rules) {

            if (isset($rules["relationships"])) {
                foreach ($rules["relationships"] as $key => $relacion) {
                    $table = $rules["join_table"];
                    self::$db->insert($table, $relacion);

                }
            }

        }
        return $log;
    }
}