<?php

namespace app\components\book;

use yii\web\ServerErrorHttpException;
use yii\rest\Action;
use yii\base\Model;
use yii\web\UploadedFile;

class CreateAction extends Action
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
        
        $id = \Yii::$app->getRequest()->getQueryParam('id');
        
        if (!empty($id)) {
            $model = $this->findModel($id);
        }
        
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        $model->cover_image_file = UploadedFile::getInstanceByName('cover_image_file');
        
        if (!empty($model->cover_image_file)) {
            $model->uploadCoverImageFile();
            if ($model->hasErrors()) {
                die(var_dump($model->getErrors()));
            }
        }
        
        $model->cover_image_file = null;
        
        $model->save();
        
        if ($model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the book for unknown reason.');
        }

        return $model->id;
    }

}
