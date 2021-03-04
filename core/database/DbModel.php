<?php

namespace app\core\database;

use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract public function primaryKey(): string;

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    //--------------------CRUD---------------------------------//
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn ($attr) => ":$attr", $attributes);
        $statment = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ")
                VALUES(" . implode(',', $params) . ")");

        foreach ($attributes as $attribute) {
            $statment->bindValue(":$attribute", $this->{$attribute});
        }

        $statment->execute();
        return true;
    }

    public function update($id, $params)
    {
        $tableName = $this->tableName();
        $values = array_filter($params);
        $query = (implode(" , ", array_map(fn ($key, $value) => "$key = '$value'", array_keys($values), $values)));
        $statment = self::prepare("UPDATE $tableName SET $query WHERE id = $id");
        $statment->execute();
        return true;
    }


    public function deleteOne($id)
    {
        $tableName = (new static)->tableName();
        $at = $id;
        $statement = self::prepare("DELETE FROM $tableName WHERE id = $at");
        $statement->execute();
        return true;
    }

    public static function all()
    {
        $tableName = (new static)->tableName();
        $statement = self::prepare("SELECT * FROM $tableName ORDER BY added desc");
        $statement->execute();
        return $statement->fetchAll();
    }

    //--------------------find by query---------------------------------//

    //find by user

    public static function findUserLimit($offset, $perPage, $id)
    {
        $tableName = (new static)->tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE added_by = $id LIMIT $offset, $perPage");
        $statement->execute();
        return $statement->fetchAll();
    }


    public static function findUserPosts($id)
    {
        $tableName = (new static)->tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE added_by = $id");
        $statement->execute();
        return $statement->fetchAll();
    }



    public function findById($id)
    {
        $tableName = (new static)->tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE id= :id");
        $statement->execute($id);
        return $statement->fetchObject(static::class);
    }

    public static function findLimit($offset, $perPage)
    {
        $tableName = (new static)->tableName();
        $statement = self::prepare("SELECT * FROM $tableName ORDER BY added desc LIMIT $offset, $perPage ");
        $statement->execute();
        return $statement->fetchAll();
    }


    public static function findLatest()
    {
        $tableName = (new static)->tableName();
        $statement = self::prepare("SELECT * FROM $tableName ORDER BY added desc limit 1");
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function findOne($where)
    {
        $tableName = (new static)->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn ($attribute) => "$attribute = :$attribute", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
    public static function findSome($where)
    {
        $tableName = (new static)->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn ($attribute) => "$attribute LIKE :$attribute", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", "%$item%");
        }
        $statement->execute();
        return $statement->fetchAll();
    }
}
