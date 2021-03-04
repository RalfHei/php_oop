<?php

namespace app\models;

use app\core\database\DbModel;

class Blog extends DbModel
{
    public int $id = 0;
    public string $title = '';
    public string $blogPost = '';
    public int $added_by = 0;
    public int $edited_by = 0;
    public string $img_xl = '';
    public string $img_md = '';
    public string $img_sm = '';
    public string $img_dir = '';


    public function tableName(): string
    {
        return 'blog';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return ['title', 'blogPost', 'added_by', 'edited_by', 'img_xl', 'img_md', 'img_sm', 'img_dir'];
    }

    public function save()
    {
        return parent::save();
    }

    public function update($id, $params)
    {
        return parent::update($id, $params);
    }
    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED, 'class' => self::class],
            'blogPost' => [self::RULE_REQUIRED, 'class' => self::class],
            'img_xl' => [self::RULE_IS_IMG, 'class' => self::class],
        ];
    }
}
