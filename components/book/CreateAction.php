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

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        $coverImageFile = UploadedFile::getInstanceByName('cover_image_file');
        
        if (!empty($coverImageFile)) {
            $model->uploadCoverImageFile($coverImageFile);
        }
        
        $model->save();

        if ($model->hasErrors()) {
            throw ServerErrorHttpException('Failed to create the book for unknown reason.');
        }

        return $model->id;
    }

}
