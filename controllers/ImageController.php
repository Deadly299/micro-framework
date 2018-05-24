<?php

namespace controllers;

use app\Controller;
use helpers\Request;
use helpers\Url;
use models\Image;
use models\Task;

class ImageController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->all();

        $this->view->render('index', ['tasks' => $tasks]);
    }

    public function actionCreate()
    {
        $model = new Task(true);

        if ($model->load(Request::post()) && $model->create()) {
            Url::redirect('task/update', ['id' => $model->id]);
        } else {
            $this->view->render('create', ['model' => $model]);
        }
    }

    public function actionDelete()
    {
        $status = 'error';
        if ($id = Request::post('imageId')) {
            if ($model = $this->findModel($id)) {
                $status = 'success';
                $model->delete();
            }
        }
        header('Content-type: application/json');

        echo json_encode(['status' => $status]);
    }

    protected function findModel($id)
    {
        return Image::find()->where(['id' => $id])->one();
    }
}