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
function validarFormLicenca() {
    form = document.nFormLicencaEmitida;
    if (null_or_empty("iLicenca")
        || null_or_empty("iAno")
        || null_or_empty("iNumeroLicenca")
        || null_or_empty("iNumeroProtocolo")
        || null_or_empty("iEmpreendimento")
        || null_or_empty("iTipologia")
    ) {
        $(form).addClass('was-validated');
    } else {
        form.submit();
    }

}
function validarFormTR() {
    form = document.nFormTR;
    if (null_or_empty("iTipo")
        || null_or_empty("iData")
        || null_or_empty("iStatus")
        || null_or_empty("iDescricao")
    ) {
        $(form).addClass('was-validated');
    } else {
        form.submit();
    }

}
function validarFormUsuario() {
    form = document.nFormUsuario;
    if (null_or_empty("iNome")
        || null_or_empty("iNomeCompleto")
        || null_or_empty("iEmail")
        || null_or_empty("iSenha")
        || null_or_empty("iRSenha")
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


/**
 * @author Joab Torres <joabtorres1508@gmail.com>
 * @description Este codigo abaixo é responsável para fazer o carregamento da imagem setada pelo usuário ao muda a foto do perfil
 */

if (document.getElementById("usuario-form")) {
    /**
     * @author Joab Torres <joabtorres1508@gmail.com>
     * @description Este codigo abaixo é responsável para fazer o carregamento da imagem setada pelo usuário ao muda a foto do perfil
     */
    $(function(){
        $("#iAnexo").change(function(){
            const file = $(this)[0].files[0];
            if(file){
                const fileReader = new FileReader;
                fileReader.onloadend = function(){
                    $("#imageUser").css('background-image', 'url('+fileReader.result+')');
                }
                fileReader.readAsDataURL(file);
            }
        });
    });
    /**
     * @author Joab Torres <joabtorres1508@gmail.com>
     * @description Este codigo abaixo é responsável para fazer o carregamento da imagem setada pelo usuário ao muda a foto do perfil
     */
    $(function(){
        $('#imagemPadrao').click(function () {
            console.log('chegou aqui')
            $("#imageUser").css('background-image', 'url("../assets/image/user.png")');
            if ($("#iLinkAnexo").val() !== null) {
                $("#iLinkAnexo").val(null);
            }
            if ($("#iAnexo").val() !== null) {
                $("#iAnexo").val(null);
            }
        });
    })
}