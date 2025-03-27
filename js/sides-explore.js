jQuery(document).ready(function ($) {
    function setupGalleryUploader() {
        $('.select-gallery').off('click').on('click', function (e) {
            e.preventDefault();
            let button = $(this);
            let galleryInput = button.siblings('.gallery-images');
            let previewContainer = button.siblings('.gallery-preview');

            let frame = wp.media({
                title: 'Select Images',
                multiple: true,
                library: { type: 'image' },
                button: { text: 'Use these images' }
            });

            frame.on('select', function () {
                let images = frame.state().get('selection').map(function (attachment) {
                    attachment = attachment.toJSON();
                    return attachment.url;
                });

                galleryInput.val(images.join(',')); // Store URLs as a comma-separated list

                previewContainer.html('');
                images.forEach(function (img) {
                    previewContainer.append('<img src="' + img + '" style="width:80px; height:80px; margin:5px;">');
                });
            });

            frame.open();
        });
    }

    $('#add-section').click(function (e) {
        e.preventDefault();
        let index = $('#sides-sections .section').length;
        let newSection = `<div class="section">
            <label>Title:</label><input type="text" name="sides_sections[${index}][title]" style="width:100%;" />
            <label>Places:</label><textarea name="sides_sections[${index}][places]" style="width:100%;"></textarea>
            <label>Gallery:</label>
            <input type="hidden" class="gallery-images" name="sides_sections[${index}][gallery]" value="">
            <button class="button select-gallery">Select Images</button>
            <div class="gallery-preview"></div>
            <button class="remove-section">Remove</button>
        </div>`;
        $('#sides-sections').append(newSection);
        setupGalleryUploader(); // Rebind events to new elements
    });

    $(document).on('click', '.remove-section', function (e) {
        e.preventDefault();
        $(this).parent().remove();
    });

    setupGalleryUploader();
});
