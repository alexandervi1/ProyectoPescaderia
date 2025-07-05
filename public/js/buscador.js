function filtrarProductos() {
    const query = document.getElementById('search-input').value.toLowerCase();
    const productItems = document.querySelectorAll('.product-item');

    productItems.forEach(item => {
        const name = item.getAttribute('data-name').toLowerCase();

        if (name.includes(query)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

// Solo filtro al hacer clic en el botón
document.getElementById('search-button').addEventListener('click', function(event) {
    event.preventDefault();
    filtrarProductos();
});

// Opcional: que al presionar Enter también busque
document.getElementById('search-form').addEventListener('submit', function(event) {
    event.preventDefault();
    filtrarProductos();
});
