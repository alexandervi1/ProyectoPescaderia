// Función para cargar todas las imágenes automáticamente
function cargarImagenesProductos() {
    // Seleccionar todas las imágenes con el atributo `data-producto-id`
    const imagenes = document.querySelectorAll("[data-producto-id]");

    imagenes.forEach(img => {
        const productoId = img.getAttribute("data-producto-id"); // Obtener ID desde el HTML
        if (!productoId) return; // Si no hay ID, no hace nada

        // Hacer la petición al servidor
        fetch(`./model/mBuscimg.php?id=${productoId}`)
            .then(response => response.text()) // Obtener respuesta en texto plano
            .then(imageUrl => {
                console.log(`🔍 Respuesta del servidor para producto ${productoId}:`, imageUrl);

                if (imageUrl.includes("IMG_NOT_FOUND") || imageUrl.includes("ERROR_CONEXION") || imageUrl.includes("ID_NOT_PROVIDED")) {
                    console.error(`❌ Imagen no encontrada para producto ${productoId}`);
                    img.src = "./public/fondo.jpg"; // Imagen de respaldo
                } else {
                    console.log(`🖼️ Asignando imagen al producto ${productoId}:`, imageUrl);
                    img.src = imageUrl; // Asignar la URL a la imagen
                }

                // Asegurarse de que todas las imágenes tengan el mismo tamaño y estén centradas
                img.style.width = "200px"; // Ajusta el tamaño según lo que necesites
                img.style.height = "200px"; // Mantén la proporción cuadrada
                img.style.objectFit = "cover"; // Ajuste para no distorsionar la imagen

                // Centrar la imagen
                img.style.display = "block";
                img.style.marginLeft = "auto";
                img.style.marginRight = "auto";
            })
            .catch(error => console.error(`❌ Error en la petición para producto ${productoId}:`, error));
    });
}
// Ejecutar la función al cargar el DOM
document.addEventListener("DOMContentLoaded", cargarImagenesProductos);
//****************************************************************************************************************************** */


// Función para cargar el nombre del producto automáticamente
function cargarNombreProducto() {
    // Seleccionar todos los elementos con el atributo `data-producto-id`
    const productos = document.querySelectorAll("[data-producto-id]");

    productos.forEach(producto => {
        const productoId = producto.getAttribute("data-producto-id"); // Obtener ID desde el HTML
        if (!productoId) return; // Si no hay ID, no hace nada

        console.log(`🔍 Realizando la petición para el producto con ID: ${productoId}`);

        // Hacer la petición al servidor para obtener el nombre del producto
        fetch(`./model/mBuscNombre.php?id=${productoId}`)
            .then(response => response.text()) // Obtener la respuesta en texto plano
            .then(nombre => {
                console.log(`🔍 Respuesta del servidor para el producto ${productoId}:`, nombre);

                if (nombre.includes("PRODUCTO_NO_ENCONTRADO") || nombre.includes("ERROR_CONEXION") || nombre.includes("ID_NOT_PROVIDED")) {
                    console.error(`❌ Nombre no encontrado para producto ${productoId}`);
                    // Mostrar mensaje por defecto si no se encuentra el nombre
                    producto.textContent = "Producto no disponible";
                } else {
                    console.log(`🛍️ Asignando nombre al producto ${productoId}:`, nombre);
                    // Seleccionar el h5 correspondiente al producto y actualizar su contenido
                    const nombreProducto = document.querySelector(`h5[data-producto-id="${productoId}"]`);
                    if (nombreProducto) {
                        nombreProducto.textContent = nombre; // Asignar el nombre al h5 correspondiente
                    } else {
                        console.error(`❌ No se encontró el h5 correspondiente para el producto ${productoId}`);
                    }
                }
            })
            .catch(error => {
                console.error(`❌ Error en la petición para el producto ${productoId}:`, error);
            });
    });
}

// Ejecutar la función al cargar el DOM
document.addEventListener("DOMContentLoaded", cargarNombreProducto);
//******************************************************************************************************** */


// Función para cargar la descripción del producto automáticamente
function cargarDescripcionProducto() {
    // Seleccionar todos los elementos con el atributo `data-producto-id`
    const productos = document.querySelectorAll("[data-producto-id]");

    productos.forEach(producto => {
        const productoId = producto.getAttribute("data-producto-id"); // Obtener ID desde el HTML
        if (!productoId) return; // Si no hay ID, no hace nada

        console.log(`🔍 Realizando la petición para el producto con ID: ${productoId}`);

        // Hacer la petición al servidor para obtener la descripción del producto
        fetch(`./model/mBuscDescrip.php?id=${productoId}`)
            .then(response => response.text()) // Obtener la respuesta en texto plano
            .then(descripcion => {
                console.log(`🔍 Respuesta del servidor para el producto ${productoId}:`, descripcion);

                if (descripcion.includes("PRODUCTO_NO_ENCONTRADO") || descripcion.includes("ERROR_CONEXION") || descripcion.includes("ID_NOT_PROVIDED")) {
                    console.error(`❌ Descripción no encontrada para producto ${productoId}`);
                    // Mostrar mensaje por defecto si no se encuentra la descripción
                    producto.textContent = "Descripción no disponible";
                } else {
                    console.log(`🛍️ Asignando descripción al producto ${productoId}:`, descripcion);
                    // Seleccionar el elemento de descripción correspondiente y actualizar su contenido
                    const descripcionProducto = document.querySelector(`p[data-producto-id="${productoId}"]`);
                    if (descripcionProducto) {
                        descripcionProducto.textContent = descripcion; // Asignar la descripción al p correspondiente
                    } else {
                        console.error(`❌ No se encontró el p correspondiente para el producto ${productoId}`);
                    }
                }
            })
            .catch(error => {
                console.error(`❌ Error en la petición para el producto ${productoId}:`, error);
            });
    });
}

// Ejecutar la función al cargar el DOM
document.addEventListener("DOMContentLoaded", cargarDescripcionProducto);
//**************************************************************************** */

// Función para cargar el precio del producto automáticamente
function cargarPrecioProducto() {
    // Seleccionar todos los elementos con el atributo `data-producto-id`
    const productos = document.querySelectorAll("[data-producto-id]");

    productos.forEach(producto => {
        const productoId = producto.getAttribute("data-producto-id"); // Obtener ID desde el HTML
        if (!productoId) return; // Si no hay ID, no hace nada

        console.log(`🔍 Realizando la petición para el producto con ID: ${productoId}`);

        // Hacer la petición al servidor para obtener el precio del producto
        fetch(`./model/mBuscPrecio.php?id=${productoId}`)
            .then(response => response.text()) // Obtener la respuesta en texto plano
            .then(precio => {
                console.log(`🔍 Respuesta del servidor para el producto ${productoId}:`, precio);

                if (precio.includes("PRODUCTO_NO_ENCONTRADO") || precio.includes("ERROR_CONEXION") || precio.includes("ID_NOT_PROVIDED")) {
                    console.error(`❌ Precio no encontrado para producto ${productoId}`);
                    // Mostrar mensaje por defecto si no se encuentra el precio
                    producto.textContent = "Precio no disponible";
                } else {
                    console.log(`🛍️ Asignando precio al producto ${productoId}:`, precio);
                    // Seleccionar el elemento de precio correspondiente y actualizar su contenido
                    const precioProducto = document.querySelector(`p.product-price[data-producto-id="${productoId}"]`);
                    if (precioProducto) {
                        precioProducto.textContent = `$${precio}`; // Asignar el precio al p correspondiente
                    } else {
                        console.error(`❌ No se encontró el p correspondiente para el producto ${productoId}`);
                    }
                }
            })
            .catch(error => {
                console.error(`❌ Error en la petición para el producto ${productoId}:`, error);
            });
    });
}

// Ejecutar la función al cargar el DOM
document.addEventListener("DOMContentLoaded", cargarPrecioProducto);

//*/************************************************************************ */

// Función para cargar el descuento del producto automáticamente
function cargarDescuentoProducto() {
    // Seleccionar todos los elementos con el atributo `data-producto-id`
    const productos = document.querySelectorAll("[data-producto-id]");

    productos.forEach(producto => {
        const productoId = producto.getAttribute("data-producto-id"); // Obtener ID desde el HTML
        if (!productoId) return; // Si no hay ID, no hace nada

        console.log(`🔍 Realizando la petición para el producto con ID: ${productoId}`);

        // Hacer la petición al servidor para obtener el descuento del producto
        fetch(`./model/mBuscDesc.php?id=${productoId}`)
            .then(response => response.text()) // Obtener la respuesta en texto plano
            .then(descuento => {
                console.log(`🔍 Respuesta del servidor para el producto ${productoId}:`, descuento);

                if (descuento.includes("PRODUCTO_NO_ENCONTRADO") || descuento.includes("ERROR_CONEXION") || descuento.includes("ID_NOT_PROVIDED")) {
                    console.error(`❌ Descuento no encontrado para producto ${productoId}`);
                    // Mostrar mensaje por defecto si no se encuentra el descuento
                    producto.textContent = "Descuento no disponible";
                } else {
                    console.log(`🛍️ Asignando descuento al producto ${productoId}:`, descuento);
                    // Seleccionar el elemento de descuento correspondiente y actualizar su contenido
                    const descuentoProducto = document.querySelector(`span.product-discount[data-producto-id="${productoId}"]`);
                    if (descuentoProducto) {
                        descuentoProducto.textContent = `Descuento: ${descuento}%`; // Asignar el descuento al span correspondiente
                    } else {
                        console.error(`❌ No se encontró el span correspondiente para el producto ${productoId}`);
                    }
                }
            })
            .catch(error => {
                console.error(`❌ Error en la petición para el producto ${productoId}:`, error);
            });
    });
}

// Ejecutar la función al cargar el DOM
document.addEventListener("DOMContentLoaded", cargarDescuentoProducto);


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-input");
    const searchSuggestions = document.getElementById("search-suggestions");

    searchInput.addEventListener("input", function() {
        const query = searchInput.value.trim();

        // Validación: Solo permitir letras (mayúsculas y minúsculas) y espacios
        if (!/^[A-Za-z\s]*$/.test(query)) {
            searchInput.value = "";
            return;
        }

        console.log("Consulta de búsqueda: " + query); // Mensaje de depuración
        if (query.length > 0) {
            fetch(`./model/barrabusqueda.php?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data); // Mensaje de depuración
                    mostrarSugerencias(data);
                })
                .catch(error => console.error("Error en la petición:", error));
        } else {
            searchSuggestions.innerHTML = "";
        }
    });

    searchSuggestions.addEventListener("click", function(event) {
        if (event.target.tagName === "LI") {
            const productoId = event.target.getAttribute("data-producto-id");
            const productoNombre = event.target.textContent;
            console.log("ID del producto seleccionado: " + productoId); // Mensaje de depuración
            console.log("Nombre del producto seleccionado: " + productoNombre); // Mensaje de depuración
            searchInput.value = productoNombre;
            searchSuggestions.innerHTML = "";
            window.location.href = `view/producto.php?id=${productoId}=${encodeURIComponent(productoId)}`;
        }
    });

    document.getElementById("search-form").addEventListener("submit", function(event) {
        event.preventDefault();
        const query = searchInput.value.trim();
        if (query.length > 0) {
            console.log("Enviando consulta de búsqueda: " + query); // Mensaje de depuración
            window.location.href = `view/producto.php?query=${query}`;
        }
    });

    function mostrarSugerencias(productos) {
        searchSuggestions.innerHTML = "";
        if (productos.length > 0) {
            const ul = document.createElement("ul");
            productos.forEach(producto => {
                const li = document.createElement("li");
                li.textContent = producto.nombre;
                li.setAttribute("data-producto-id", producto.producto_id); // Agregar el ID del producto
                ul.appendChild(li);
            });
            searchSuggestions.appendChild(ul);
        }
    }
});