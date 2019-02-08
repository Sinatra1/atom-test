<?php

namespace app\models;

use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $name
 * @property string $isbn
 * @property integer $year
 * @property string $cover_image
 * @property text $description
 * @property datetime $created
 * @property datetime $updated
 * @property datetime $deleted
 * @property boolean $is_deleted
 * 
 */
class Book extends Base
{

    /**
     * @var UploadedFile
     */
    public $cover_image_file;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $currentYear = date("Y");
        $oldestYear = 1400;

        return [
                [['name', 'year'], 'required'],
                [['name', 'cover_image'], 'string', 'max' => 255],
                ['isbn', 'string', 'length' => 13],
                [['year', 'isbn'], 'integer'],
                ['year', 'compare', 'compareValue' => $currentYear, 'operator' => '<=', 'type' => 'number'],
                ['year', 'compare', 'compareValue' => $oldestYear, 'operator' => '>=', 'type' => 'number'],
                [['name', 'year', 'isbn', 'description'], 'trim'],
                ['description', 'string'],
                ['isbn', 'unique'],
                [['name', 'year'], 'unique', 'targetAttribute' => ['name', 'year']],
                [['cover_image_file'], 'image'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);

        if (empty($this->isbn)) {
            $this->isbn = null;
        }

        if (empty($this->cover_image)) {
            $this->cover_image = null;
        }

        return $result;
    }

    /**
     * 
     * @param UploadedFile $coverImageFile
     * @return bool upload result
     */
    public function uploadCoverImageFile()
    {
        if (empty($this->cover_image_file) || !$this->validate()) {
            //throw new ServerErrorHttpException('Uploaded file is too big');
            return false;
        }
        $parentDir = \Yii::$app->basePath . '/web';
        $uploadDirPath = $parentDir . '/' . \Yii::$app->params['uploadDirName'];

        if (!file_exists($uploadDirPath)) {
            throw new ServerErrorHttpException('Upload dir ' . $uploadDirPath . ' not exists');
        }

        $coverImage = $this->cover_image_file->baseName . '.' . $this->cover_image_file->extension;
        
        $uploadResult = $this->cover_image_file->saveAs($uploadDirPath . '/' . $coverImage);

        if ($uploadResult) {
            $this->cover_image = $coverImage;
        } else {
            throw new ServerErrorHttpException('Failed to save cover image file');
        }

        return $uploadResult;
    }

}
