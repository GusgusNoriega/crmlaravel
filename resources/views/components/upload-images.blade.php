<div class="upload-images-content">
    <form id="uploadForm" action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="content-ubload-image">
            <label for="image">Seleccionar imagen:</label>
            <input type="file" name="image1" class="image-input" required>
            <div class="thumbnail" id="thumbnail-image-upload"></div>
            <button type="button" class="remove-image" style="display: none;">
                <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
            </button>
        </div>
    
        <!-- Otros campos si son necesarios -->
        <input type="text" name="name" placeholder="Nombre de la imagen">
        <input type="text" name="alt" placeholder="Texto alternativo">
    
        <button class="button boton-enviar" type="submit">Subir Imagen</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('uploadForm');
            form.addEventListener('submit', function (e) {
                e.preventDefault();
        
                let formData = new FormData(this);
        
                fetch("{{ route('images.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    mostrarConfirmacion('Imagen subida correctamente');       
                    form.reset();
                    resetSearchImage();
                    limpiarImagenSubida();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al subir la imagen');
                });
            });
        });

        function limpiarImagenSubida() {
            // Seleccionar el formulario por su ID
            const thumbnailImage = document.getElementById('thumbnail-image-upload');
            var removeButton = thumbnailImage.nextElementSibling;

            // Verificar si el formulario existe
            if (thumbnailImage) {
                // Establecer el contenido interno del formulario en una cadena vacía
                thumbnailImage.innerHTML = '';
                removeButton.style.display = 'none';
            }
        }
    </script>

</div>