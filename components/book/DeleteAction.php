<?php

namespace app\components\book;

use yii\rest\Action;
use Yii;

class DeleteAction extends Action
{

    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        
        if (!empty($model->id) && $model->created_user_id != Yii::$app->user->id) {
            throw new ServerErrorHttpException('Not allowed to edit this book');
        }
        
        if (!empty($id) && empty($model->id)) {
            throw new ServerErrorHttpException("A book with this id doesn't exsist");
        }

        if ($model->markDeleted() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }

}
