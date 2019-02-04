<?php

namespace app\models;

/**
 * This is the model class for table "user_to_book".
 *
 * @property integer $user_id
 * @property integer $book_id
 * @property datetime $created
 * @property datetime $updated
 * @property datetime $deleted
 * @property boolean $is_deleted
 */
class UserToBook extends Base
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'user_to_book';
    }
}
