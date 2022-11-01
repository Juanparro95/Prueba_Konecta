// Variable que extrae todos los productos
const renderProducts = "product/all";
// Variable que extrae todas las compras hechas
const renderShopping = "shopping/show";
// Variable para imprimir los productos renderizados;
const productos = $(".productos");
// Variable para imprimir las compras renderizadas;
const compras = $(".compras");
// Variable que obtiene la url para almacenar las nuevas compras
const saveShopping = "shopping/store";

$(document).ready(function () {
    printProducts();
    printShoppings();
})

const printProducts = async () => {
    const data = await getAjax(renderProducts);
    const info = data.data;
    let html = `<div class="row">`;
    for(let i = 0; i < info.length; i++){

        html += `<div class="card col-md-6">
                        <div class="card-body">
                            <div class="text-center">
                                <h4>${info[i]['name']}</h4>
                                <small>${info[i]['reference']}</small>
                                <center>
                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Cant: ${info[i]['stock']}</label>
                                        <div class="col-sm-8">
                                            <input type="number" min="1" max="${info[i]['stock']}" class="form-control form-control-sm" id="amount-${info[i]['id']}" name="amount">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" onclick="registrar_producto(${info[i]['id']})" class="btn btn-info">Comprar</button>
                                    </div>
                                </center>
                            </div>
                        </div>
                </div>`;
    }

    html += `</div>`;

    productos.html(html);
}


const printShoppings = async () => {
    const data = await getAjax(renderShopping);
    const info = data.data;
    let html = `<div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">PRODUCTO</th>
                                <th class="text-center">CANTIDAD ADQUIRIDA</th>
                            </tr>
                        </thead>
                        <tbody>`;

    for(let i = 0; i < info.length; i++){

        html += `<tr>
                    <td align="center">${info[i]['name']}</td>
                    <td align="center">${info[i]['amount']}</td>
                </tr>`;
    }

    html += `</tbody></table></div>`;

    compras.html(html);
}

const registrar_producto = (id) => {
   const amountSelect = $(`#amount-${id}`).val();
   const data = new FormData();
   data.append('amount', amountSelect);
   data.append('id', id);
   

   AjaxPost(data, saveShopping, postType, null, true, true, printShoppings(), printProducts());
}