<?php

namespace app\components\user;

use yii\rest\Action;
use Yii;

class DeleteAction extends Action
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

        if ($model->markDeleted() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }

}
