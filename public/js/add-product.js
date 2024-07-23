const form = $("#form");
const imageUpload = $('#images');
const imageName = $('#image-name');

$("#categories").on("change", () => {
    let selectedCategories = getSelectedCategories()

    $("#selectedCategories").html("")

    selectedCategories.forEach(category => {
        $("#selectedCategories").append(`<div class="bg-primary selectedCategory">${category}</div>`)
    })
})

const getSelectedCategories = () => {
    let selectedCategories = [];

    $("#categories option:selected").each((i, option) => {
        selectedCategories.push(option.value)
    })

    return selectedCategories
}

const getImages = () => {
    return [...$("#images")[0].files]
}

$('#price').mask('0.000.00', { reverse: true });

imageUpload.on('change', function () {
    const file = imageUpload[0].files[0].name

    imageName.text(file)
})

form.on("submit", e => {
    e.preventDefault()

    form.validate({
        rules: {
            name: {
                required: true,
            },
            price: {
                required: true,
                min: 1
            },
            description: {
                required: true,
                minlength: 6,
            },
            images: {
                required: true
            },
            categories: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Nome Obrigatório",
            },
            price: {
                required: "Preço Obrigatoria",
            },
            description: {
                required: "Descricão Obrigatoria",
                minlength: "Descricão deve ter pelo menos 6 caracteres",
            },
            images: {
                required: "Imagem Obrigatoria",
            },
            categories: {
                required: "Categorias Obrigatorias",
            }
        }
    })

    if (!form.valid()) return;

    $("button").prop("disabled", true);

    const formData = new FormData();

    formData.append("name", $("#name").val())
    formData.append("price", $("#price").val())
    formData.append("description", $("#description").val())
    getSelectedCategories().forEach(category => {
        formData.append("categories[]", category)
    })
    getImages().forEach(image => {
        formData.append("images[]", image)
    })

    $.post({
        url: "/api/products",
        contentType: false,
        processData: false,
        data: formData,
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

            $("#name").val("")
            $("#price").val("")
            $("#description").val("")
            $("#images").val("")
            $("#selectedCategories").html("")
            imageName.text("")

            $("button").prop("disabled", false);
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