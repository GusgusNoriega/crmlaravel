<div class="container-agregar-usuario container-agregar-elemento">
    <button id="button-agregar-misempresas" class="button button-agregar-misempresas">
        Agregar nueva empesa
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path></svg>
    </button>
    <div id="fondo-agregar-misempresas" class="fondo-agregar-misempresas"></div>
    <div class="container-div-agregar-misempresas" id="container-div-agregar-misempresas">
        <button id="cerrar-div-agregar-misempresas" class="cerrar-div-agregar-misempresas">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Agregar mi Empresa</h3>
        <form action="" method="POST" id="register-misempresas">
            @csrf
            <div class="form-group contain-image-agre">
                <input type="hidden" name="image_id" value="">
                <button id="imagen-cambiar-3" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Selecionar imagen del logo</button>
                <div class="imagen-individual-form"></div>
            </div>            
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="ruc">Ruc</label>
                <input type="text" name="ruc" id="ruc" required>
            </div>
            <div class="form-group">
                <label for="alias">Alias</label>
                <input type="text" name="alias" id="alias" required>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="number" name="telefono" id="telefono" required>
            </div>
            <div class="form-group contain-image-agre">
                <input type="hidden" name="imagen_sello_id" value="">
                <button id="imagen-cambiar-4" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Selecionar imagen del sello</button>
                <div class="imagen-individual-form"></div>
            </div>
            <div class="form-group">
                <label for="cuenta-soles">Cuenta soles</label>
                <input type="text" name="cuenta_soles" id="cuenta-soles" required>
            </div>
            <div class="form-group">
                <label for="cuenta-dolares">Cuenta dolares</label>
                <input type="text" name="cuenta_dolares" id="cuenta-dolares" required>
            </div>
            <div class="form-group">
                <label for="cuenta-nacion">Cuenta nacion</label>
                <input type="text" name="cuenta_nacion" id="cuenta-nacion" required>
            </div>
            <div class="form-group">
                <button type="submit" class="button">Crear Empresa</button>
            </div>
        </form>
    </div>
<script>
        var botonAgregarMisempresas = document.getElementById('button-agregar-misempresas');
        var divContentAgregarMisempresas = document.getElementById('container-div-agregar-misempresas');
        var botonCerrarAgregarMisempresas = document.getElementById('cerrar-div-agregar-misempresas');
        var divFondoAgregarMisempresas = document.getElementById('fondo-agregar-misempresas');

        // Agregar un evento de clic al botón
        botonAgregarMisempresas.addEventListener('click', function() {
            // Agregar la clase al div
            divContentAgregarMisempresas.classList.add('active');
            divFondoAgregarMisempresas.classList.add('active');
        });
        botonCerrarAgregarMisempresas.addEventListener('click', function() {
            // Agregar la clase al div
            divContentAgregarMisempresas.classList.remove('active');
            divFondoAgregarMisempresas.classList.remove('active');
        });

       

        document.getElementById('register-misempresas').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;

            fetch('/admin/nuestrasempresas/create', { // Cambiar la URL aquí
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: this.name.value,
                    ruc: this.ruc.value,
                    image_id: this.image_id.value,
                    alias: this.alias.value,
                    telefono: this.telefono.value,
                    cuenta_soles: this.cuenta_soles.value,
                    cuenta_dolares: this.cuenta_dolares.value,
                    cuenta_nacion: this.cuenta_nacion.value,
                    imagen_sello_id: this.imagen_sello_id.value,
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                mostrarConfirmacion(data.message);
                limpiarDivsImagenIndividual();
                form.reset();
                cargarEmpresas();
            })
            .catch(error => { 
                // Manejar error, por ejemplo, mostrar un mensaje de error
            });
        });
</script>

</div>

