$(document).ready(function () {
    $(".date_serach").datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'dd/mm/yy'
    });
    $('.input-data').mask("00/00/0000");
    $('.input-ano').mask("9999");
    $('.input-numero_lei').mask("00000");
    $('.select2-js').select2({
        width: '100%'
    });
});

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

function validarFormLegislacao() {
    form = document.nFormLegislacao;
    if (null_or_empty("iCategoria")
        || null_or_empty("iEsfera")
        || null_or_empty("iNumero")
        || null_or_empty("iAno")
        || null_or_empty("iData")
        || null_or_empty("iEmenta")
    ) {
        $(form).addClass('was-validated');
    } else {
        form.submit();
    }

}
function validarFormFormularios() {
    form = document.nFormFormularios;
    if (null_or_empty("iCoordenacao")
        || null_or_empty("iTipo")
        || null_or_empty("iData")
        || null_or_empty("iDescricao")
    ) {
        $(form).addClass('was-validated');
    } else {
        form.submit();
    }

}


function null_or_empty(str) {
    var v = document.getElementById(str).value;
    return v == null || v == "";
}