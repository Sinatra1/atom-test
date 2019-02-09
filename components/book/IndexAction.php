<?php

namespace app\components\book;

use yii\rest\Action;
use yii\base\Model;

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
        
        return $model->getList(\Yii::$app->request->getQueryParams());
    }

}
