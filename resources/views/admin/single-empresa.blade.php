<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">
    <div class="container-elemento-empresa-div">
       <div class="container-elemento-empresa-div-left">
            <h1>{{ $empresa->name }}</h1>
            <div class="contain-imagen-single-empresa">
                <div class="imagen-single-empresa">
                    @if($empresa->imagenDestacada && $empresa->imagenDestacada->ruta)
                        <img src="http://sistema3.test/storage/{{ $empresa->imagenDestacada->ruta }}" alt="">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg>
                    @endif
                </div>
            </div>
            
       </div>
       <div class="container-elemento-empresa-div-right">
            <div class="seccion-contenido-elemento2">
                <h2 class="titulo-objeto">EMAIL</h2>
                <p>{{ $empresa->email }}</p>
            </div>
            <div class="seccion-contenido-elemento">
                <h2 class="titulo-objeto">TELEFONO</h2>
                <p>{{ $empresa->telefono }}</p>
            </div>
            <div class="seccion-contenido-elemento">
                <h2 class="titulo-objeto">RUC</h2>
                <p>{{ $empresa->ruc }}</p>
            </div>
        </div>
    </div>

    <div class="container-div-sucursales">
        <x-sucursales.agregar-sucursales :elemento-id="$empresa->id"/>
        <x-sucursales.todos-sucursales :id-elemento="$empresa->id" />
        <x-sucursales.update-sucursales /> 
    </div>

    <div class="container-div-comentarios">
      <x-comentarios.agregar-comentario :elemento-id="$empresa->id" modelo-type="App\Models\Empresa" /> 
      <x-comentarios.todos-comentarios :id-elemento="$empresa->id" ruta-modelo="App\Models\Empresa" />
      <x-comentarios.update-comentarios />
    </div>
   
</x-dynamic-component>