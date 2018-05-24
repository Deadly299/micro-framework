<?php

namespace controllers;

use app\AccessControl;
use app\Controller;
use app\View;
use models\Task;
use helpers\Request;
use helpers\Url;

class TaskController extends Controller
{

    public function actionIndex()
    {
        $query = Task::find()->setOrderBy(Request::get('sort'));

        $this->view->render('index', ['query' => $query]);
    }

    public function actionCreate()
    {
        $model = new Task(true);

        if ($model->load(Request::post()) && $model->create()) {
            Url::redirect('task/update', ['id' => $model->id]);
        }

        $this->view->render('create', ['model' => $model]);

    }

    public function actionUpdate()
    {
        $model = $this->findModel(Request::get('id'));

        if (!AccessControl::$isGuest) {
            if ($model->load(Request::post()) && $model->update()) {
                Url::redirect('task/index');
            }
        }

        $this->view->render('update', ['model' => $model]);
    }

    public function actionDelete()
    {
        $model = $this->findModel(Request::get('id'));
        $model->delete();
        Url::redirect('task/index');
    }

    public function actionPreview()
    {
        $status = 'error';
        if ($dataPost = Request::post()) {
            $status = 'success';
            $content = $this->view->renderAjax('task/preview', ['dataPost' => $dataPost]);
        }
        header('Content-type: application/json');

        echo json_encode(['status' => $status, 'content' => $content]);
    }

    protected function findModel($id)
    {
        if ($model = Task::find()->where(['id' => $id])->one()) {
            return $model;
        }

        View::errorCode(404);
    }
}