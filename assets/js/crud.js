jQuery(document).ready(function ($) {

    //MASCARA CPF
    $('#cpf, #form-cpf').mask("999.999.999-99");

    //VALIDA CPF
    $('#cpf').focusout(function () {
        if ($("#cpf").val().length > 0) {

            if ($("#cpf").val().length < 14) {
                noty({
                    text: 'CPF Inválido!',
                    layout: 'top',
                    type: 'warning',
                    modal: true,
                    timeout: 4000,
                    onClick: function ($noty) {
                        $noty.close();
                    },
                    callback: {
                        onClose: function () {
                            $("#cpf").focus();
                            $("#cpf").val('');
                        },
                    }
                });
                return false;
            }
            var validarCpf = VerificaCPF($("#cpf").val());
            if (validarCpf === false) {
                noty({
                    text: 'CPF Inválido!',
                    layout: 'top',
                    type: 'warning',
                    modal: true,
                    timeout: 4000,
                    onClick: function ($noty) {
                        $noty.close();
                    },
                    callback: {
                        onClose: function () {
                            $("#cpf").focus();
                            $("#cpf").val('');
                        },
                    }
                });
                return false;
            }
        }
    });

    //MASCARA TELEFONE
    $(".phone-list > input").inputmask({
        mask: ["(99) 9999-9999", "(99) 99999-9999",],
        keepStatic: true
    });

    //ADD TELEFONE
    $("#add-phone").on('click', function () {
        $('.phone-list:last').clone()
            .find("input:text").val("").end()
            .appendTo('#phone-list');
        $('.phone-list:last').find('label').html('');
        $('.phone-list:last').find('input').removeAttr("required");
        $(".phone-list > input").inputmask({
            mask: ["(99) 9999-9999", "(99) 99999-9999",],
            keepStatic: true
        });
    });

    //INSERINDO CLIENTE
    $('#insertClient').on('submit', function (event) {
        event.preventDefault();

        var dataClient = $(this).serialize();
        $.ajax({
            url: 'controller/ControllerInsertClient.php',
            data: dataClient,
            type: 'POST',
            dataType: 'html',
            success: function (msg) {
                noty({
                    text: msg,
                    layout: 'center',
                    type: 'success',
                    timeout: 1000,
                    modal: true,
                    onClick: function ($noty) {
                        $noty.close();
                    },
                    callback: {
                        onClose: function () {
                            // $('#insertClient').trigger("reset");
                            location.reload(true);
                        }
                    }
                });

            }
        });
    });

    //REMOVENDO CLIENTE OU TELEFONE DO CLIENTE
    $('.removeThis').on('click', function (event) {
        event.preventDefault();

        link = $(this).attr('href');
        noty({
            text: 'Tem certeza que deseja remover?',
            layout: 'center',
            modal: true,
            buttons: [
                {
                    addClass: 'btn btn-primary',
                    text: 'Ok',
                    onClick: function ($noty) {
                        $noty.close();

                        $.ajax({
                            url: link,
                            dataType: 'html',
                            success: function (msg) {
                                noty({
                                    text: msg,
                                    layout: 'center',
                                    type: 'success',
                                    timeout: 1000,
                                    modal: true,
                                    onClick: function ($noty) {
                                        $noty.close();

                                    },
                                    callback: {
                                        onClose: function () {
                                            location.reload(true);
                                        }
                                    }
                                });
                            }
                        });

                    }
                },
                {
                    addClass: 'btn btn-danger',
                    text: 'Cancel',
                    onClick: function ($noty) {
                        $noty.close();
                    }
                }
            ]
        });

    })









});

//FUNÇÃO VALIDA CPF
function VerificaCPF(strCpf) {

    var cpf = strCpf.replace('.', '');
    cpf = cpf.replace('.', '');
    cpf = cpf.replace('-', '');

    var erro = new String;
    if (cpf.length < 11) erro += "Sao necessarios 11 digitos para verificacao do CPF! \n\n";
    var nonNumbers = /\D/;
    if (nonNumbers.test(cpf)) erro += "A verificacao de CPF suporta apenas numeros! \n\n";
    if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999") {
        erro += "Numero de CPF invalido!"
    }
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i++) {
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) {
        a[9] = 0
    } else {
        a[9] = 11 - x
    }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) {
        a[10] = 0;
    } else {
        a[10] = 11 - x;
    }
    status = a[9] + "" + a[10]
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])) {
        erro += "Digito verificador com problema!";
    }
    if (erro.length > 0) {
        return false;
    }
    return true;

}