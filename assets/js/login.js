const $ = document.querySelector.bind(document);

const formLogin = $('#form_login') ? $('#form_login') : ''
const passwordInput = $('#password')

formLogin.onsubmit = (e) => {
    var originalString = passwordInput.value;
    var encryptedString = encryptMD5(originalString);

    passwordInput.value = encryptedString;
}

function encryptMD5(input) {
    var encrypted = CryptoJS.MD5(input);
    return encrypted.toString();
}