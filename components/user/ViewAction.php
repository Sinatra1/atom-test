<?php

namespace app\components\user;

use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use Yii;

class ViewAction extends Action
{

    public function run()
    {
        $model = $this->findModel(Yii::$app->user->id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        
        if (empty($model->id)) {
            throw new ServerErrorHttpException("A user with this id doesn't exsist");
        }

        return $model;
    }

}
