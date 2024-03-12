// ------------------
// NOTIFICATIONS
// ------------------
const notificationsContainer = document.getElementById('notifications');

function createNotification(content, classType = '', showInSeconds = 10) {
    const notificationElementDiv = document.createElement('div');
    notificationElementDiv.className = 'notification ' + classType;
    
    // Paragraph (content)
    const paragraphElement = document.createElement('p');
    paragraphElement.innerText = content;
    notificationElementDiv.appendChild(paragraphElement);
    
    // Close button
    const closeButtonContainer = document.createElement('div');
    closeButtonContainer.className = 'close-button-container';
    
    const closeButtonElement = document.createElement('button');
    closeButtonElement.className = 'close-button';
    closeButtonElement.innerHTML = notificationCloseButtonHTML;
    closeButtonElement.addEventListener('click', () => destroyNotification(notificationElementDiv));
    
    closeButtonContainer.appendChild(closeButtonElement);
    notificationElementDiv.appendChild(closeButtonContainer);
    
    // Add everything
    notificationsContainer.insertBefore(notificationElementDiv, notificationsContainer.firstChild);
    
    setTimeout(() => notificationElementDiv.classList.add('shown'), 10);
    setTimeout(() => destroyNotification(notificationElementDiv), showInSeconds*1000);
}

function destroyNotification(notification) {
    notification.classList.remove('shown');
    setTimeout(() => notification.remove(), 500);
}

// -------
// BODY OVERFLOW
// -------
function disableBodyOverflow() {
    document.body.style.overflow = 'hidden';
}

function enableBodyOverflow() {
    document.body.style.overflow = 'unset';
}

// -------
// OVERLAY
// -------
const overlay = document.getElementById('overlay');
overlay.addEventListener('click', () => {
    reset(false);
});

function enableOverlay(zIndex) {
    overlay.classList.add('active');
    
    if (zIndex === undefined) {
        zIndex = 5;
    }
    
    overlay.style.zIndex = '' + zIndex;
}

function disableOverlay(instant) {
    overlay.classList.remove('active');
    
    if (instant === undefined) {
        instant = false;
    }
    
    if (instant) {
        overlay.style.zIndex = '5'; // Default value, the navbar will be on top
    } else {
        // Wait for CSS animation
        setTimeout(() => {
            overlay.style.zIndex = '5'; // Default value, the navbar will be on top
        }, 300);
    }
}

// ---------------
// NAVIGATION LOGO
// ---------------
const navigationLogoAnchor = document.getElementById('navigation-logo-anchor');
navigationLogoAnchor.addEventListener('click', (event) => {
    // If we are on the home page, clicking on the logo will scroll to the top of the page.
    // Otherwise, it will redirect to the homepage.
    if (window.location.href.endsWith('/home')) {
        window.scrollTo(0, 0);
        event.preventDefault();
    }
});

// -----------------
// NAVIGATION SEARCH
// -----------------
const navigationSearchForm = document.getElementById('navigation-search-form');
const navigationSearchButton = document.getElementById('navigation-search-button');
const navigationSearchInput = document.getElementById('nav-search-input');

navigationSearchButton.addEventListener('click', (event) => {
    if (window.innerWidth <= 999) {
        if (!navigationSearchForm.classList.contains('mobile-active')) {
            enterMobileNavigationSearch();
            event.preventDefault();
            return;
        }
    }
    
    if (navigationSearchInput.value.trim() === ''){
        event.preventDefault();
    }
});

function enterMobileNavigationSearch() {
    navigationSearchForm.classList.add('mobile-active');
    disableBodyOverflow();
    enableOverlay();
    navigationSearchInput.focus();
}

function leaveMobileNavigationSearch(instant) {
    navigationSearchForm.classList.remove('mobile-active');
    enableBodyOverflow();
    disableOverlay(instant);
}

// ----------------
// MOBILE SIDE MENU
// ----------------
const mobileMenuDiv = document.getElementById('mobile-menu');

document.getElementById('navigation-profile-button').addEventListener('click', () => enterMobileMenu());
document.getElementById('mobile-menu-close-button').addEventListener('click', () => leaveMobileMenu(false));

function enterMobileMenu() {
    if (window.innerWidth >= 1000)
        return;
    
    mobileMenuDiv.classList.add('active');
    enableOverlay(20);
    disableBodyOverflow();
}

function leaveMobileMenu(instant) {
    mobileMenuDiv.classList.remove('active');
    enableBodyOverflow();
    disableOverlay(instant);
}

// ----------------
// NAVIGATION DROPDOWN PROFILE MENU
// ----------------
const dropdownTrigger = document.getElementById('navigation-profile-dropdown-button');
const profileDropdown = document.getElementById('profile-dropdown');

if (dropdownTrigger !== null && profileDropdown !== null) {
    dropdownTrigger.addEventListener('click', () => {
        if (profileDropdown.classList.contains('active')) {
            leaveProfileDropdown();
        } else {
            enterProfileDropdown();
        }
    })
    
    const profileDiv = document.querySelector('.profile');
    
    if (profileDiv !== null) {
        document.addEventListener('click', (event) => {
            if (!profileDiv.contains(event.target)) {
                leaveProfileDropdown();
            }
        })
    }
}

function enterProfileDropdown() {
    if (profileDropdown !== null)
        profileDropdown.classList.add('active');
}

function leaveProfileDropdown() {
    if (profileDropdown !== null)
        profileDropdown.classList.remove('active');
}

// ------
// MODALS
// ------
function openModal(id) {
    const modal = document.getElementById(id);
    
    if (modal === null)
        return;
    
    modal.onclick = () => closeModal(id);
    
    const modalContent = modal.querySelector('.modal-content');
    
    if (modalContent !== null) {
        modalContent.addEventListener('click', (event) => event.stopPropagation());
        
        const closeButton = modal.querySelector('.modal-close-button');
        
        if (closeButton !== null) {
            closeButton.onclick = () => closeModal(id);
        }
    }
    
    // Close all menus when opening modals (with classes)
    mobileMenuDiv.classList.remove('active');
    
    modal.classList.add('opened');
    enableOverlay(20);
    disableBodyOverflow();
}

function closeModal(id, instant) {
    const modal = document.getElementById(id);
    
    if (modal === null)
        return;
    
    modal.classList.remove('opened');
    disableOverlay(instant);
    enableBodyOverflow();
}

function closeAllModals(instant) {
    const modals = document.getElementsByClassName('modal');
    
    for (const modal of modals) {
        closeModal(modal.id, instant);
    }
}

// --------------
// MODAL TRIGGERS
// --------------
addModalTrigger('trigger-register', 'register-modal');
addModalTrigger('trigger-login', 'login-modal');

function addModalTrigger(className, modalId) {
    const elements = document.getElementsByClassName(className);
    
    for (const element of elements) {
        element.addEventListener('click', () => openModal(modalId));
    }
}


// ------
// RESET
// ------
window.addEventListener('resize', () => {
    reset(false);
});

function reset(instant) {
    leaveMobileNavigationSearch(instant);
    leaveMobileMenu(instant);
    leaveProfileDropdown();
    closeAllModals(instant);
}

// --------------
// INPUTS COMMONS
// --------------
const inputFieldDivs = document.getElementsByClassName('input-field');
let inputInfoMessageDivs = [];
let passwordInput = null;

for (const inputFieldDiv of inputFieldDivs) {
    const inputElement = inputFieldDiv.querySelector('input');
    
    if (inputElement === null)
        continue;
    
    handleInputInfoMessages(inputFieldDiv, inputElement);
    handleInputSubLabel(inputFieldDiv, inputElement);
    
    let editable = inputFieldDiv.className.includes('modification-input');
    
    if (editable) {
        if (inputFieldDiv.className.includes('username-input-field')) {
            handleUsernameInput(inputFieldDiv, inputElement);
        } else if (inputFieldDiv.className.includes('email-input-field')) {
            handleEmailInput(inputFieldDiv, inputElement);
        } else if (inputFieldDiv.className.includes('password-input-field')) {
            handlePasswordInput(inputFieldDiv, inputElement);
            passwordInput = inputElement;
        } else if (inputFieldDiv.className.includes('password-confirm-input-field')) {
            handlePasswordConfirmInput(inputFieldDiv, inputElement);
        }
    } else {
        inputElement.addEventListener('input', () => {
            if (isEmptyOrSpaces(inputElement.value)) {
                inputElement.classList.remove('valid');
            } else {
                inputElement.classList.add('valid');
            }
        });
    }
}

function setInputError(inputFieldDiv, inputElement, message) {
    const inputInformationDiv = inputFieldDiv.querySelector('.input-information');
    
    if (inputInformationDiv === null)
        return;
    
    if (message !== null) {
        let errorMessage = inputInformationDiv.querySelector('.error-message');
        
        if (errorMessage === null) {
            errorMessage = document.createElement('div');
            errorMessage.className = 'error-message';
            inputInformationDiv.insertBefore(errorMessage, inputInformationDiv.firstChild);
        } else {
            errorMessage.innerHTML = '';
        }
        
        const messageElement = document.createElement('p');
        messageElement.innerHTML = message;
        
        errorMessage.appendChild(messageElement);
    }
    
    inputElement.classList.remove('success');
    inputElement.classList.add('error');
}

function removeInputError(inputFieldDiv) {
    const inputInformationDiv = inputFieldDiv.querySelector('.input-information');
    
    if (inputInformationDiv === null)
        return;
    
    let errorMessage = inputInformationDiv.querySelector('.error-message');
    
    if (errorMessage !== null) {
        errorMessage.remove();
    }
}

function setInputSuccess(inputFieldDiv, inputElement) {
    removeInputError(inputFieldDiv);
    inputElement.classList.add('success');
}

function removeColors(inputElement) {
    inputElement.classList.remove('success');
    inputElement.classList.remove('error');
}

function handleInputInfoMessages(inputFieldDiv, inputElement) {
    const infoMessageDiv = inputFieldDiv.querySelector('.info-message');
    
    if (infoMessageDiv === null)
        return;
    
    inputInfoMessageDivs.push(infoMessageDiv);
    
    inputElement.addEventListener('focusin', () => {
        for (const inputInfoMsgDiv of inputInfoMessageDivs) {
            if (inputInfoMsgDiv !== infoMessageDiv) {
                inputInfoMsgDiv.style.display = 'none';
            }
        }
        
        infoMessageDiv.style.display = 'block';
    });
}

function handleInputSubLabel(inputFieldDiv, inputElement) {
    // Handle sublabel if exists
    const subLabel = inputFieldDiv.querySelector('.sub-label');
    
    if (subLabel === null)
        return;
    
    // Counter
    const counter = subLabel.querySelector('.counter');
    
    if (counter !== null) {
        let maxSize = '';
        
        if (inputElement.maxLength > 0) {
            maxSize = '/' + inputElement.maxLength;
        }
        
        const updateCounter = () => {
            counter.innerHTML = inputElement.value.length + maxSize;
        }
        
        inputElement.addEventListener('input', () => updateCounter());
        updateCounter();
    }
    
    // Password toggle
    const passwordToggle = subLabel.querySelector('.password-toggle');
    
    if (passwordToggle !== null) {
        passwordToggle.addEventListener('click', () => {
            if (inputElement.type === 'text') {
                inputElement.type = 'password';
                passwordToggle.innerHTML = inputSettings.password.toggle.show;
            } else if (inputElement.type === 'password') {
                inputElement.type = 'text';
                passwordToggle.innerHTML = inputSettings.password.toggle.hide;
            }
        });
    }
    
    // Input padding
    const updateInputPadding = () => {
        inputElement.style.paddingRight = subLabel.offsetWidth + 'px';
    }
    
    inputElement.addEventListener('input', () => updateInputPadding());
    updateInputPadding();
}

function isEmptyOrSpaces(str){
    return str === null || str.match(/^ *$/) !== null;
}

function isPreValid(value, iSettings, inputFieldDiv, inputElement, ignoreSizes = false) {
    if (isEmptyOrSpaces(value)) {
        setInputError(inputFieldDiv, inputElement, iSettings.errorMessages.empty);
        inputElement.classList.remove('valid');
        return false;
    }
    
    if (!ignoreSizes) {
        if (value.length < iSettings.minSize) {
            setInputError(inputFieldDiv, inputElement, iSettings.errorMessages.tooShort);
            inputElement.classList.remove('valid');
            return false;
        }
        
        if (value.length > iSettings.maxSize) {
            setInputError(inputFieldDiv, inputElement, iSettings.errorMessages.tooLong);
            inputElement.classList.remove('valid');
            return false;
        }
    }
    
    return true;
}

// --------------
// USERNAME INPUT
// --------------
let lastUsername = null;

function handleUsernameInput(inputFieldDiv, inputElement) {
    inputElement.addEventListener('focusout', () => {
        const value = inputElement.value;
        
        if (lastUsername === value) {
            return;
        }
        
        lastUsername = value;
        
        if (!isPreValid(value, inputSettings.username, inputFieldDiv, inputElement)) {
            return;
        }
        
        api_GET('verify_username/' + value).then((data) => {
            if (data.error) {
                setInputError(inputFieldDiv, inputElement, inputSettings.username.errorMessages.server);
                inputElement.classList.remove('valid');
                return;
            }
            
            if (data.isValid) {
                if (data.isTaken) {
                    setInputError(inputFieldDiv, inputElement, inputSettings.username.errorMessages.taken);
                    return;
                }
                
                setInputSuccess(inputFieldDiv, inputElement);
                inputElement.classList.add('valid');
            } else {
                setInputError(inputFieldDiv, inputElement, inputSettings.username.errorMessages.invalid);
                inputElement.classList.remove('valid');
            }
        }).catch((err) => {
            setInputError(inputFieldDiv, inputElement, inputSettings.username.errorMessages.server);
            inputElement.classList.remove('valid');
        });
    });
}

// -----------
// EMAIL INPUT
// -----------
let lastEmail = null;

function handleEmailInput(inputFieldDiv, inputElement) {
    inputElement.addEventListener('focusout', () => {
        console.log('focusout handle email')
        const value = inputElement.value;
        
        if (lastEmail === value) {
            return;
        }
        
        lastEmail = value;
        
        if (!isPreValid(value, inputSettings.email, inputFieldDiv, inputElement)) {
            return;
        }
        
        api_GET('verify_email/' + value).then((data) => {
            if (data.error) {
                setInputError(inputFieldDiv, inputElement, inputSettings.email.errorMessages.server);
                inputElement.classList.remove('valid');
                return;
            }
            
            if (data.isValid) {
                if (data.isTaken) {
                    setInputError(inputFieldDiv, inputElement, inputSettings.email.errorMessages.taken);
                    inputElement.classList.remove('valid');
                    return;
                }
                
                setInputSuccess(inputFieldDiv, inputElement);
                inputElement.classList.add('valid');
            } else {
                setInputError(inputFieldDiv, inputElement, inputSettings.email.errorMessages.invalid);
                inputElement.classList.remove('valid');
            }
        }).catch((err) => {
            setInputError(inputFieldDiv, inputElement, inputSettings.email.errorMessages.server);
            inputElement.classList.remove('valid');
        });
    });
}

// --------------
// PASSWORD INPUT
// --------------
let lastPasswordStrengthPoints = -1;

function handlePasswordInput(inputFieldDiv, inputElement) {
    inputElement.addEventListener('input', () => {
         let currentPasswordStrengthPoints = getPasswordStrengthPoints(inputElement.value);
         
         if (lastPasswordStrengthPoints === currentPasswordStrengthPoints)
             return;
         
         const passwordIndicator = inputFieldDiv.querySelector('.password-indicator');
         
         if (passwordIndicator === null)
             return;
        
         const textElement = passwordIndicator.querySelector('.text');
         const barElement = passwordIndicator.querySelector('.bar');
         
         if (textElement === null || barElement === null)
             return;
         
         let strengthKey = 'tooRisky';
         let barPercentage = '0';
         
         switch (currentPasswordStrengthPoints) {
             case 4:
                 barPercentage = '100%';
                 strengthKey = 'veryStrong';
                 break;
                 
             case 3:
                 barPercentage = '75%';
                 strengthKey = 'strong';
                 break;
                 
             case 2:
                 barPercentage = '50%';
                 strengthKey = 'correct';
                 break;
                 
             case 1:
                 barPercentage = '25%';
                 strengthKey = 'risky';
                 break;
             
             case 0:
                 barPercentage = '0%';
                 strengthKey = 'tooRisky';
                 break;
         }
        
         passwordIndicator.className = 'password-indicator ' + strengthKey;
         textElement.innerHTML = inputSettings.password.strengthMessages[strengthKey];
         barElement.style.width = barPercentage;
    });
    
    inputElement.addEventListener('focusout', () => {
        if (!isPreValid(inputElement.value, inputSettings.password, inputFieldDiv, inputElement)) {
            return;
        }
        
        setInputSuccess(inputFieldDiv, inputElement);
        inputElement.classList.add('valid');
    });
}

/*
0 = Very risky
1 = Risky
2 = OK
3 = Good
4 = Very good
 */
function getPasswordStrengthPoints(value) {
    if (isEmptyOrSpaces(value)) {
        return 0;
    }
    
    if (value < inputSettings.email.minSize) {
        return 0;
    }
    
    let points = 0;
    
    // Special characters (+1)
    const specialCharactersRegexp = /[!@#$%^&*(),.?":{}|<>]/;
    if (specialCharactersRegexp.test(value)) {
        points++;
    }
    
    // Uppercase (+1)
    const uppercaseRegexp = /[A-Z]/;
    if (uppercaseRegexp.test(value)) {
        points++;
    }
    
    // Numbers (+1)
    const numbersRegexp = /\d/;
    if (numbersRegexp.test(value)) {
        points++;
    }
    
    // More than 20 (+1)
    if (value.length >= 20) {
        points++;
    }
    
    return points;
}

// ----------------------
// PASSWORD CONFIRM INPUT
// ----------------------
function handlePasswordConfirmInput(inputFieldDiv, inputElement) {
    if (passwordInput === null)
        return;
    
    inputElement.addEventListener('focusout', () => {
        if (inputElement.value === passwordInput.value) {
            setInputSuccess(inputFieldDiv, inputElement);
            inputElement.classList.add('valid');
        } else {
            setInputError(inputFieldDiv, inputElement, inputSettings.password.errorMessages.confirmDifferent);
            inputElement.classList.remove('valid');
        }
    })
}

//
// FORMS
//
const forms = document.querySelectorAll('form');
for (const form of forms) {
    let submitButton = form.querySelector('.submit-button');
    
    if (submitButton === null)
        continue;
    
    const inputs = form.querySelectorAll('input');
    for (const input of inputs) {
        if (input.type === 'checkbox') {
            input.addEventListener('click', () => {
                validateForm(inputs, submitButton);
            });
        } else {
            input.addEventListener('input', () => {
                validateForm(inputs, submitButton);
            });
            
            input.addEventListener('focusout', () => {
                validateForm(inputs, submitButton);
            });
        }
    }
    
    switch (form.name) {
        case 'register-form':
            form.addEventListener('submit', (event) => registerForm(event, form));
            break;
            
        case 'login-form':
            form.addEventListener('submit', (event) => loginForm(event, form));
            break;
        
        default:
            break;
    }
}

function validateForm(inputs, submitButton) {
    let formValid = true;
    
    for (const input of inputs) {
        if (input.type === 'checkbox') {
            if (input.required && !input.checked) {
                formValid = false;
            }
        } else {
            if (!input.className.includes('valid')) {
                formValid = false;
            }
        }
    }
    
    if (formValid) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

function registerForm(event, form) {
    event.preventDefault();
    
    const username = getInputValue(form, 'register-username');
    const email = getInputValue(form, 'register-email');
    const password = getInputValue(form, 'register-password');
    const tos = getInputValue(form, 'register-tos');
    
    const data = {
        username: username,
        email: email,
        password: password,
        tos: tos
    }
    api_POST('register/', data).then((data) => {
        if (data.success) {
            // DO NOT USE location.reload(), it causes the page to re-send the POST
            location.href = location.href;
        } else {
            reset();
            createNotification(internalError, 'error');
        }
    }).catch((err) => {
        reset();
        createNotification(internalError, 'error');
    });
}

function loginForm(event, form) {
    event.preventDefault();
    
    const email = getInputValue(form, 'login-email');
    const password = getInputValue(form, 'login-password');
    
    const data = {
        email: email,
        password: password
    }
    
    const generalError = document.querySelector('.general-error');
    generalError.style.display = 'none';
    
    api_POST('login/', data).then((data) => {
        if (data.success) {
            // DO NOT USE location.reload(), it causes the page to re-send the POST
            location.href = location.href;
        } else {
            if (data.details) {
                if (data.details === 'mail') {
                    generalError.innerText = loginErrorMessages.mail;
                } else if (data.details === 'password') {
                    generalError.innerText = loginErrorMessages.password;
                }
            } else {
                reset();
                createNotification(internalError, 'error');
                return;
            }
            
            generalError.style.display = 'block';
        }
    }).catch((err) => {
        reset();
        createNotification(internalError, 'error');
    });
}

function getInputValue(form, inputId) {
    const input = form.querySelector('#' + inputId);
    
    if (input === null)
        return '';
    
    if (input.type === 'checkbox') {
        return input.checked;
    }
    
    return input.value;
}

// ---
// API
// ---
function getApiUrl(url) {
    return apiEndpoint + url;
}

async function api_GET(url = '') {
    const response = await fetch(getApiUrl(url), {
        method: "GET",
        mode: "cors",
        cache: "no-cache",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json",
        },
        redirect: "follow",
        referrerPolicy: "no-referrer"
    });
    
    return response.json();
}

async function api_POST(url = '', data = {}) {
    const response = await fetch(getApiUrl(url), {
        method: "POST",
        mode: "cors",
        cache: "no-cache",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json",
        },
        redirect: "follow",
        referrerPolicy: "no-referrer",
        body: JSON.stringify(data)
    });
    
    return response.json();
}