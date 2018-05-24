<?php

namespace models;

use app\db\Model;
use app\UploadedFile;

/**
 * @property integer $id
 * @property string $userName
 * @property string $email
 * @property string $text
 * @property integer $status
 */
class Task extends Model
{
    public static function tableName()
    {
        return 'task';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userName' => 'Имя',
            'email' => 'Email',
            'text' => 'Текст',
            'status' => 'Статус',
        ];
    }

    public function afterUpdate($model = null)
    {
        $uploadedFile = new UploadedFile();
        if ($path = $uploadedFile->upload(self::tableName(), $model->id)) {
            $this->attachImage($model->id, $path);
        }
    }

    public function afterInsert($model = null)
    {
        $uploadedFile = new UploadedFile();
        if ($path = $uploadedFile->upload(self::tableName(), $model->id)) {
            $this->attachImage($model->id, $path);
        }
    }

    public function getImage()
    {
        if ($model = Image::find()->where(['itemId' => $this->id])->one()) {
            return $model;
        }

        return null;
    }

    private function attachImage($id, $path)
    {
        $data = ['image' => [
            'itemId' => $id,
            'filePath' => $path,
            'urlAlias' => $path,
        ]];

        $model = new Image(true);
        if ($model->load($data)) {
            $model->create();
        }
    }
}