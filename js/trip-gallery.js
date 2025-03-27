jQuery(document).ready(function ($) {
    let file_frame;

    $('.add_trip_gallery').on('click', function (e) {
        e.preventDefault();

        if (file_frame) {
            file_frame.open();
            return;
        }

        file_frame = wp.media({
            title: 'Select Images for Gallery',
            button: {
                text: 'Use these images'
            },
            multiple: true
        });

        file_frame.on('select', function () {
            let selection = file_frame.state().get('selection');
            let image_ids = $('#trip_gallery').val() ? $('#trip_gallery').val().split(',') : [];
            let preview_container = $('.trip_gallery_preview');

            selection.each(function (attachment) {
                let image_id = attachment.id;

                // Prevent duplicate images
                if (!image_ids.includes(image_id.toString())) {
                    image_ids.push(image_id);

                    let image_html = `
                        <div class="gallery-image" data-id="${image_id}">
                            <img src="${attachment.attributes.url}" width="100" height="100" style="margin:5px;" />
                            // <button type="button" class="remove_trip_image button">Remove</button>
                        </div>
                    `;

                    preview_container.append(image_html);
                }
            });

            $('#trip_gallery').val(image_ids.join(','));
        });

        file_frame.open();
    });

    // Remove an image when clicking "Remove" button
    $(document).on('click', '.remove_trip_image', function () {
        let imageWrapper = $(this).closest('.gallery-image');
        let imageId = imageWrapper.attr('data-id');

        // Remove image from UI
        imageWrapper.remove();

        // Update hidden field
        let currentImages = $('#trip_gallery').val().split(',').filter(id => id !== imageId);
        $('#trip_gallery').val(currentImages.join(','));
    });
});
