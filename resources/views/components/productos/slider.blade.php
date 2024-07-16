<div class="container-slider-product">
    <div id="image-slider">  
    </div>
    @if($imagenes)
        <button id="prev-button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
            Anterior
        </button>
        <button id="next-button">
            Siguiente
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
        </button>
    @endif
</div>

<script>

document.addEventListener('DOMContentLoaded', () => {
        const imagenPrincipal = '{{ $imagenPrincipal }}';
        const imagenes = '{{ $imagenes }}'.split(',').filter(imagen => imagen.trim() !== '');
        const images = [imagenPrincipal, ...imagenes];

        const slider = document.getElementById('image-slider');
        let currentImageIndex = 0;

        function updateSlider() {
            slider.innerHTML = '';
            const newImage = document.createElement('img');
            newImage.src = images[currentImageIndex];
            newImage.classList.add('active');
            slider.appendChild(newImage);
        }
        
        if(document.getElementById('prev-button')) {
            document.getElementById('prev-button').addEventListener('click', () => {
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                updateSlider();
            });
        }

        if(document.getElementById('next-button')) {
            document.getElementById('next-button').addEventListener('click', () => { 
                currentImageIndex = (currentImageIndex + 1) % images.length;
                updateSlider();
            });
        }

        updateSlider(); 
});

</script>