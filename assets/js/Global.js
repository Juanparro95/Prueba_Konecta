/**
 * Variables tipos de petición HTTP
 */

const postType = "POST";
const getType = "GET";

/**
 * Variable que inicializa los mensajes
 */
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
});

/**
 * Funcion para imprimir un mensaje básico
 * @param {*} title 
 * @param {*} icons 
 * @returns 
 */
const MensajeAlertaBasico = (title, icons) => {
    return Toast.fire({
        icon: icons,
        title: title,
    });
}

/**
 * Función para imprimir mensajes flask
 * @param {*} title 
 * @param {*} description 
 * @param {*} type_alert 
 */
const MensajesFlask = (data) => {
    $(".messages").html(`<div class="alert alert-${data.type_alert} alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> ${data.title}</h5>
                            ${data.description}
                        </div>`);
    // En un determinado tiempo, desaparece el mensaje de forma automática.
    setInterval(
        () => {
            $(".messages").html('');
        }
        , 3000);
}

/**
 * Método dinámico para peticiones AJAX
 * @param {*} data 
 * @param {*} url 
 * @param {*} type 
 * @param {*} modal 
 */
const AjaxPost = (data, url, type, modal = null, isObject = false) => {

    let formData = data;

    if(!isObject){
        formData = new FormData(data.get(0));
    }

    $.ajax({
        url: url,
        type: type,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        beforeSend: function () {
            if(!isObject){
                data.waitMe();
            }
        },
        success: function (data) {
            if (data.status === 200) {
                MensajeAlertaBasico(data.msg, 'success');
                if (modal) {
                    closeModal(modal);
                }
                return;
            }
            
            MensajeAlertaBasico(data.msg, 'warning');
        },
        error: function (event) {
            console.log(event);
        },

        complete: function () {

        }
    })
}

const getAjax = async(url, idItem = null) => {
    let urlQuery = url;
    if(idItem != null){
        urlQuery = `${url}/${idItem}`;
    }
    return await $.get(urlQuery, function (data) {
    }).fail(function (error) {
        MensajeAlertaBasico(error, 'error');
    });
}

/**
 * Metodo para cerrar un modal
 * @param {*} modal 
 */
const closeModal = (modal) => {
    setTimeout(() => {
        modal.modal("hide");
    }, 1000);
}


const renderTable = () => {

    setTimeout(() => {
        location.reload(true);
    }, 1500);
}