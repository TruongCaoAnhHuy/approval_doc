const $ = document.querySelector.bind(document);

const formLoginQR = $('#form_login_qr') ? $('#form_login_qr') : ''
const passwordInput = $('#password')

formLoginQR.onsubmit = (e) => {
    var originalString = passwordInput.value;
    var encryptedString = encryptMD5(originalString);

    passwordInput.value = encryptedString;
}

function encryptMD5(input) {
    var encrypted = CryptoJS.MD5(input);
    return encrypted.toString();
}

// uppercase input
const usernameInput = $('#user_name_input');
usernameInput.oninput = () => {
    usernameInput.value = usernameInput.value.toUpperCase();
}