<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Barbershop extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%barbershop}}';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['name'], 'string', 'max' => 120],
            [['address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 180],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['slug'], 'string', 'max' => 180],
            [['slug'], 'unique'],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (empty($this->slug) && !empty($this->name)) {
                $this->slug = $this->generateSlug($this->name);
            }
            return true;
        }
        return false;
    }

    protected function generateSlug($name)
    {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $slug = preg_replace('~[^\pL\d]+~u', '-', $slug);
        $slug = trim($slug, '-');
        $slug = strtolower($slug);
        $slug = preg_replace('~[^-a-z0-9]+~', '', $slug);
        return $slug ?: 'barbershop';
    }

    public function getAccounts()
    {
        return $this->hasMany(Account::class, ['barbershop_id' => 'id']);
    }

    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['barbershop_id' => 'id']);
    }

    public function getServices()
    {
        return $this->hasMany(Service::class, ['barbershop_id' => 'id']);
    }
}
