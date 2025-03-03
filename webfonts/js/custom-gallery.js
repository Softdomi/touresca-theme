jQuery(document).ready(function ($) {
    // ADD GALLERY IMAGE FIELD
    $('.add-gallery-image').on('click', function () {
        let template = $('#gallery-image-template').html();
        $('#gallery-images').append(template);
    });

    // REMOVE GALLERY IMAGE FIELD
    $(document).on('click', '.remove-gallery-image', function () {
        $(this).closest('.gallery-image-field').remove();
    });

    // IMAGE UPLOADER FOR GALLERY IMAGES
    $(document).on('click', '.upload-gallery-image', function (e) {
        e.preventDefault();
        let button = $(this);
        let imageField = button.siblings('.gallery-image-url');
        let imagePreview = button.siblings('img');

        let frame = wp.media({
            title: 'Select Image',
            button: { text: 'Use this image' },
            multiple: false
        });

        frame.on('select', function () {
            let attachment = frame.state().get('selection').first().toJSON();
            imageField.val(attachment.url);
            imagePreview.attr('src', attachment.url).show();
        });

        frame.open();
    });

    // LOAD EXISTING IMAGES WHEN EDITING
    $('.gallery-image-url').each(function () {
        let url = $(this).val();
        if (url) {
            $(this).siblings('img').attr('src', url).show();
        }
    });
});
