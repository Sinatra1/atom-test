<?php

use yii\db\Migration;
use app\models\UserToBook;

/**
 * Class m190204_180404_create_table_user_to_book
 */
class m190204_180404_create_table_user_to_book extends Migration
{

    /**
     * create table user_to_book
     */
    public function safeUp()
    {
        $this->createTable(UserToBook::tableName(), [
            'user_id' => $this->bigInteger()->notNull(),
            'book_id' => $this->bigInteger()->notNull(),
            'created' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'updated' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'deleted' => $this->dateTime()->null(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue('0'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('idx_' . UserToBook::tableName() . '_user_id', UserToBook::tableName(), 'user_id');
        $this->createIndex('idx_' . UserToBook::tableName() . '_book_id', UserToBook::tableName(), 'book_id');
        $this->createIndex('idx_' . UserToBook::tableName() . '_user_id_book_id', UserToBook::tableName(), ['user_id', 'book_id'], true);
    }

    /**
     * drop table user_to_book
     */
    public function safeDown()
    {
        $this->dropTable(UserToBook::tableName());
    }

}
