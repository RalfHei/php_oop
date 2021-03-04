<?php

namespace app\models;

use app\core\Model;
use app\core\Application;
use app\core\database\DbModel;

class User extends DbModel
{
    public int $id = 0;
    public string $email = '';
    public string $password = '';
    public string $passwordRepeat = '';
    public $rights;


    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }
    public function UserRights(): string
    {
        return 'rights';
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
        echo 'creating user';
    }
    public function update($id, $params)
    {
        if (!empty($params['password'])) {
            $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
        }
        return parent::update($id, $params);
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'passwordRepeat' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function attributes(): array
    {
        return ['id', 'email', 'password'];
    }
}
