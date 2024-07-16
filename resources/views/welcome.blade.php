<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">
  

          <div><h1>bienvenido</h1></div>
    
          
</x-dynamic-component>
   
