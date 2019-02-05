<?php

namespace app\components\user;

use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\base\Model;
use app\models\User;
use yii\helpers\Url;

class RegAction extends Action
{

    public $scenario = Model::SCENARIO_DEFAULT;
    public $viewAction = 'create';

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        $model->save();
        
        if ($model->hasErrors()) {
            throw Exception('Failed to create the object for unknown reason.' . var_dump($model->getErrors()));
        }

        if (!$model->login()) {
            throw new ServerErrorHttpException('something is wrong inside Yii::$app->user->username');
        }

        $userArray = User::find()->where(['username' => $model->username])->asArray()->one();

        return ['access_token' => 'Bearer ' . $userArray['access_token'], 'id' => \Yii::$app->user->id];
    }

}
