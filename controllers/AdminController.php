<?php

namespace controllers;

use app\Controller;
use helpers\Request;
use helpers\Url;
use models\User;

class AdminController extends Controller {

    public function actionLogin()
    {
        $model = new User(true);

        if($model->load(Request::post()) && $model->login()) {
            Url::redirect('task/index');
        }
        $this->view->layout = 'login';
        $this->view->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        $model = new User(true);
        $model->logout();

        Url::redirect('task/index');
    }
}