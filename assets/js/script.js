function validarFormLogin() {
    form = document.nFormLogin;
    if (null_or_empty("iUsuario")
        || null_or_empty("iSenha")) {
        $(form).addClass('was-validated');
    } else {
        form.submit();
    }

}
function validarFormNewPassword() {
    form = document.formNewPassword;
    if (null_or_empty("iEmail")) {
        $(form).addClass('was-validated');
    } else {
        form.submit();
    }

}

function null_or_empty(str) {
    var v = document.getElementById(str).value;
    return v == null || v == "";
}