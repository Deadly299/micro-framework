<?php

use app\AccessControl;
use helpers\Request;
use helpers\Url;
use models\Image;
use widgets\sortingPanel\SortingField;

?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Изображение</th>
        <th>
            <?php SortingField::widget(['field' => 'userName', 'fieldName' => 'Имя']) ?>
        </th>
        <th>E-mail</th>
        <th>Текст</th>
        <th>
            <?php SortingField::widget(['field' => 'status', 'fieldName' => 'Статус']) ?>
        </th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($models) { ?>
        <?php foreach ($models as $number => $task) { ?>
            <?php $image = $task->getImage(); ?>
            <tr>
                <td><?= ++$number ?></td>
                <td>
                    <img src="<?= $image ? $image->getSrc() : Image::getPlaceHolder() ?>" width="60px" href="60px">
                </td>
                <td><?= $task->userName ?></td>
                <td><?= $task->email ?></td>
                <td><?= mb_substr($task->text, 0, 50, 'utf-8') ?></td>
                <td>
                    <span class="label label-<?= $task->status ? 'success' : 'default' ?>"><?= $task->status ? 'Выполнена' : 'В работе' ?></span>

                </td>
                <td>
                    <a href="<?= \helpers\Url::to('task/update', ['id' => $task->id]) ?>">
                        <span class="glyphicon glyphicon-pencil btn-sm btn-primary"></span>
                    </a>
                    <?php if (!AccessControl::$isGuest) { ?>
                        <a href="<?= \helpers\Url::to('task/delete', ['id' => $task->id]) ?>">
                            <span class="glyphicon glyphicon-trash btn-sm btn-danger"></span>
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
<?php if ($totalPages > 1) { ?>
    <ul class="pagination">
        <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
            <?php
            $params = [];
            $params['page'] = $page;
            if ($sort = Request::get('sort')) {
                $params['sort'] = $sort;
            }
            ?>
            <li <?= (Request::get('page') == $page) || (($page == 1) && (!Request::get('page'))) ? 'class="active"' : null ?>>
                <a href="<?= Url::to('task/index', $params) ?>" class="links">
                    <?= $page ?>
                </a>
            </li>

        <?php } ?>
    </ul>
<?php } ?>
