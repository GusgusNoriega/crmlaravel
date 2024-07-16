<div class="container-agregar-usuario container-agregar-elemento agregar-editar-producto-contenedor">
    <button id="button-agregar-elementos" class="button button-agregar-elementos">
        Agregar nuevo servicio
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path></svg>
    </button>
    <div id="fondo-agregar-elemento" class="fondo-agregar-elemento"></div>
    <div class="container-div-agregar-elementos" id="container-div-agregar-elementos">
        <button id="cerrar-div-agregar-elementos" class="cerrar-div-agregar-elementos">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Agregar servicio</h3>
        <form action="" method="POST" id="register-elementos">
            @csrf

            <input type="hidden" name="tipo" value="2">

            <div class="form-group">
                <label for="name">TITULO</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group contain-image-agre form-group-50">
                <input type="hidden" name="image_id" value="">
                <button id="imagen-cambiar-3" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Selecionar imagen principal</button>
                <div class="imagen-individual-form"></div>
            </div>
            
            <div class="form-group contain-image-agre form-group-50">
                <input type="hidden" name="imagenes_id" value="">
                <button id="imagen-cambiar-4" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="20">Selecionar imagenes de la galeria</button>
                <div class="imagen-individual-form"></div>
            </div>   
            
            <div class="form-group">
                <label for="description" >DESCRIPCION</label>
                <textarea id="descripcion" name="description" rows="10">
                </textarea>
            </div>

           <input type="hidden" name="taxonomias-terminos-input" value="[]">

            <div class="form-group">
                <label for="datos_tecnicos" >DATOS TECNICOS</label>
                <textarea id="datos_tecnicos" name="datos_tecnicos" rows="5">
                </textarea>
            </div>

            <div class="form-group">
                <label for="cont_envio" >CONTENIDO DE ENVIO</label>
                <textarea id="cont_envio" name="cont_envio" rows="5">
                </textarea>
            </div>
            
            <div class="form-group form-group-33">
                <x-productos.buscador-marca idPrincipal="marca1" nombre="MARCA" cantidad="10"/>
            </div>

            <div class="form-group form-group-33">
                <x-productos.buscador-procedencia idPrincipal="procedencia1" nombre="PROCEDENCIA" cantidad="5"/>
            </div>

            <div class="form-group form-group-33">
                <x-productos.buscador-categoria idPrincipal="categoria1" nombre="CATEGORIA" cantidad="20"/>
            </div>

            <div class="form-group form-group-33">
                <label for="modelo">MODELO</label>
                <input type="text" name="modelo" id="modelo" required>
            </div>
 
            <div class="form-group form-group-33">
                <x-productos.select-moneda selectId="idmoneda" />
            </div>
            
            <div class="form-group form-group-33">
                <label for="name">PRECIO</label>
                <input type="number" name="precio" id="precio" step="0.01" required>
            </div>

            <div class="form-group">
                <button type="submit" class="button">CREAR SERVICIO</button>
            </div>

        </form>
    </div>
<script>
        var botonAgregarElementos = document.getElementById('button-agregar-elementos');
        var divContentAgregarElementos = document.getElementById('container-div-agregar-elementos');
        var botonCerrarAgregarElementos = document.getElementById('cerrar-div-agregar-elementos');
        var divFondoAgregarElementos = document.getElementById('fondo-agregar-elemento');

        // Agregar un evento de clic al botón
        botonAgregarElementos.addEventListener('click', function() {
            // Agregar la clase al div
            divContentAgregarElementos.classList.add('active');
            divFondoAgregarElementos.classList.add('active');
        });

        botonCerrarAgregarElementos.addEventListener('click', function() {
            // Agregar la clase al div
            divContentAgregarElementos.classList.remove('active');
            divFondoAgregarElementos.classList.remove('active');
        });

       
        document.getElementById('register-elementos').addEventListener('submit', function (event) {
            event.preventDefault();

            tinyMCE.triggerSave();

            let form = this;
            let formData = new FormData(form);
    
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/productos/create', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 201) { 
                        form.reset();
                        mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                        limpiarDivsImagenIndividual();
                        cargarProductos();
                    } else {
                        mostrarError(JSON.parse(xhr.responseText).message, JSON.parse(xhr.responseText).errors);
                        /*console.log(JSON.parse(xhr.responseText).errors);*/
                    }
                }
            };

            xhr.send(formData);
        });

        document.addEventListener('DOMContentLoaded', function() {
                tinymce.init({
                    selector: '#descripcion, #cont_envio, #datos_tecnicos',
                    language: 'es',
                    plugins: 'table code',
                    toolbar: 'table code',
                    content_style: `
                        body {
                            background-color: #273b49; /* Color de fondo */
                            color: #ffff; /* Color del texto */
                        }
                    
                    `
                });  
        });
 
         
</script>

</div>