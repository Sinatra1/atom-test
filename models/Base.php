<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the Base model class 
 *
 * 
 * @property datetime $created
 * @property datetime $updated
 * @property datetime $deleted
 * @property boolean $is_deleted
 */

class Base extends ActiveRecord
{
    public function markDeleted()
    {
        $this->is_deleted = 1;
        $this->save();
    }

    public function recover()
    {
        $this->is_deleted = 0;
        $this->save();
    }
}
