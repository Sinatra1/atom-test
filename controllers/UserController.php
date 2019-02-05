<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\User;

/**
 * Description of UserController
 *
 * @author vlad
 */
class UserController extends ActiveController
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

        $actions['index']['prepareDataProvider'] = [$this, 'getListDataProvider'];

        $actions['create'] = [
            'class' => 'app\components\user\RegAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];

        $actions['delete'] = [
            'class' => 'app\components\user\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }
    
    /**
     * @return \ServerResult
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        
        $user = new User();
        
        $user->load(\Yii::$app->getRequest()->getBodyParams(), '');
        
        $user->updateByRequest($request);
        
        $user = User::findOne($user->id);

        return $user;
    }
}
