<?php

use yii\db\Migration;
use app\models\Book;

/**
 * Class m190204_173236_create_table_book
 */
class m190204_173236_create_table_book extends Migration
{

    public static $tableName = 'book';
    public static $name = 'name';
    public static $year = 'year';
    public static $isbn = 'isbn';

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
            self::$isbn => $this->string(13)->unique()->null(),
            self::$year => $this->integer(4)->notNull(),
            self::$name => $this->string()->notNull(),
            'description' => $this->text()->null()
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('idx_' . self::$tableName . '_name', Book::tableName(), 'name');
        $this->createIndex('idx_' . self::$tableName . '_image_id', Book::tableName(), 'image_id');

        $this->createIndex('idx_' . self::$tableName . '_' . self::$name. '_' . self::$year, Book::tableName(), [self::$name, self::$year], true);
    }

    /**
     * drop table book
     */
    public function safeDown()
    {
        $this->dropTable(Book::tableName());
    }

}
