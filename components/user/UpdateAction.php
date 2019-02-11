<?php

namespace app\components\user;

use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\base\Model;
use Yii;

class UpdateAction extends Action
{

    public $scenario = Model::SCENARIO_DEFAULT;
    public $viewAction = 'create';

    public function run()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        
        if (empty($model->id)) {
            throw new ServerErrorHttpException("A user with this id doesn't exsist");
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        $model->save();
        
        if ($model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }

}
