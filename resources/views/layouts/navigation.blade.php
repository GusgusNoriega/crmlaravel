<nav>
    <ul id="menuAcordeon">
       
        <li class="{{ request()->routeIs('usuarios') || request()->routeIs('roles') ? 'active' : '' }}">
            <button class="accordion">        
              <svg class="svg-menu-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                <span>USUARIOS Y ROLES</span>
              <svg class="svg-menu-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            </button>
            <ul class="submenu {{ request()->routeIs('usuarios') || request()->routeIs('roles') ? 'active' : '' }}">
                <li><a class="{{ request()->routeIs('usuarios') ? 'active' : '' }}" href="{{ route('usuarios') }}">Usuarios</a></li>
                <li><a class="{{ request()->routeIs('roles') ? 'active' : '' }}" href="{{ route('roles') }}">Roles</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('nuestrasEmpresas') ? 'active' : '' }}">
            <button class="accordion">        
                <svg class="svg-menu-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 48c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16h80V400c0-26.5 21.5-48 48-48s48 21.5 48 48v64h80c8.8 0 16-7.2 16-16V64c0-8.8-7.2-16-16-16H64zM0 64C0 28.7 28.7 0 64 0H320c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm88 40c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H104c-8.8 0-16-7.2-16-16V104zM232 88h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H232c-8.8 0-16-7.2-16-16V104c0-8.8 7.2-16 16-16zM88 232c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H104c-8.8 0-16-7.2-16-16V232zm144-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H232c-8.8 0-16-7.2-16-16V232c0-8.8 7.2-16 16-16z"/></svg>
                <span>NUESTRAS EMPRESAS</span>
              <svg class="svg-menu-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            </button>
            <ul class="submenu {{ request()->routeIs('nuestrasEmpresas') ? 'active' : '' }}">
                <li><a class="{{ request()->routeIs('nuestrasEmpresas') ? 'active' : '' }}" href="{{ route('nuestrasEmpresas') }}">NUESRAS EMPRESAS</a></li>
            </ul>
        </li>
        <li  class="{{ request()->routeIs('verEmpresas') || request()->routeIs('verClientes') || request()->routeIs('verAreas') ? 'active' : '' }}" >
            <button class="accordion">        
                <svg class="svg-menu-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"/></svg>
               <span>CLIENTES</span>
               <svg class="svg-menu-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            </button>
            <ul class="submenu">
                <li><a class="{{ request()->routeIs('verClientes') ? 'active' : '' }}" href="{{ route('verClientes') }}">Empleados y clientes particulares</a></li>  
                <li><a class="{{ request()->routeIs('verEmpresas') ? 'active' : '' }}" href="{{ route('verEmpresas') }}">Empresas de clientes</a></li>
                <li><a class="{{ request()->routeIs('verAreas') ? 'active' : '' }}" href="{{ route('verAreas') }}">Areas de clientes</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('products.productos') || request()->routeIs('verTaxonomias') || request()->routeIs('verMarcas') || request()->routeIs('verProcedencias') || request()->routeIs('verCategorias') || request()->routeIs('verMonedas') || request()->routeIs('servicios.deleteServicio') ? 'active' : '' }}" >
            <button class="accordion">        
               <svg class="svg-menu-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
               <span>PRODUCTOS Y SERVICIOS</span>
               <svg class="svg-menu-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            </button>
            <ul class="submenu">
                <li><a class="{{ request()->routeIs('products.productos') ? 'active' : '' }}" href="{{ route('products.productos') }}">PRODUCTOS</a></li>
                <li><a class="{{ request()->routeIs('servicios.deleteServicio') ? 'active' : '' }}" href="{{ route('servicios.deleteServicio') }}">SERVICIOS</a></li>  
                <li><a class="{{ request()->routeIs('verTaxonomias') ? 'active' : '' }}" href="{{ route('verTaxonomias') }}">TAXONOMIAS</a></li>
                <li><a class="{{ request()->routeIs('verMarcas') ? 'active' : '' }}" href="{{ route('verMarcas') }}">MARCAS</a></li>
                <li><a class="{{ request()->routeIs('verProcedencias') ? 'active' : '' }}" href="{{ route('verProcedencias') }}">PROCEDENCIAS</a></li>
                <li><a class="{{ request()->routeIs('verCategorias') ? 'active' : '' }}" href="{{ route('verCategorias') }}">CATEGORIAS</a></li>
                <li><a class="{{ request()->routeIs('verMonedas') ? 'active' : '' }}" href="{{ route('verMonedas') }}">MONEDAS</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('verCotizaciones') ? 'active' : '' }}">
            <button class="accordion">        
                <svg class="svg-menu-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                <span>COTIZACIONES</span>
              <svg class="svg-menu-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            </button>
            <ul class="submenu {{ request()->routeIs('verCotizaciones') ? 'active' : '' }}">
                <li><a class="{{ request()->routeIs('verCotizaciones') ? 'active' : '' }}" href="{{ route('verCotizaciones') }}">COTIZACIONES</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('verApis') ? 'active' : '' }}">
            <button class="accordion">        
                <svg class="svg-menu-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path d="M54.2 202.9C123.2 136.7 216.8 96 320 96s196.8 40.7 265.8 106.9c12.8 12.2 33 11.8 45.2-.9s11.8-33-.9-45.2C549.7 79.5 440.4 32 320 32S90.3 79.5 9.8 156.7C-2.9 169-3.3 189.2 8.9 202s32.5 13.2 45.2 .9zM320 256c56.8 0 108.6 21.1 148.2 56c13.3 11.7 33.5 10.4 45.2-2.8s10.4-33.5-2.8-45.2C459.8 219.2 393 192 320 192s-139.8 27.2-190.5 72c-13.3 11.7-14.5 31.9-2.8 45.2s31.9 14.5 45.2 2.8c39.5-34.9 91.3-56 148.2-56zm64 160a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"/>
                </svg>
                <span>CONECCIONES APIS</span>
              <svg class="svg-menu-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            </button>
            <ul class="submenu {{ request()->routeIs('verApis') ? 'active' : '' }}">
                <li><a class="{{ request()->routeIs('verApis') ? 'active' : '' }}" href="{{ route('verApis') }}">CONECCIONES API</a></li>
            </ul>
        </li>

    </ul>
</nav>
