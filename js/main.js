
////////////////////////////////////////////////////////////////////////////////////////
// js code for faq accordion 



// subscribe form 
document.querySelector('.subscribe-form form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.email.value;
    
    if (validateEmail(email)) {
        console.log('Email submitted:', email);
        this.reset();
    } else {
        alert('Please enter a valid email address');
    }
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// for categories buttons in blogs page 

        document.addEventListener('DOMContentLoaded', () => {
            // Handle buttons with ".tab-link button"
            document.querySelectorAll('.tab-link button').forEach(button => {
                button.addEventListener('click', function (e) {

                    // Remove 'btn-primary' class from all links
                    document.querySelectorAll('.tab-link button').forEach(button => {
                        button.classList.remove('btn-primary');
                    });

                    // Add 'btn-primary' class to the clicked link
                    this.classList.add('btn-primary');
                });
            });

        });
        jQuery(document).ready(function ($) {
            wp.customize.control('review_gallery', function (control) {
                let uploadButton = $('<button type="button" class="button">Select Review Images</button>');
                let clearButton = $('<button type="button" class="button remove-images">Clear All</button>');
                let preview = $('<div class="review-gallery-preview"></div>');
        
                control.container.append(uploadButton).append(clearButton).append(preview);
        
                uploadButton.on("click", function (e) {
                    e.preventDefault();
                    let frame = wp.media({
                        title: "Select Images",
                        multiple: true,
                        library: { type: "image" },
                        button: { text: "Use Selected Images" },
                    });
        
                    frame.on("select", function () {
                        let selection = frame.state().get("selection");
                        let imageUrls = [];
                        preview.empty();
        
                        selection.each(function (attachment) {
                            let url = attachment.toJSON().url;
                            imageUrls.push(url);
                            preview.append('<img src="' + url + '" style="width: 80px; margin: 5px;">');
                        });
        
                        wp.customize("review_gallery").set(imageUrls.join(","));
                    });
        
                    frame.open();
                });
        
                clearButton.on("click", function () {
                    wp.customize("review_gallery").set("");
                    preview.empty();
                });
        
                wp.customize("review_gallery", function (value) {
                    value.bind(function (newVal) {
                        preview.empty();
                        if (newVal) {
                            let urls = newVal.split(",");
                            urls.forEach(function (url) {
                                preview.append('<img src="' + url + '" style="width: 80px; margin: 5px;">');
                            });
                        }
                    });
                });
        
                // Load existing images on page load
                let existingImages = wp.customize("review_gallery").get();
                if (existingImages) {
                    existingImages.split(",").forEach(function (url) {
                        preview.append('<img src="' + url + '" style="width: 80px; margin: 5px;">');
                    });
                }
            });
        });
        