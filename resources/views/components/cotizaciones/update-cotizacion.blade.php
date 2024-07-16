<div class="container-agregar-usuario container-agregar-elemento">
    
    <div id="fondo-agregar-elemento" class="fondo-agregar-elemento"></div>
    <div class="container-div-agregar-elementos" id="container-div-agregar-elementos">
        <button id="cerrar-div-agregar-elementos" class="cerrar-div-agregar-elementos">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Actualizar cotizacion</h3>
        <form action="" method="POST" id="register-elementos">
            @csrf

            <input id="id-elemento-update" type="hidden" name="id_elemento">
    
            <div class="form-group form-group-25">
                <label for="fecha-cotizacion">Fecha de cotizacion</label>
                <input type="date" name="fecha_cotizacion" id="fecha-cotizacion" required>
            </div>

            <div class="form-group form-group-25">
                <label for="fecha-vencimiento">Fecha de vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha-vencimiento" required>
            </div>

            <div class="form-group form-group-25">
                <label for="entrega">entrega</label>
                <input type="text" name="entrega" id="entrega" required>
            </div>

            <div class="form-group form-group-25">
                <label for="lugar-entrega">lugar de entrega</label>
                <input type="text" name="lugar_entrega" id="lugar-entrega" required>
            </div>

            <div class="form-group form-group-25">
                <label for="garantia">Garantia</label>
                <input type="text" name="garantia" id="garantia" required>
            </div>

            <div class="form-group form-group-25">
                <label for="forma-de-pago">Forma de pago</label>
                <input type="text" name="forma_de_pago" id="forma-de-pago" required>
            </div>

            <input type="hidden" name="total_productos" id="total-productos" required>
            
            <div class="form-group form-group-25">
                <x-cotizaciones.buscador-clientes idPrincipal="cliente1" nombre="CLIENTE" cantidad="1"/>
            </div>

            <x-user-select-vendedor select-id="user-3"/>

            <div class="form-group form-group-25">
                <x-cotizaciones.select-mis-empresas selectId="idmisempresas" />
            </div>

            <div class="form-group form-group-25">
                <x-productos.select-moneda selectId="idmoneda" />
            </div>

            <div class="form-group form-group-25">
                <label for="tipo-de-cambio">Tipo de cambio</label>
                <input type="number" name="tipo_de_cambio" id="tipo-de-cambio" step="0.01" required>
            </div>

            <div class="form-group">
                <x-cotizaciones.buscador-productos idPrincipal="productos1" nombre="PRODUCTOS" cantidad="50"/>
            </div>

            <div class="form-group form-group-25">
                <label for="total-productos-monto">total monto productos</label>
                <input id="total-productos-monto" type="number" step="0.01" disabled>
            </div>

            <div class="form-group">
                <x-cotizaciones.adicionales />
            </div>

            <div class="form-group form-group-25">
                <label for="total">Total</label>
                <input type="number" name="total" id="total" step="0.01" required readonly>
            </div>

            <div class="form-group">
                <button type="submit" class="button">Actualizar cotización</button>
            </div> 
        </form>
    </div>
<script>
        var botonAgregarElementos = document.getElementById('abrir-editar-cotizacion');
        var divContentAgregarElementos = document.getElementById('container-div-agregar-elementos');
        var botonCerrarAgregarElementos = document.getElementById('cerrar-div-agregar-elementos');
        var divFondoAgregarElementos = document.getElementById('fondo-agregar-elemento');

        // Agregar un evento de clic al botón
        botonAgregarElementos.addEventListener('click', function() {
            // Agregar la clase al div
            divContentAgregarElementos.classList.add('active');
            divFondoAgregarElementos.classList.add('active');
            const updateElementosId = botonAgregarElementos.getAttribute('data-update-elemento');
            console.log(updateElementosId);
            obtenerEmpresaPorId(updateElementosId);
        });
        botonCerrarAgregarElementos.addEventListener('click', function() {
            // Agregar la clase al div
            divContentAgregarElementos.classList.remove('active');
            divFondoAgregarElementos.classList.remove('active');
        });

       
        document.getElementById('register-elementos').addEventListener('submit', function (event) {
            event.preventDefault();

            let form = this;
            let formData = new FormData(form);
            let idDelRegistro = document.querySelector('#id-elemento-update').value;

            let xhr = new XMLHttpRequest();
            // Asegúrate de incluir el ID del registro a actualizar en la URL
            xhr.open('POST', '/admin/cotizaciones/update/' + idDelRegistro, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) { // 200 OK para una actualización exitosa
                        //form.reset();
                        mostrarConfirmacion(JSON.parse(xhr.responseText).message);  
                    } else {
                        mostrarError(JSON.parse(xhr.responseText).message, JSON.parse(xhr.responseText).errors);
                    }
                }
            };

            xhr.send(formData);
        });
 
           
        function actualizarTotalGeneral() {
            // Obtener el valor del input "total-productos-monto"
            var totalProductosMonto = parseFloat(document.getElementById('total-productos-monto').value) || 0;
            
            // Obtener el valor del input "total-adicionales-monto"
            var totalAdicionalesMonto = parseFloat(document.getElementById('total-adicionales-monto').value) || 0;
            
            // Sumar ambos montos
            var sumaTotal = totalProductosMonto + totalAdicionalesMonto;
            
            // Colocar el resultado de la suma en el input "total"
            document.getElementById('total').value = sumaTotal.toFixed(2); // Asumiendo que quieres dos decimales
        }


    /*procesar datos de cotizacion existente*/
    function obtenerEmpresaPorId(id) {
        
        // Configurar la solicitud
        var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
         var request = new XMLHttpRequest();
         request.open('GET', '/admin/cotizaciones/get/' + id, true);
         request.setRequestHeader('Content-Type', 'application/json');
         request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
         request.setRequestHeader('X-CSRF-TOKEN', csrfToken);
 
         // Definir qué hacer cuando se reciba la respuesta
         request.onload = function() {
             if (this.status >= 200 && this.status < 400) {
                 // Éxito: mostrar la respuesta y llenar el formulario
                 var datos = JSON.parse(this.response);
                 console.log(datos);
                 llenarFormularioConDatos(datos);
             } else {
                 // Se alcanzó el servidor, pero devolvió un error
                 console.error('Error del servidor');
             }
         };
 
         // Definir qué hacer en caso de error
         request.onerror = function() {
             console.error('Error de conexión');
         };
 
         // Enviar la solicitud
         request.send();
    }

    function llenarFormularioConDatos(datos) {
        // Asegúrate de que tienes los datos que esperas
        if (!datos) {
            console.error('No hay datos para llenar el formulario.');
            return;
        }
        var fechaCompleta = datos.fecha_cotizacion || '';
        var soloFecha = fechaCompleta.split('T')[0]; 

        var FechaVencimiento = datos.fecha_vencimiento || '';
        var soloFechaVencimiento = FechaVencimiento.split('T')[0]; 

        document.querySelector('#fecha-cotizacion').value = soloFecha;
        document.querySelector('#fecha-vencimiento').value = soloFechaVencimiento;
        document.querySelector('#id-elemento-update').value = datos.id || '';
        document.querySelector('#entrega').value = datos.entrega || '';
        document.querySelector('#lugar-entrega').value = datos.lugar_entrega || '';
        document.querySelector('#garantia').value = datos.garantia || '';
        document.querySelector('#forma-de-pago').value = datos.forma_de_pago || '';
        document.querySelector('#tipo-de-cambio').value = datos.tipo_de_cambio || '';
        document.querySelector('#idmisempresas').value = datos.misempresa.id || '';
        document.querySelector('#user-3').value = datos.user_id || '';
        document.querySelector('#idmoneda').value = datos.moneda_id || '';

        
        var divParaInsertarClientes = document.querySelector('#div-buscar-elementoscliente1');
        divParaInsertarClientes.innerHTML = '';

        var divParaInsertarClienteValores = document.querySelector('#resultados-seleccionadoscliente1');
        divParaInsertarClienteValores.value = '';

        if(datos.cliente) {
           
                   // Construir el contenido HTML para cada marca
                   var contenidoCliente = `<div data-elemento-id="${datos.cliente.id}">
                                               <button class="eliminar-elemento-buscador" data-id-eliminar="${datos.cliente.id}"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
                                               <div class="imagen-destacada-buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg></div>
                                                   <div class="contenido-opciones-buscador">
                                                       <h3>${datos.cliente.name}</h3>
                                                   </div>
                                           </div>`;

                   // Añadir el contenido de la marca al div
                   divParaInsertarClientes.innerHTML += contenidoCliente;
                   divParaInsertarClienteValores.value = datos.cliente.id;
                                                                                            
       }

       var divParaInsertarProductos = document.querySelector('#div-buscar-elementosproductos1');
       divParaInsertarProductos.innerHTML = '';

       if(datos.products) {
           
           if (!Array.isArray(datos.products)) {
               
           }else {
               
               datos.products.forEach(function(producto) {
                   // Construir el contenido HTML para cada marca
                   var contenidoProducto = `<div data-elemento-id="${producto.id}" class="producto-individual-suma">
                                                    <button class="eliminar-elemento-buscador" data-id-eliminar="${producto.id}">
                                                        <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
                                                    </button>
                                                    <div class="imagen-destacada-buscador">
                                                        <img src="http://sistema3.test/storage/${producto.imagen_destacada.ruta}" alt="Gustavos Avatar">
                                                    </div>
                                                    <div class="contenido-opciones-buscador">
                                                        <h3 class="titulo-producto-div">${producto.title}</h3>
                                                    </div>
                                                    <input class="id-producto" type="hidden" value="${producto.id}" disabled="">
                                                    <div class="product-div-50">
                                                        <label class="ocultar product-div-50">Moneda</label> 
                                                        <input class="moneda-actual" type="text" value="${producto.pivot.moneda_actual}" disabled="">
                                                    </div>
                                                    <div class="ocultar product-div-50"> 
                                                        <label>Moneda final cotizacion</label>
                                                        <input class="moneda-final" type="text" disabled="" value="${producto.pivot.moneda_final}">
                                                    </div>
                                                    <div class="ocultar product-div-50"> 
                                                        <label>Tipo de cambio</label>
                                                        <input class="tipo-cambio-actual" type="number" step="0.01" value="${producto.pivot.tipo_cambio_actual}">
                                                    </div>
                                                    <div class="ocultar product-div-50"> 
                                                        <label>Tipo de cambio final</label>
                                                        <input class="tipo-cambio-final" type="number" step="0.01" value="${producto.pivot.tipo_cambio_final}" disabled="">
                                                    </div>
                                                    <div class="product-div-50">
                                                        <label class="ocultar product-div-50">Precio actual</label>
                                                        <input class="precio-actual" type="number" step="0.01" value="${producto.pivot.precio_actual}" disabled="">
                                                    </div>
                                                    <div class="ocultar product-div-50">
                                                        <label class="ocultar">Precio final</label>
                                                        <input class="precio-tipo-de-cambio" type="number" step="0.01" value="${producto.pivot.precio_final}" disabled="">
                                                    </div>
                                                    <div class="ocultar product-div-50">
                                                        <label>catidad</label>
                                                        <input class="cantidad" type="number" name="cantidad" value="${producto.pivot.cantidad}">
                                                    </div>
                                                    <div class="ocultar product-div-50"> 
                                                        <label>Precio descuento</label>
                                                        <input class="precio-final-producto" type="number" step="0.01" value="${producto.pivot.precio_descuento}">
                                                    </div>
                                                    <div class="ocultar product-div-50"> 
                                                        <label>Total suma</label>
                                                        <input class="total-suma-producto" type="number" step="0.01" value="" disabled="">
                                                    </div>
                                             </div>`;

                   // Añadir el contenido de la marca al div
                   divParaInsertarProductos.innerHTML += contenidoProducto;
                  
               });


           }
                                                                                       
       }

       var divParaInsertarAdicionales = document.querySelector('#adicionales');
       divParaInsertarAdicionales.innerHTML = '';

       if (datos.adicionales) {
            // Convierte el string JSON en un objeto JavaScript
            var adicionales = JSON.parse(datos.adicionales);

            // Verifica si el JSON convertido está vacío
            if (adicionales.length === 0) {
                      
            } else {
                // Ahora puedes acceder a los datos como un array de objetos y hacer lo que necesites con ellos
                adicionales.forEach(function(adicional) {
                    //console.log(adicional.titulo, adicional.precio, adicional.cantidad, adicional.total);
                    
                    var contenidoAdicional = `<div class="adicional-individual">
                                                <button class="eliminar-elemento-buscador" type="button">
                                                    <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
                                                </button>
                                                <div>
                                                    <label>Titulo</label>
                                                    <input class="nombre-adicional" type="text" value="${adicional.titulo}">
                                                </div>
                                                <div>
                                                    <label>Precio</label>
                                                    <input class="monto-adicional" type="number" value="${adicional.precio}">
                                                </div>
                                                <div>
                                                    <label>Cantidad</label>
                                                    <input class="cantidad-adicional" type="number" value="${adicional.cantidad}">
                                                </div>
                                                <div>
                                                    <label>Total</label>
                                                    <input class="total-adicional" type="number" value="${adicional.total}" disabled="">
                                                </div>
                                             </div>`;

                    divParaInsertarAdicionales.innerHTML += contenidoAdicional;
                });

            }

            
        }

        generarJsonAdicionales();
        actualizarTotal();
        calcularTotalGeneral();
    }

</script>

</div>