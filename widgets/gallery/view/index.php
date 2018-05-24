<?php

use app\AccessControl;

?>

<?php if ($images) { ?>
    <?php foreach ($images as $image) { ?>
        <div class="col-sm-3">
            <button type="button"
                    class="close" <?= !AccessControl::$isGuest ? 'data-role="delete-image-btn"' : null ?>
                    data-image-id="<?= $image->id ?>">&times;
            </button>
            <img src="<?= $image->filePath ?>" class="img-thumbnail">
        </div>
    <?php } ?>
<?php } ?>
