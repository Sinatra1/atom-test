<?php

namespace app\components\auth;

use yii\rest\Action;
use app\api\models\ServerResult;
use Yii;

class CheckAuthAction extends Action
{
    public function run()
    {
        $response = Yii::$app->getResponse();
        $response->setStatusCode(200);

        return [new ServerResult()];
    }
}
