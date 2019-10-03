<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Account extends ActiveRecord
{
    public function rules()
    {
        return [
            [
                ['login', 'apiKey', 'secretKey'],
                'required',
            ],
            [
                ['login', 'apiKey', 'secretKey'],
                'trim',
            ],
            [
                ['login', 'apiKey', 'secretKey'],
                'unique',
            ],
            [
                ['login', 'apiKey'],
                'string',
                'max' => 32,
            ],
            [
                ['secretKey'],
                'string',
                'max' => 64,
            ],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getBalances() {
        return $this->hasMany(Balance::class, ['ownerId' => 'id'])->orderBy(['createdAt' => SORT_DESC]);
    }
}
