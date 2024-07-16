<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CRM MEGAEQUIPAMIENTO</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tiny.cloud/1/zl7pfg1w58pvvhky3o6kxouy72q9f7ln06hv6c523j0ta4eg/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="">
        <div class="contenido-completo">
            <div class="barra-superior">
                <x-comentarios.notificaciones-comentario />
                <!-- barra superior -->
                <button class="button menu-login" id="menu-login">Menu
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                </button>
                <ul class="menu-sesion" id="menu-sesion"> 
                    @auth
                        <li>
                            <a href="{{ route('profile.edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M96 128a128 128 0 1 0 256 0A128 128 0 1 0 96 128zm94.5 200.2l18.6 31L175.8 483.1l-36-146.9c-2-8.1-9.8-13.4-17.9-11.3C51.9 342.4 0 405.8 0 481.3c0 17 13.8 30.7 30.7 30.7H162.5c0 0 0 0 .1 0H168 280h5.5c0 0 0 0 .1 0H417.3c17 0 30.7-13.8 30.7-30.7c0-75.5-51.9-138.9-121.9-156.4c-8.1-2-15.9 3.3-17.9 11.3l-36 146.9L238.9 359.2l18.6-31c6.4-10.7-1.3-24.2-13.7-24.2H224 204.3c-12.4 0-20.1 13.6-13.7 24.2z"/></svg>
                                Perfil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V256c0 17.7 14.3 32 32 32s32-14.3 32-32V32zM143.5 120.6c13.6-11.3 15.4-31.5 4.1-45.1s-31.5-15.4-45.1-4.1C49.7 115.4 16 181.8 16 256c0 132.5 107.5 240 240 240s240-107.5 240-240c0-74.2-33.8-140.6-86.6-184.6c-13.6-11.3-33.8-9.4-45.1 4.1s-9.4 33.8 4.1 45.1c38.9 32.3 63.5 81 63.5 135.4c0 97.2-78.8 176-176 176s-176-78.8-176-176c0-54.4 24.7-103.1 63.5-135.4z"/></svg>
                                    Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Registrarse</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
           <div class="barra-lateral">
               <x-mostrar-usuario />
               @include('layouts.navigation')
           </div>
           <div class="contenido-page">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="">
                        <div class="">
                            {{ $header }}
                        </div>
                    </header>
                @endif
            
                 <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
           </div>
           <div class="barra-inferior">
             <p>Barra inferior</p>
             <div id="confirmacion-exitoza" class="">
                <button class="cerrar-confirmacion"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
                <svg id="exito-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/></svg>
                <svg id="error-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
                <p id="confirmacion-exitoza-text">confimacion exitoza</p>
             </div>
               <div id="fondo-negro-confirmacion"></div>
               <script>
                    function mostrarConfirmacion(mensaje) {
                        // Obtener el div y el elemento p por sus IDs                       
                        const divFondo = document.getElementById('fondo-negro-confirmacion');
                        const divConfirmacion = document.getElementById('confirmacion-exitoza');
                        const pTextoConfirmacion = document.getElementById('confirmacion-exitoza-text');
                        const iconoConfirmacion = document.getElementById('exito-svg');
                        const iconoError = document.getElementById('error-svg');
                        // Agregar la clase 'activo' al div
                        divConfirmacion.classList.add('active');
                        divFondo .classList.add('active');
                        iconoConfirmacion.style.display = 'block';
                        iconoError.style.display = 'none';

                        // Actualizar el texto del elemento p
                        pTextoConfirmacion.textContent = mensaje;
                    }

                    function mostrarError(mensaje, errores) {
                        // Obtener los elementos por sus IDs
                        const divFondo = document.getElementById('fondo-negro-confirmacion');
                        const divConfirmacion = document.getElementById('confirmacion-exitoza');
                        const pTextoConfirmacion = document.getElementById('confirmacion-exitoza-text');
                        const iconoConfirmacion = document.getElementById('exito-svg');
                        const iconoError = document.getElementById('error-svg');

                        if (divFondo && divConfirmacion && pTextoConfirmacion && iconoConfirmacion && iconoError) {
                            // Agregar la clase 'activo' a los divs
                            divConfirmacion.classList.add('active');
                            divFondo.classList.add('active');
                            iconoConfirmacion.style.display = 'none';
                            iconoError.style.display = 'block';

                            // Limpiar cualquier error previo
                            pTextoConfirmacion.innerHTML = '';

                            // Agregar mensaje y errores al contenedor
                            const textoMensaje = document.createTextNode(mensaje);
                            pTextoConfirmacion.appendChild(textoMensaje);
                            pTextoConfirmacion.appendChild(mostrarErrores(errores)); // Usar appendChild para agregar elementos
                        } else {
                            console.error('Algunos elementos no se encontraron en el DOM.');
                        }
                    }
                    
                    function mostrarErrores(errores) {
                        // Crear un elemento de lista no ordenada
                        const ul = document.createElement('ul');
                        // Iterar sobre cada campo en el objeto de errores
                        for (const campo in errores) {
                            if (errores.hasOwnProperty(campo)) {
                                // Iterar sobre cada mensaje de error para ese campo
                                errores[campo].forEach(error => {
                                    // Crear un elemento de lista para cada mensaje de error
                                    const li = document.createElement('li');
                                    li.textContent = `${campo}: ${error}`;
                                    // Agregar el elemento de lista al elemento de lista no ordenada
                                    ul.appendChild(li);
                                });
                            }
                        }

                        // Devolver el elemento de lista no ordenada con todos los mensajes de error
                        return ul;
                    }


                    
                    const botonCerrarConfirmacion = document.querySelector('.cerrar-confirmacion');
                    const divConfirmacion = document.querySelector('#confirmacion-exitoza');
                    const fondoDivConfirmacion = document.querySelector('#fondo-negro-confirmacion');
                    const botonSesionMenu = document.querySelector('#menu-login');
                    const containerSesionMenu = document.querySelector('#menu-sesion');

                    botonCerrarConfirmacion.addEventListener('click', () => {
                        divConfirmacion.classList.remove('active');
                        fondoDivConfirmacion.classList.remove('active');
                    });

                    botonSesionMenu.addEventListener('click', () => {
                        containerSesionMenu.classList.toggle('active');
                        botonSesionMenu.classList.toggle('active');
                    });

                    function limpiarDivsImagenIndividual() {
                        // Seleccionar todos los divs con la clase 'imagen-individual-form'
                        const divsImagen = document.querySelectorAll('.imagen-individual-form');
                        const divsImagenElementosSeleccionados = document.querySelectorAll('.elementos-seleccionados');

                        // Recorrer cada div y eliminar su contenido interno
                        if (divsImagen.length > 0) {
                            divsImagen.forEach(function(div) {
                                div.innerHTML = '';
                            });
                        }
                    
                        if (divsImagenElementosSeleccionados.length > 0) {
                        // Recorrer cada div y vaciar su contenido
                            divsImagenElementosSeleccionados.forEach(function(div) {
                                div.innerHTML = '';
                                var inputSiguiente = div.nextElementSibling;
                                if (inputSiguiente && inputSiguiente.tagName === 'INPUT') {
                                    inputSiguiente.value = '';
                                }
                            });
                        }
                    }
               </script>
           </div>
        </div>
    </body>
</html>
