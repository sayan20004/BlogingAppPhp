document.addEventListener('DOMContentLoaded', function () {

    const profileImageInput = document.getElementById('profile_image_input');
    const imagePreviewContainer = document.getElementById('image_preview_container');
    const defaultImage = imagePreviewContainer.innerHTML; 


    if (profileImageInput && imagePreviewContainer) {
        profileImageInput.addEventListener('change', function (event) {
            const file = event.target.files[0]; 

            if (file) {

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function (e) {

                        const img = document.createElement('img');
                        img.src = e.target.result; 
                        img.alt = "Profile Preview";

                        img.className = "w-24 h-24 rounded-full object-cover border-4 border-gray-600";


                        imagePreviewContainer.innerHTML = ''; 
                        imagePreviewContainer.appendChild(img);
                    }


                    reader.readAsDataURL(file);
                } else {

                    console.error("Selected file is not an image.");

                    imagePreviewContainer.innerHTML = defaultImage;
                }
            } else {

                imagePreviewContainer.innerHTML = defaultImage;
            }
        });
    }


    const cancelButton = document.getElementById('cancelButton'); 
     if (cancelButton && imagePreviewContainer) {
         cancelButton.addEventListener('click', function() {

             if (profileImageInput) { 
                profileImageInput.value = ''; 
                imagePreviewContainer.innerHTML = defaultImage; 
             }
         });
     }
});