<?php

namespace app\core;

abstract class Model
{

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_IMG_EXISTS = 'imgExists';
    public const RULE_IS_IMG = 'isImg';
    public const RULE_IS_URL = 'isUrl';
    public const RULE_MIN_SIZE = 'minSize';
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && !empty($value)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public array $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }


                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_IS_IMG && !empty($_FILES['img_file']['name'])) {
                    $allowed = array("image/jpeg", "image/gif", "image/png");
                    $fileType = $_FILES['img_file']['type'];
                    if (!in_array($fileType, $allowed)) {
                        $this->addErrorForRule($attribute, self::RULE_IS_IMG);
                    }
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_IMG_EXISTS && !empty($value)) {
                    if (filter_var($value, FILTER_VALIDATE_URL)) {
                        $headers = @get_headers($value, 1);
                        if (!is_array($headers['Content-Type'])) {
                            $imgUrl = strpos($headers['Content-Type'], "image");
                            if ($imgUrl === false) {
                                $this->addErrorForRule($attribute, self::RULE_IMG_EXISTS);
                            } else {
                                $imgWidth = getimagesize($value)[0];
                                $imgHeight = getimagesize($value)[1];
                                if ($imgWidth < 1200 && $imgHeight < 800) {
                                    $this->addErrorForRule($attribute, self::RULE_MIN_SIZE);
                                }
                            }
                        } else {
                            $this->addErrorForRule($attribute, self::RULE_IS_URL);
                        }
                    } elseif (!filter_var($value, FILTER_VALIDATE_URL)) {
                        $this->addErrorForRule($attribute, self::RULE_IS_URL);
                    }
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute = :$uniqueAttribute");
                    $statement->bindValue(":$uniqueAttribute", $value);
                    $statement->execute();
                    $dbUser = $statement->fetchObject();
                    if ($dbUser) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        $lang = Application::$app->lang;
        return [
            self::RULE_REQUIRED => $lang['ruleRequired'],
            self::RULE_EMAIL => $lang['ruleEmail'],
            self::RULE_MIN => $lang['ruleMin'],
            self::RULE_MATCH => $lang['ruleMatch'],
            self::RULE_UNIQUE => $lang['ruleUnique'],
            self::RULE_IMG_EXISTS => $lang['ruleImgExists'],
            self::RULE_IS_URL => $lang['ruleUrlFalse'],
            self::RULE_MIN_SIZE => $lang['minImgSize'],
            self::RULE_IS_IMG => $lang['minImgSize'],
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
