<?php

namespace app\components\myBook;

use yii\rest\Action;
use yii\base\Model;
use Yii;

class IndexAction extends Action
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
        
        $params = Yii::$app->request->getQueryParams();
        $params['only_my'] = true;
        
        return $model->getList($params);
    }

}
