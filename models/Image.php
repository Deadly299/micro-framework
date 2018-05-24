<?php

namespace models;

use app\db\Model;

/**
 * @property integer $id
 * @property string $filePath
 * @property integer $itemId
 * @property string $urlAlias
 */
class Image extends Model
{
    public static $placeHolderPath = 'web/images/placeHolder.png';

    public static function tableName()
    {
        return 'image';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filePath' => 'filePath',
            'itemId' => 'itemId',
            'urlAlias' => 'urlAlias',
        ];
    }

    public function getSrc()
    {
        return $this->filePath;
    }

    public static function getPlaceHolder()
    {
        return self::$placeHolderPath;
    }

    public function afterDelete($model = null)
    {
        unlink($this->filePath);
    }
}