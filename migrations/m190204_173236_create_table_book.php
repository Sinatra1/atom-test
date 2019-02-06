<?php

use yii\db\Migration;
use app\models\Book;

/**
 * Class m190204_173236_create_table_book
 */
class m190204_173236_create_table_book extends Migration
{
    /**
     * create table book
     */
    public function safeUp()
    {
        $this->createTable(Book::tableName(), [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer(11)->null(),
            'created' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'updated' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'deleted' => $this->dateTime()->null(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue('0'),
            'isbn' => $this->string(17)->unique()->notNull(),
            'year' => $this->integer(4)->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->null()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        $this->createIndex('idx_book_name', Book::tableName(), 'name');
        $this->createIndex('idx_book_image_id', Book::tableName(), 'image_id');
    }

    /**
     * drop table book
     */
    public function safeDown()
    {
        $this->dropTable(Book::tableName());
    }
}
