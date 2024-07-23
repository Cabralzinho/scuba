//TODO: Enviar Email de verificação

const form = $("#form");

form.on("submit", e => {
    e.preventDefault()

    form.validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
            },
            email: {
                required: true,
                email: true,
                minlength: 10,
            },
            password: {
                required: true,
                minlength: 6,
            },
            confirmPassword: {
                required: true,
                minlength: 6,
                equalTo: "#password",
            }
        },
        messages: {
            name: {
                required: "Nome Obrigatório",
                minlength: "Nome deve ter pelo menos 3 caracteres",
                maxlength: "Nome deve ter no maximo 30 caracteres",
            },
            email: {
                required: "E-mail Obrigatório",
                email: "E-mail Invalido",
                minlength: "E-mail deve ter pelo menos 10 caracteres",
            },
            password: {
                required: "Senha Obrigatoria",
                minlength: "Senha deve ter pelo menos 6 caracteres",
            },
            confirmPassword: {
                required: "Repita a Senha",
                minlength: "Senha deve ter pelo menos 6 caracteres",
                equalTo: "Senha deve ser igual a anterior",
            }
        }
    })

    if (!form.valid()) return;

    $("button").prop("disabled", true);

    $.post({
        url: "api/auth/register",
        contentType: "application/json",
        data: JSON.stringify({
            name: $("#name").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            confirmPassword: $("#confirmPassword").val()
        }),
        dataType: "json",
        success: (data) => {
            Swal.fire({
                icon: 'success',
                title: data.message,
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            setTimeout(() => {
                window.location.href = "/login"
            }, 1500);
        },
        error: (error) => {
            Swal.fire({
                icon: 'error',
                title: error.responseJSON.message,
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            $("button").prop("disabled", false);

        }
    })
})