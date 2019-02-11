<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

/**
 * Description of AuthController
 *
 * @author vlad
 */
class AuthController extends ActiveController
{

    public $modelClass = 'app\models\User';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options', 'create'],
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['create'] = [
            'class' => 'app\components\auth\LoginAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];

        $actions['delete'] = [
            'class' => 'app\components\auth\LogoutAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess']
        ];

        $actions['options'] = [
            'class' => 'app\components\auth\OptionsAction',
        ];

        return $actions;
    }

}
