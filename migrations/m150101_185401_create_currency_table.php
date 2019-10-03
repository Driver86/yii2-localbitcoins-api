<?php

use yii\db\Migration;

class m150101_185401_create_currency_table extends Migration
{
    public function up()
    {
        $this->createTable('account', [
            'id' => $this->primaryKey(),
            'login' => $this->string(32),
            'apiKey' => $this->string(32),
            'secretKey' => $this->string(64),
            'createdAt' => $this->timestamp(),
        ]);
        $this->createIndex('login', 'account', 'login', true);
        $this->createIndex('apiKey', 'account', 'apiKey', true);
        $this->createIndex('secretKey', 'account', 'secretKey', true);

        $this->createTable('balance', [
            'id' => $this->primaryKey(),
            'ownerId' => $this->integer(),
            'value' => $this->decimal(10, 8),
            'createdAt' => $this->timestamp(),
        ]);
        $this->createIndex('ownerId', 'balance', 'ownerId');
        $this->addForeignKey('ownerId', 'balance', 'ownerId', 'account', 'id');
        $this->createIndex('createdAt', 'balance', 'createdAt');

        $this->createTable('course', [
            'id' => $this->primaryKey(),
            'usd' => $this->decimal(10, 2),
            'btc' => $this->decimal(10, 2),
            'createdAt' => $this->timestamp(),
        ]);
        $this->createIndex('createdAt', 'course', 'createdAt');
    }
}
