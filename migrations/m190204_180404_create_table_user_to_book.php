<?php

use yii\db\Migration;
use app\models\UserToBook;
use app\models\User;
use app\models\Book;

/**
 * Class m190204_180404_create_table_user_to_book
 */
class m190204_180404_create_table_user_to_book extends Migration
{

    public static $userId = 'user_id';
    public static $bookId = 'book_id';

    /**
     * create table user_to_book
     */
    public function safeUp()
    {
        $this->createTable(UserToBook::tableName(), [
            self::$userId => $this->integer(11)->notNull(),
            self::$bookId => $this->integer(11)->notNull(),
            'created' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'deleted' => $this->dateTime()->null(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue('0'),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('idx_' . UserToBook::tableName() . '_' . self::$userId, UserToBook::tableName(), self::$userId);
        $this->createIndex('idx_' . UserToBook::tableName() . '_' . self::$bookId, UserToBook::tableName(), self::$bookId);
        $this->createIndex('idx_' . UserToBook::tableName() . '_' . self::$userId . '_' . self::$bookId, UserToBook::tableName(), [self::$userId, self::$bookId], true);

        $this->addForeignKey('fk_' . User::tableName() . '_' . self::$userId, UserToBook::tableName(), self::$userId, User::tableName(), 'id');
        $this->addForeignKey('fk_' . Book::tableName() . '_' . self::$bookId, UserToBook::tableName(), self::$bookId, Book::tableName(), 'id');
    }

    /**
     * drop table user_to_book
     */
    public function safeDown()
    {
        $this->dropTable(UserToBook::tableName());
    }

}
