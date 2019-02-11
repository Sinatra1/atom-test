<?php

namespace app\components\myBook;

use yii\rest\Action;
use yii\base\Model;
use Yii;
use app\models\User;
use yii\web\ServerErrorHttpException;

class UpdateAction extends Action
{

    public $scenario = Model::SCENARIO_DEFAULT;

    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if (empty($model->id)) {
            throw new ServerErrorHttpException("A book with this id doesn't exsist");
        }

        $user = new User();
        $user->id = Yii::$app->user->id;

        if (!$user->addBookToMy($model->id)) {
            throw new ServerErrorHttpException('Failed to add book to user');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }

}
