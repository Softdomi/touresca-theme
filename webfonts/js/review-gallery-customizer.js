jQuery(document).ready(function ($) {
    wp.customize.control('review_gallery', function (control) {
        let addReviewButton = $('<button type="button" class="button">Add Review</button>');
        let reviewsContainer = $('<div class="review-container"></div>');

        control.container.append(addReviewButton).append(reviewsContainer);

        let existingReviews = JSON.parse(wp.customize("review_gallery").get() || "[]");

        existingReviews.forEach(review => {
            addReviewForm(review);
        });

        // Add a new review dynamically
        addReviewButton.on("click", function () {
            addReviewForm();
        });

        function addReviewForm(review = {}) {
            let reviewForm = $('<div class="review-form"></div>');
            let ratingInput = $('<input type="number" min="1" max="5" placeholder="Rating (1-5)" value="' + (review.rating || '') + '">');
            let descriptionInput = $('<textarea placeholder="Review Description">' + (review.description || '') + '</textarea>');
            let imageUploadButton = $('<button type="button" class="button">Add Images</button>');
            let imagePreview = $('<div class="image-preview"></div>');
            let removeReviewButton = $('<button type="button" class="remove-review button">Remove Review</button>');

            if (review.images) {
                review.images.forEach(url => addImagePreview(url, imagePreview));
            }

            imageUploadButton.on("click", function (e) {
                e.preventDefault();
                let frame = wp.media({
                    title: "Select Images",
                    multiple: true,
                    library: { type: "image" },
                    button: { text: "Use Selected Images" },
                });

                frame.on("select", function () {
                    let selection = frame.state().get("selection");
                    let imageUrls = review.images || [];

                    selection.each(function (attachment) {
                        let url = attachment.toJSON().url;
                        imageUrls.push(url);
                        addImagePreview(url, imagePreview);
                    });

                    review.images = imageUrls;
                    saveReviews();
                });

                frame.open();
            });

            removeReviewButton.on("click", function () {
                reviewForm.remove();
                existingReviews = existingReviews.filter(r => r !== review);
                saveReviews();
            });

            reviewForm.append(ratingInput)
                .append(descriptionInput)
                .append(imageUploadButton)
                .append(imagePreview)
                .append(removeReviewButton);

            reviewsContainer.append(reviewForm);

            ratingInput.on("change", function () {
                review.rating = $(this).val();
                saveReviews();
            });

            descriptionInput.on("input", function () {
                review.description = $(this).val();
                saveReviews();
            });

            existingReviews.push(review);
            saveReviews();
        }

        function addImagePreview(url, container) {
            let imageContainer = $('<div class="gallery-image"></div>');
            let img = $('<img src="' + url + '" style="width: 80px; margin: 5px;">');
            let removeButton = $('<button type="button" class="remove-image button">×</button>');

            removeButton.on("click", function () {
                imageContainer.remove();
                existingReviews.forEach(review => {
                    review.images = review.images.filter(imgUrl => imgUrl !== url);
                });
                saveReviews();
            });

            imageContainer.append(img).append(removeButton);
            container.append(imageContainer);
        }

        function saveReviews() {
            wp.customize("review_gallery").set(JSON.stringify(existingReviews));
        }
    });
});
