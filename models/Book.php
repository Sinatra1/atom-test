<?php

namespace app\models;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $name
 * @property string $isbn
 * @property integer $year
 * @property integer $image_id
 * @property text $description
 * @property datetime $created
 * @property datetime $updated
 * @property datetime $deleted
 * @property boolean $is_deleted
 */

class Book extends Base
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'book';
    }
}
