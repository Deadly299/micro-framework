<?php

/* @var $model models\Task */
/* @var $action string */

?>

<div class="row">
    <form action="<?= $action ?>" method="post" enctype=multipart/form-data>
        <div class="col-md-6">
            <div class="form-group">
                <label>Именя пользователя</label>
                <input type="text" value="<?= $model->userName ?>" name="<?= $model::tableName() ?>[userName]"
                       data-role="username"
                       class="form-control"
                       placeholder="Именя пользователя" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" value="<?= $model->email ?>" name="<?= $model::tableName() ?>[email]"
                       data-role="email"
                       class="form-control"
                       placeholder="E-mail" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <textarea class="form-control" name="<?= $model::tableName() ?>[text]"
                          data-role="text"
                          required
                          rows="6"><?= $model->text ?></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="checkbox">
                <label>
                    <input name="<?= $model::tableName() ?>[status]" type="hidden" value="0">
                    Статус
                    <input name="<?= $model::tableName() ?>[status]"
                           data-role="status"
                           type="checkbox" <?= $model->status ? 'checked' : null ?> value="1">
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <?= \widgets\gallery\Gallery::widget(['model' => $model]) ?>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Изображение</label>
                <input name="image" type="file" <?= $model->isNewRecord ? 'required' : null ?>>
            </div>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Сохранить</button>
            <?php if ($model->isNewRecord) { ?>
                <span class="btn btn-primary" data-role="preview-btn">Предварительный просмотр</span>
            <?php } ?>
            <a class="btn btn-default" href="<?= \helpers\Url::to('task/index') ?>">Отменить</a>
        </div>
    </form>
    <div data-role="modal-place"></div>
</div>