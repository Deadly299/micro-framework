<?php

use app\AccessControl;
use models\Image;
use widgets\sortingPanel\SortingField;

$this->title = 'Главная';

?>

<p>
    <a class="btn btn-md btn-success" href="<?= \helpers\Url::to('task/create') ?>">Новая задача</a>
</p>
<div class="bs-example">
    <?php \widgets\gridView\GridView::widget(['query' => $query, 'limit' => 3]) ?>
</div>