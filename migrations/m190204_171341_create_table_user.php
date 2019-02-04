<?php

use yii\db\Migration;
use app\models\User;
/**
 * Class m190204_171341_create_table_user
 */
class m190204_171341_create_table_user extends Migration
{
    /**
     * create table user
     */
    public function safeUp()
    {
        $this->createTable(User::tableName(), [
            'id' => $this->primaryKey(),
            'created' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'updated' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'deleted' => $this->dateTime()->null(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue('0'),
            'email' => $this->string()->unique()->notNull(),
            'username' => $this->string()->unique()->notNull(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'password' => $this->text()->notNull(),
            'access_token' => $this->text()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
          
        $this->createIndex('idx_' . User::tableName() . '_username', User::tableName(), 'username');
        $this->createIndex('idx_' . User::tableName() . '_email', User::tableName(), 'email');
    }

    /**
     * drop table user 
     */
    public function safeDown()
    {
        $this->dropTable(User::tableName());
    }
}
