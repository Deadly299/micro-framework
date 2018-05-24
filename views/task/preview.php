
<div id="preview-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Превью</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Именя пользователя</label>
                            <input type="text" value="<?= $dataPost['username'] ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" value="<?= $dataPost['email'] ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea class="form-control" rows="6" disabled><?= $dataPost['text'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                Статус
                                <input type="checkbox" <?= $dataPost['status'] ? 'checked' : null ?>  disabled>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-default">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>