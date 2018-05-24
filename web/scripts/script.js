if (!!!Deadly299) {
    var Deadly299 = {};
}

Deadly299.image = {
    STATUS_SUCCESS: 'success',
    URL_PREFIX: '/?r=',

    deleteImageBtn: '[data-role=delete-image-btn]',
    previewBtn: '[data-role=preview-btn]',
    actionDeleteImage: 'image/delete',
    actionPreview: 'task/preview',

    init: function () {
        $(document).on('click', Deadly299.image.deleteImageBtn, this.deleteImage);
        $(document).on('click', Deadly299.image.previewBtn, this.previewShow);
    },
    previewShow: function () {
        var data = {},
            username = $('[data-role=username]').val(),
            email = $('[data-role=email]').val(),
            text = $('[data-role=text]').val(),
            status = $('[data-role=status]').val();

        data.username = username;
        data.email = email;
        data.text = text;
        data.status = status;

        $.post(
            Deadly299.image.URL_PREFIX + Deadly299.image.actionPreview,
            data,
            function (response) {
                if (response.status === Deadly299.image.STATUS_SUCCESS) {
                    $('[data-role=modal-place]').html(response.content);
                    $('#preview-modal').modal('show');
                }
            }
        );

    },
    deleteImage: function () {
        var self = this,
            data = {},
            action = Deadly299.image.URL_PREFIX + Deadly299.image.actionDeleteImage,
            imageId = $(self).data('imageId');

        data.imageId = imageId;

        if (confirm('Confirm delete')) {
            $.post(
                action,
                data,
                function (response) {
                    if (response.status === Deadly299.image.STATUS_SUCCESS) {
                        $(self).parent().remove();
                    }
                }
            );
        }
    },

};

Deadly299.image.init();