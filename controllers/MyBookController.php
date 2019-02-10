<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

/**
 * Description of BookController
 *
 * @author vlad
 */
class MyBookController extends ActiveController
{

    public $modelClass = 'app\models\Book';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options'],
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['index'] = [
            'class' => 'app\components\myBook\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['create'] = [
            'class' => 'app\components\myBook\CreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];

        $actions['update'] = [
            'class' => 'app\components\myBook\CreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->updateScenario,
        ];
        
        $actions['delete'] = [
            'class' => 'app\components\myBook\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

}
