// Variable para obtener el formulario del producto
const formCreateUpdate = $("#nuevo_producto_form");
// Variable url renderizar la tabla
const renderTableConst = 'product/get_data';
// Variable url guardar producto
const saveProduct = 'product/store';
// Variable url vet producto
const showProduct = 'product/show';
// Variable url actualizar producto
const updateProduct = 'product/update';
// Variable url actualizar producto
const deleteProduct = 'product/destroy';
// Variable boton para actualizar un producto seleccionado
const selectProduct = $(".edit_product");
// Variable boton para eliminar un producto seleccionado
const deleteProductButton = $(".delete_product");
// Variable boton para cerrar el modal
const closeModals = $("#closeModal");
// Variable boton para guardar el modal
const buttonSave = $("#buttonSave");
// Variable formulario para editar modal
const buttonModify = $("#buttonModify");
// Variable para imprimir la tabla
const tableProducts = $("#idTableProducts");

// document.addEventListener("DOMContentLoaded", async function(event) {
//     renderTable();
// });

// const renderTable = async () => {
//     const data = await getAjax(renderTableConst);
//     $(".idTableProducts").html(data.data);
// }

/**
 * Función que captura el submit del formulario y lo envia por Ajax POST para ser guardado a la BD
 */
buttonSave.on('click', function(e){
    e.preventDefault();
    console.log($("#id").val());
    if($("#id").val() != ""){
        modifyForm();
        return;
    }
    if(validarDatos()){
        AjaxPost(formCreateUpdate, saveProduct, postType, $("#createProduct"));
        renderTable();
    }
})

/**
 * Función para modificar un producto
 */
const modifyForm = () => {
    if(validarDatos()){
        AjaxPost(formCreateUpdate, updateProduct, postType, $("#createProduct"));
        renderTable();
    }
}

/**
 * Función que captura el evento click de editar productos, para mostrar la info en un modal
 */

selectProduct.on("click", async function(e){
    const idSelect = $(this).data('id');
    const data = await getAjax(showProduct, idSelect);

    if(data.status !== 200){
        console.error("ERROR");
        return;
    }

    const dataValues = data.data;

    const id = dataValues.id;
    const name = dataValues.name;
    const price = dataValues.price;
    const reference = dataValues.reference;
    const stock = dataValues.stock;
    const weight = dataValues.weight;
    const category_id = dataValues.category_id;
    
    $(`#id`).val(id);
    $(`#name`).val(name);
    $(`#price`).val(price);
    $(`#reference`).val(reference);
    $(`#stock`).val(stock);
    $(`#weight`).val(weight);
    $(`select option[value="${category_id}"]`).attr("selected",true);
    $("#createProduct").modal("show");    
    
    buttonSave.html("Modificar Producto");
    $("#buttonSave").prop("id", "buttonModify");
    $("#nuevo_producto_form").prop("id", "modificar_producto_form")

})

/**
 * Función que captura el evento click de eliminar producto
 */
deleteProductButton.on("click", async function(e){
    const idSelect = $(this).data('id');
    const nameProduct = $(this).data('name');
    Swal.fire({
        title: `No hay marcha atrás, deseas eliminar el producto ${nameProduct}?`,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Eliminar',
        denyButtonText: `Aún no`,
      }).then(async (result) => {
        if (result.isConfirmed) {
            const data = await getAjax(deleteProduct, idSelect);
            MensajeAlertaBasico(data.msg, 'success');
            renderTable();
        }
      })
})

/**
 * Función para resetear el formulario
*/
closeModals.on("click", function(e){
    formCreateUpdate[0].reset();
    buttonSave.html("Guardar Producto");
    buttonSave.prop("id", "buttonSave");
    formCreateUpdate.prop("id", "nuevo_producto_form")
})

/**
 * Función que valida todos los campos obigagorios
 * @returns 
 * Retorna TRUE si todos fueron llenados
 * Retorna FALSE si falto uno o varios campos sin llenar.
 */
const validarDatos = () =>{
    return true;
}

