<?php

use app\AccessControl;

$this->title = 'Редактирование задачи';

/* @var $model models\Task */

?>

<?php if(AccessControl::$isGuest) { ?>
    <div class="bs-callout bs-callout-danger">
        <h4>У вас нету прав не редактирование.</h4>
        <p>Пожалуйста, <strong> <a href="<?= \helpers\Url::to('admin/login') ?>"> авторизуйтесь </a></strong></p>
    </div>
<?php } ?>

<?= $this->renderPartial('task/_form', [
    'model' => $model,
    'action' => \helpers\Url::to('task/update', ['id' => $model->id]),
]) ?>
