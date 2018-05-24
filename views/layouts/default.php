<!DOCTYPE html>
<html>
<head>
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="/web/css/bootstrap.min.css">
    <link rel="stylesheet" href="/web/css/style.css">
</head>
<body>
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= \helpers\Url::to('task/index') ?>">Задачник</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if (\app\AccessControl::$isGuest) { ?>
                    <li><a href="<?= \helpers\Url::to('admin/login') ?>">Вход</a></li>
                <?php } else { ?>
                    <li><a href="<?= \helpers\Url::to('admin/logout') ?>">Выход</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="main-container container">
    <?php echo $content; ?>
</div>
</body>
<script src="/web/scripts/jquery.js"></script>
<script src="/web/scripts/script.js"></script>
<script src="/web/scripts/bootstrap.min.js"></script>
</html>