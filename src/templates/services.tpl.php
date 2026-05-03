var Servicios = function () {
    var apiUrl = "{{ApiPath}}/public/"; //TODO URL de los servicios Web
    var activeAjaxRequests = 0; //TODO Cantidad de Petición de AJAX

    this.fnGet = function(callback) {
        if (apiUrl) {
            $.ajax({
                url: apiUrl + "Get",
                beforeSend: function () {
                    activeAjaxRequests++;
                    if (activeAjaxRequests === 1) {
                        Swal.fire({
                            title: "Por favor, espere",
                            html: '<strong>Cargando...</strong>\
                                <div class="text-center">\
                                    <div class="spinner-border" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                </div>',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                    }
                },
                complete: function () {
                    activeAjaxRequests--;
                    if (activeAjaxRequests === 0) {
                        swal.close();
                    }
                },
                success: function (result, status, xhr) {
                    if (typeof callback == "function") {
                        callback(result, status, xhr);
                    }
                }, 
                error: function () {
                   swal.close();
                }
            });
        }
    }

    this.fnGetById = function(id,callback) {
        if (apiUrl) {
            $.ajax({
                url: apiUrl + "getById/"+id,
                beforeSend: function () {
                    activeAjaxRequests++;
                    if (activeAjaxRequests === 1) {
                        Swal.fire({
                            title: "Por favor, espere",
                            html: '<strong>Cargando...</strong>\
                                <div class="text-center">\
                                    <div class="spinner-border" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                </div>',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                    }
                },
                complete: function () {
                    activeAjaxRequests--;
                    if (activeAjaxRequests === 0) {
                        swal.close();
                    }
                },
                success: function (result, status, xhr) {
                    if (typeof callback == "function") {
                        callback(result, status, xhr);
                    }
                }, 
                error: function () {
                    swal.close();
                }
            });
        }
    }

    this.fnPost = function(data,callback) {
        if (apiUrl) {
            $.ajax({
                url: apiUrl + "Post",
                type: "POST",
                data: { data },
                beforeSend: function () {
                    activeAjaxRequests++;
                    if (activeAjaxRequests === 1) {
                        Swal.fire({
                            title: "Por favor, espere",
                            html: '<strong>Cargando...</strong>\
                                <div class="text-center">\
                                    <div class="spinner-border" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                </div>',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                    }
                },
                complete: function () {
                    activeAjaxRequests--;
                    if (activeAjaxRequests === 0) {
                        swal.close();
                    }
                },
                success: function (result, status, xhr) {
                    if (typeof callback == "function") {
                        callback(result, status, xhr);
                    }
                }, 
                error: function () {
                    swal.close();
                }
            });
        }
    }
}