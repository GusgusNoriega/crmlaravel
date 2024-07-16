
document.querySelectorAll('.accordion').forEach(button => {
  const submenu = button.nextElementSibling;
  const listItem = button.parentElement;

  // Verificar si el elemento tiene la clase 'active' al cargar la página
  if (listItem.classList.contains('active')) {
      submenu.style.height = submenu.scrollHeight + 'px';
  }

    button.addEventListener('click', function() {
      //const submenu = this.nextElementSibling;
      //const listItem = this.parentElement;

      if (submenu.style.height) {
        submenu.style.height = null;
        listItem.classList.remove('active');
      } else {
        submenu.style.height = submenu.scrollHeight + 'px';
        listItem.classList.add('active');
      }
  
      // Opcional: cerrar otros submenús abiertos
      document.querySelectorAll('.submenu').forEach(otherSubmenu => {
        if (otherSubmenu !== submenu) {
          otherSubmenu.style.height = null;
          otherSubmenu.parentElement.classList.remove('active');
        }
      });
    });

  });


  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.image-input').forEach(function(input) {
        input.addEventListener('change', function (e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    // Encuentra el contenedor de miniatura y el botón de quitar correspondiente
                    var thumbnailDiv = input.nextElementSibling;
                    var removeButton = thumbnailDiv.nextElementSibling;

                    thumbnailDiv.innerHTML = '<img src="' + e.target.result + '" width="300" height="300"/>';
                    removeButton.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    document.querySelectorAll('.remove-image').forEach(function(button) {
        button.addEventListener('click', function () {
            var input = this.previousElementSibling.previousElementSibling;
            var thumbnailDiv = this.previousElementSibling;

            input.value = '';
            thumbnailDiv.innerHTML = '';
            this.style.display = 'none';
        });
    });
});

