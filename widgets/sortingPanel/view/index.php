<?php

use helpers\Url;

?>

<a href="<?= Url::to('task/index', ['sort' => $field]) ?>"> <?= $fieldName ?></a>