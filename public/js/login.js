const form = $("#form");

form.on("submit", e => {
    e.preventDefault()

    form.validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6,
            }
        },
        messages: {
            email: {
                required: "Email Obrigatório",
                email: "Email Invalido"
            },
            password: {
                required: "Senha Obrigatoria",
                minlength: "Senha deve ter pelo menos 6 caracteres",
            }
        }
    })

    if (!form.valid()) return;

    $("button").prop("disabled", true);

    $.post({
        url: "api/auth/login",
        contentType: "application/json",
        data: JSON.stringify({
            email: $("#email").val(),
            password: $("#password").val()
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

            Cookies.set("PHPSESSID", data.token);

            setTimeout(() => {
                window.location.href = "/"
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
        },
    })
});