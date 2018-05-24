<?php

$this->title = 'Новая задача';

/* @var $model models\Task */

?>

<?= $this->renderPartial('task/_form', [
    'model' => $model,
    'action' => \helpers\Url::to('task/create'),
]) ?>


