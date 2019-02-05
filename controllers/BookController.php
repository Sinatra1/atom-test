<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\Book;
use yii\data\ActiveDataProvider;

/**
 * Description of BookController
 *
 * @author vlad
 */
class BookController extends ActiveController
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

        $actions['index']['prepareDataProvider'] = [$this, 'getListDataProvider'];

        return $actions;
    }
    
    public function getListDataProvider()
    {
        $query = Book::find()
            ->where([
                'is_deleted' => false
            ])
            ->orderBy('name');

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }
}
