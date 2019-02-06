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
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $currentYear = date("Y");
        $oldestYear = 1400;
        
        return [
            [['name', 'year'], 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'string', 'max' => 255],
            ['isbn', 'string', 'length' => 13],
            [['year', 'isbn'], 'integer'],
            ['year', 'compare', 'compareValue' => $currentYear, 'operator' => '<=', 'type' => 'number'],
            ['year', 'compare', 'compareValue' => $oldestYear, 'operator' => '>=', 'type' => 'number'],
            [['name', 'year', 'isbn', 'description'], 'trim'],
            ['description', 'string'],
            ['isbn', 'unique'],
            [['name', 'year'], 'unique', 'targetAttribute' => ['name', 'year']],
        ];
    }
}
