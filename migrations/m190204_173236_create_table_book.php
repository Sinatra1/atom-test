<?php

use yii\db\Migration;
use app\models\Book;
use app\models\User;

/**
 * Class m190204_173236_create_table_book
 */
class m190204_173236_create_table_book extends Migration
{

    public static $tableName = 'book';
    public static $name = 'name';
    public static $year = 'year';
    public static $isbn = 'isbn';
    public static $createdUserId = 'created_user_id';
    
    /**
     * create table book
     */
    public function safeUp()
    {
        $this->createTable(Book::tableName(), [
            'id' => $this->primaryKey(),
            'created' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'updated' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'deleted' => $this->dateTime()->null(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue('0'),
            self::$createdUserId => $this->integer(11)->notNull(),
            self::$isbn => $this->string(13)->unique()->null(),
            self::$year => $this->integer(4)->notNull(),
            self::$name => $this->string()->notNull(),
            'cover_image' => $this->string()->null(),
            'description' => $this->text()->null()
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('idx_' . Book::tableName() . '_' . self::$createdUserId, Book::tableName(), self::$createdUserId);
        
        $this->createIndex('idx_' . self::$tableName . '_name', Book::tableName(), 'name');

        $this->createIndex('idx_' . self::$tableName . '_' . self::$name. '_' . self::$year, Book::tableName(), [self::$name, self::$year], true);
        
        $this->addForeignKey('fk_' . User::tableName() . '_' . self::$createdUserId, Book::tableName(), self::$createdUserId, User::tableName(), 'id');
    }

    /**
     * drop table book
     */
    public function safeDown()
    {
        $this->dropTable(Book::tableName());
    }

}
