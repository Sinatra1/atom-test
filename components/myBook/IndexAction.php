<?php

namespace app\components\myBook;

use yii\rest\Action;
use yii\base\Model;
use Yii;
use app\models\User;

class IndexAction extends Action
{

    public $scenario = Model::SCENARIO_DEFAULT;
    public $viewAction = 'create';

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }
        
        $user = new User();
        $user->id = Yii::$app->user->id;
        
        $params = Yii::$app->request->getQueryParams();
        
        return $user->getMyBooks($params);
    }

}
