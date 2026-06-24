let cropper;
let croppedImageBlob = null;
let selectedFiles = [];
let existingImages = [];

$(document).ready(function () {

    // Single Image Upload - Cropper Logic
    $('#uploadBtn').click(function () {
        $('#imageUpload').click();
    });

    // Handle file input change
    $('#imageUpload').change(function (e) {
        handleSingleImageUpload(e.target);
    });

    // Handle zoom slider change
    $('#zoomSlider').on('input', function () {
        const zoomLevel = $(this).val();
        $('#zoomValue').text(zoomLevel);
        if (cropper) {
            cropper.zoomTo(zoomLevel);
        }
    });

    // Handle rotate slider change
    $('#rotateSlider').on('input', function () {
        const rotateAngle = $(this).val();
        $('#rotateValue').text(rotateAngle);
        if (cropper) {
            cropper.rotateTo(rotateAngle);
        }
    });

    $('#closeModal').click(function () {
        $('#cropperModal').hide();
    });

    // Trigger file input for multiple image upload
    $('#uploadMultipleBtn').click(function () {
        $('#imageUploadMultiple').click();
    });

    // Handle multiple image upload
    $('#imageUploadMultiple').change(function (e) {
        handleMultipleImageUpload(e.target.files);
    });

    // Remove image from preview and form submission for multi-image upload
    $('#imagePreviewContainer').on('click', '.remove-btn', function () {
        const fileName = $(this).data('file');

        // Remove the file from the preview
        $(this).closest('.image-preview').remove();

        // Remove the file from the selectedFiles array
        selectedFiles = selectedFiles.filter(file => file.name !== fileName);
        existingImages = existingImages.filter(file => file !== fileName);

        // If using a hidden input to store the files, update the input (optional)
        updateFileInput();
    });

    if ($('#updateForm').length) {
        initializeExistingImages();
    }

});

function handleSingleImageUpload(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Check file size (no more than 1MB)
        if (file.size > 5 * 1024 * 1024) {
            alert("File size exceeds 5MB. Please upload a smaller image.");
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            const img = new Image();

            img.onload = function () {
                // Check image dimensions (must be at least 300x300)
                if (img.width >= 300 && img.height >= 300) {

                    // Set image to the cropper modal
                    $('#cropperImage').attr('src', e.target.result);
                    $('#cropperModal').show();

                    // Initialize or reset Cropper instance
                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(document.getElementById('cropperImage'), {
                        aspectRatio: 1,
                        viewMode: 1,
                        scalable: false,
                        wheelZoom: false,
                        cropBoxResizable: true,
                        ready: function () {
                            //
                        }
                    });
                } else {
                    alert("Image dimensions must be at least 300x300 pixels.");
                }
            };

            img.src = e.target.result;
        };

        reader.readAsDataURL(file);
    }
}

$('#cropButton').click(function () {

    // Ensure Compressor.js is defined
    if (typeof Compressor !== "undefined") {

        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 250,
            height: 250
        });

        if (canvas) {
            // Compress the image and set as profile image
            canvas.toBlob(function (blob) {
                // Create a Compressor instance to compress the image
                const compressor = new Compressor(blob, {
                    quality: 0.75, // Compression quality
                    maxWidth: 250, // Set max width
                    maxHeight: 250, // Set max height
                    success(result) {
                        croppedImageBlob = result;
                        const base64Image = URL.createObjectURL(result);
                        $('#profileImage').attr('src', base64Image);
                        $('#cropperModal').hide();
                    },
                    error(err) {
                        console.error("Compression failed:", err);
                    }
                });
            }, 'image/jpeg', 0.8);
        } else {
            alert("Canvas is not supported, cropping failed.");
        }
    } else {
        alert("Something went wrong!");
    }
});

// Handle Save button click to upload the cropped and compressed image
$('#saveBtn').click(function () {
    if (croppedImageBlob) {
        const formData = new FormData();
        formData.append('image', croppedImageBlob, 'profile-image.jpg');

        // Send the image via AJAX to the backend
        $.ajax({
            url: '/account/upload-profile-image',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
            },
            contentType: false,
            processData: false,
            success: function (response) {
                $('#profileImage').attr('src', response.imageUrl);
                $('#cropperModal').hide();
                showAlert('success', 'Success', response.message);
            },
            error: function (xhr, status, error) {
                const errorMessage = xhr.responseJSON?.message || 'Something went wrong. Please try again later.';
                showAlert('error', 'Error', errorMessage);
            }
        });
    } else {
        Swal.fire('Error', 'No image found. Please select an image to upload before proceeding.', 'error');
    }
});

// Function to handle multiple image upload
function handleMultipleImageUpload(files) {
    // Clear previous previews
    // $('#imagePreviewContainer').empty();

    // Add files to the array
    Array.from(files).forEach(function (file) {
        if (!file.type.match('image.*')) {
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert("Some files exceed the size limit of 5MB.");
            return;
        }

        // Compress and preview the image
        new Compressor(file, {
            quality: 0.75,
            maxWidth: 720,
            maxHeight: 720,
            success(result) {
                const imgURL = URL.createObjectURL(result);
                const imgPreview = `<div class="image-preview">
                                        <img src="${imgURL}" class="preview-img" alt="Image Preview">
                                        <button class="remove-btn" data-file="${file.name}">X</button>
                                      </div>`;
                $('#imagePreviewContainer').append(imgPreview);

                const compressedFile = new File([result], file.name, { type: result.type });
                selectedFiles.push(compressedFile);
            },
            error(err) {
                console.error("Compression failed:", err);
            }
        });
    });
}

// Function to initialize existing images from the database
function initializeExistingImages() {
    $('#imagePreviewContainer .image-preview img').each(function () {
        const fileName = $(this).closest('.image-preview').find('.remove-btn').data('file');
        existingImages.push(fileName); // Add to the list of existing images
    });
}

// Update the file input with the current files
function updateFileInput() {
    const dataTransfer = new DataTransfer();

    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });

    $('#imageUploadMultiple')[0].files = dataTransfer.files;
}

// Make sure to update the file input before form submission
$('form#multiImageForm').submit(function (e) {
    updateFileInput();

    // Add existing images as metadata
    $('<input>').attr({
        type: 'hidden',
        name: 'existing_images',
        value: JSON.stringify(existingImages)
    }).appendTo('form');
});