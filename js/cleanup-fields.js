jQuery(document).ready(function ($) {
    function toggleFieldVisibility() {
        // Hide #non-repeated-fields if all inputs inside are empty
        let allEmpty = true;
        $('#non-repeated-fields input').each(function () {
            if ($(this).val().trim() !== '') {
                allEmpty = false;
            }
        });
        if (allEmpty) {
            $('#non-repeated-fields').hide();
        } else {
            $('#non-repeated-fields').show();
        }

        // Hide #repeater-fields if there are no .repeater-field elements
        if ($('#repeater-fields .repeater-field').length === 0) {
            $('#repeater-fields').hide();
        } else {
            $('#repeater-fields').show();
        }

        // Hide #gallery-images if there are no .gallery-image-field elements
        if ($('#gallery-images .gallery-image-field').length === 0) {
            $('#gallery-images').hide();
        } else {
            $('#gallery-images').show();
        }
    }

    // Run check on page load
    toggleFieldVisibility();

    // Run check when inputs change
    $('#non-repeated-fields input').on('input', toggleFieldVisibility);
    $(document).on('click', '.remove-repeater', function () {
        $(this).closest('.repeater-field').remove();
        toggleFieldVisibility();
    });

    $(document).on('click', '.remove-gallery-image', function () {
        $(this).closest('.gallery-image-field').remove();
        toggleFieldVisibility();
    });

    $('.add-repeater, .add-gallery-image').on('click', function () {
        setTimeout(toggleFieldVisibility, 100);
    });
});
