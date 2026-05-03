$(".card-footer button").attr("disabled", true);
$("#txtNombreApi,#txtNombreClase,#txtNombreFront").attr("disabled", true);

$("#txtNombreModulo").on("keyup", function () {
    $("#txtNombreApi").attr("disabled", this.value ? false : true);
});
$("#txtNombreApi").on("keyup", function () {
    $("#txtNombreClase").attr("disabled", this.value ? false : true);
});
$("#txtNombreClase").on("keyup", function () {
    $("#txtNombreFront").attr("disabled", this.value ? false : true);
});
$("#txtNombreFront").on("keyup", function () {
    $(".card-footer button").attr("disabled", this.value ? false : true);
});
$("#btnCrearEstruc").on("click", function () {
    let nomModulo = $("#txtNombreModulo").val();
    let nomAPI = $("#txtNombreApi").val();
    let nomClase = $("#txtNombreClase").val();
    let nomFront = $("#txtNombreFront").val();
    crearEstructura(nomModulo, nomAPI, nomClase, nomFront);
});

$("#btnCancelarEstruc").on("click", function () {
    $(".card-body input").val(null);
    $("#txtNombreApi,#txtNombreClase,#txtNombreFront").attr("disabled", true);
    $(".card-footer button").attr("disabled", true);
});

function crearEstructura(nomModulo, nomAPI, nomClase, nomFront) {
    $.ajax({
        url: '../src/services/index.php',
        async: false,
        type: "POST",
        data: { nomModulo, nomAPI, nomClase, nomFront },
        success: function (response, status, xhr) {
            console.log(response, status, xhr)
            Swal.fire({
                icon: "success",
                title: "Correcto",
                text: "Estructura creada correctamente"
            });
            $(".card-body input").val(null);
            $("#txtNombreApi,#txtNombreClase,#txtNombreFront").attr("disabled", true);
            $(".card-footer button").attr("disabled", true);

            response = JSON.parse(response);
            var link = document.createElement('a');//Creacion de un elemento tipo a
            link.href = response[0];//Creacion de una url con el objeto creado
            link.download = response[1];//Indicamos que el archivo se descargara a partir del nombre del archivo
            link.click();//ejecucion del evento click del elemento a creado

            $.ajax({
                url: '../src/services/deleteFoldersApi.php',
                type: 'GET',
                async: false,
                success: function (response, status, xhr) {
                    console.log(response.status, xhr);
                }
            })
        },
        error: function (response, status, xhr) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: response
            });
        }
    });
}