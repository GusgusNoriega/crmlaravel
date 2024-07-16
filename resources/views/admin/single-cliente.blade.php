<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

@php
             $rutaImagenEmpresa = $cliente->empresa && $cliente->empresa->imagenDestacada ? '<img src="http://sistema3.test/storage/' . $cliente->empresa->imagenDestacada->ruta . '" alt="">' : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z"/></svg>';
             $rutaEmpresa = $cliente->empresa ? '<div class="container-seccion-usuario"><div class="elemento-user-image">' . $rutaImagenEmpresa . '</div><div class="elemento-user-name"><span>Empresa</span><p>' . $cliente->empresa->name . '</p></div></div>' : '';
    
@endphp
    <div class="container-elemento-empresa-div">
        <div class="container-elemento-empresa-div-left">
             <h1>{{ $cliente->name }}</h1>
             <div class="contain-imagen-single-empresa">
                 <div class="imagen-single-empresa">
                     @if($cliente->imagenDestacada && $cliente->imagenDestacada->ruta)
                         <img src="http://sistema3.test/storage/{{ $cliente->imagenDestacada->ruta }}" alt="">
                     @else
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg>
                     @endif
                 </div>
             </div>
        </div>
        <div class="container-elemento-empresa-div-right">
             <div class="seccion-contenido-elemento2">
                 <h2 class="titulo-objeto">EMAIL</h2>
                 <p>{{ $cliente->email }}</p>
             </div>
             <div class="seccion-contenido-elemento">
                 <h2 class="titulo-objeto">TELEFONO</h2>
                 <p>{{ $cliente->telefono }}</p>
             </div>
             <div class="seccion-contenido-elemento">
                 <h2 class="titulo-objeto">RUC</h2>
                 <p>{{ $cliente->ruc }}</p>
             </div>
             @php
                echo $rutaEmpresa;
             @endphp
         </div>
     </div>
 
     <div class="container-div-comentarios">
       <x-comentarios.agregar-comentario :elemento-id="$cliente->id" modelo-type="App\Models\Cliente" /> 
       <x-comentarios.todos-comentarios :id-elemento="$cliente->id" ruta-modelo="App\Models\Cliente" />
       <x-comentarios.update-comentarios />
     </div>

</x-dynamic-component>