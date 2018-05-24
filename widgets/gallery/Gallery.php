<?php

namespace widgets\gallery;

use app\Widget;
use models\Image;

class Gallery extends Widget
{
    public $model;

    public function run()
    {
        if (!$this->model->id) {
            return null;
        }

        $images = Image::find()->where(['itemId' => $this->model->id])->all();

        if ($images) {
            $this->render('view/index', ['images' => $images]);
        }
    }
}