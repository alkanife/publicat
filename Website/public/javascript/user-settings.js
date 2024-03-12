const inputContainers = document.querySelectorAll('.input-container');

for (const inputContainer of inputContainers) {
    const inputField = inputContainer.querySelector('input');
    
    if (inputField === null)
        continue;
    
    inputField.addEventListener('input', () => {
        inputContainer.classList.remove('error');
    });
}

// Profile picture
const pictureForm = document.getElementById('pictureForm');
const pictureInput = document.getElementById('picture');
const pictureButton = document.getElementById('pictureButton');
const pictureModalButton = document.getElementById('confirmDeletePicture');

pictureButton.addEventListener('click', (event) => {
    if (pictureInput.value === '') {
        event.preventDefault();
        openModal('removePictureModal');
    }
});

pictureModalButton.addEventListener('click', () => {
    pictureForm.requestSubmit(pictureButton);
})

// Banner
const bannerForm = document.getElementById('bannerForm');
const bannerInput = document.getElementById('banner');
const bannerButton = document.getElementById('bannerButton');
const bannerModalButton = document.getElementById('confirmDeleteBanner');

bannerButton.addEventListener('click', (event) => {
    if (bannerInput.value === '') {
        event.preventDefault();
        openModal('removeBannerModal');
    }
});

bannerModalButton.addEventListener('click', () => {
    bannerForm.requestSubmit(bannerButton);
})

// Password
function togglePasswordLabel(toggle, input) {
    const inputElement = document.getElementById(input);
    
    if (inputElement === null)
        return;
    
    if (inputElement.type === 'password') {
        inputElement.type = 'text';
        toggle.innerText = inputSettings.password.toggle.hide;
    } else {
        inputElement.type = 'password';
        toggle.innerText = inputSettings.password.toggle.show;
    }
}



























