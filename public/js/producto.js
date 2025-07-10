/* public/js/producto.js */

// Función para cambiar la imagen principal del producto
function cambiarImagen(url) {
    const imagenAmpliada = document.getElementById("imagenAmpliada");
    if (imagenAmpliada) {
        imagenAmpliada.src = url;
    } else {
        console.error("No se encontró el elemento de imagen ampliada.");
    }
}

// Función para cambiar la cantidad en el input (solo en el frontend de producto.php)
function cambiarCantidad(delta) {
    const inputCantidad = document.getElementById('cantidad');
    let cantidadActual = parseInt(inputCantidad.value);
    let nuevaCantidad = cantidadActual + delta;

    if (nuevaCantidad < 1) {
        nuevaCantidad = 1; // Asegura que la cantidad mínima sea 1
    }
    inputCantidad.value = nuevaCantidad;
}

// === Lógica y funciones para la ventana modal de "Producto Agregado" ===
const modalAgregadoCarrito = document.getElementById('modal-agregado-carrito');
const closeButtonAgregado = modalAgregadoCarrito ? modalAgregadoCarrito.querySelector('.close-button') : null;
const modalIrCarritoBtn = document.getElementById('modal-ir-carrito-btn');
const modalSeguirComprandoBtn = document.getElementById('modal-seguir-comprando-btn');
const modalAgregadoMensaje = document.getElementById('modal-agregado-mensaje');

// Función para mostrar la modal de éxito
function mostrarModalProductoAgregado(mensaje) {
    if (modalAgregadoCarrito && modalAgregadoMensaje) {
        modalAgregadoMensaje.textContent = mensaje;
        modalAgregadoCarrito.classList.add('show');
        // Asegurarse de que sea visible si 'show' no maneja el display por sí solo
        modalAgregadoCarrito.style.display = 'flex'; 
    } else {
        console.error("Error: Elementos de la modal de producto agregado no encontrados.");
        alert(mensaje); // Fallback a alert si la modal no se encuentra
    }
}

// Función para ocultar la modal de éxito
function ocultarModalProductoAgregado() {
    if (modalAgregadoCarrito) {
        modalAgregadoCarrito.classList.remove('show');
        // Retrasar el cambio de display para permitir la transición CSS
        setTimeout(() => {
            modalAgregadoCarrito.style.display = 'none';
        }, 300); // Coincide con la duración de la transición CSS
    }
}

// === Función para agregar el producto al carrito (llamada desde el onclick del botón) ===
// NOTA: 'window.' hace que la función sea global, accesible desde el HTML.
window.agregarAlCarrito = function(producto_id, cantidad) {
    console.log("Intentando agregar al carrito - Producto ID:", producto_id, "Cantidad:", cantidad);

    const cantidadFinal = parseInt(cantidad);
    if (isNaN(cantidadFinal) || cantidadFinal < 1) {
        mostrarModalProductoAgregado("Por favor, introduce una cantidad válida (mínimo 1).");
        return;
    }

    fetch('../model/MAgregarAlCarrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `producto_id=${producto_id}&cantidad=${cantidadFinal}`
    })
    .then(response => {
        if (!response.ok) {
            // Intenta leer la respuesta JSON de error si es posible
            return response.json().then(errorData => {
                throw new Error(errorData.message || `Error HTTP: ${response.status}`);
            }).catch(() => {
                // Si no es JSON o falla, usa un mensaje genérico
                throw new Error(`Error HTTP: ${response.status} al agregar al carrito.`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            mostrarModalProductoAgregado(data.message || "Tu producto se ha añadido correctamente al carrito de compras.");
            // Aquí podrías actualizar el contador del carrito en la interfaz
            // Por ejemplo, si tienes una función global para ello:
            // if (typeof actualizarContadorCarrito === 'function') {
            //     actualizarContadorCarrito();
            // }
        } else {
            // Si el backend devuelve status: 'error' (ej. no logueado, sin stock)
            if (data.status === 'not_logged_in') {
                 // Puedes mostrar un mensaje específico o abrir el modal de login si existe
                 mostrarModalProductoAgregado(data.message || "Necesitas iniciar sesión para agregar productos al carrito.");
                 // O si tienes una función para abrir el modal de login en otro JS:
                 // if (typeof openLoginModal === 'function') {
                 //     openLoginModal();
                 // }
            } else {
                mostrarModalProductoAgregado(data.message || "Error al agregar el producto al carrito.");
            }
        }
    })
    .catch(error => {
        console.error('Error en fetch al agregar al carrito:', error);
        mostrarModalProductoAgregado(`Error al agregar al carrito: ${error.message}.`);
    });
};

// === Lógica de DOMContentLoaded para el resto de tu script ===
document.addEventListener("DOMContentLoaded", function() {
    console.log("JavaScript de producto.js cargado correctamente.");

    // === Event Listeners para cerrar la modal de "Producto Agregado" ===
    if (closeButtonAgregado) {
        closeButtonAgregado.addEventListener('click', ocultarModalProductoAgregado);
    }
    // Listener para el botón "Ir al Carrito"
    if (modalIrCarritoBtn) {
        modalIrCarritoBtn.addEventListener('click', function() {
            ocultarModalProductoAgregado(); // Ocultar la modal
            window.location.href = 'carrito.php'; // Redirigir al carrito
        });
    }
    // Listener para el botón "Seguir Comprando"
    if (modalSeguirComprandoBtn) {
        modalSeguirComprandoBtn.addEventListener('click', ocultarModalProductoAgregado); // Solo cierra la modal
    }

    // Cerrar la modal si el usuario hace clic fuera del contenido
    if (modalAgregadoCarrito) {
        window.addEventListener('click', function(event) {
            if (event.target === modalAgregadoCarrito) {
                ocultarModalProductoAgregado();
            }
        });
    }

    // A partir de aquí, la lógica de login/registro y la comprobación de sesión
    // *DEBERÍAN* ser movidas a un archivo JS separado (ej. auth.js o global.js)
    // para mantener este archivo `producto.js` más limpio y específico.

    // Si aún así decides mantenerla aquí por el momento,
    // asegúrate de que los IDs de los elementos HTML existan para que no haya errores
    // y de que no haya conflictos con otros scripts que puedan estar haciendo lo mismo.
    
    // Si la lógica de fetch("../controller/getSession.php") se ejecuta aquí,
    // estaría duplicando la lógica de PHP que ya renderiza la navbar.
    // Solo es útil si la navbar necesita ser _actualizada_ dinámicamente
    // después de un evento como login/logout sin recargar la página.

    // Si quieres que el JS haga la comprobación y actualización de la navbar
    // en todas las páginas, es mejor que esta parte esté en un `global.js`
    // y no en `producto.js`.

    // He comentado la sección de autenticación para enfatizar la separación.
    // /*
    // const guestOptions = document.getElementById("guest-options");
    // const userOptions = document.getElementById("user-options");
    // const userNameSpan = document.getElementById("user-name");

    // if (!guestOptions || !userOptions || !userNameSpan) {
    //     console.warn("Advertencia: No se encontraron todos los elementos del navbar (guestOptions, userOptions, userNameSpan). Algunas funcionalidades de sesión pueden no operar correctamente.");
    // }

    // fetch("../controller/getSession.php")
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error(`HTTP error! status: ${response.status} from getSession.php`);
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         console.log("Sesión detectada (data desde getSession.php):", data);

    //         const isUserLoggedIn = data.usuario_id !== null && data.usuario_id !== 0 && data.rol_id !== null && data.rol_id !== 3; // Asumo rol_id 3 para visitante

    //         if (isUserLoggedIn) {
    //             if (guestOptions && userOptions) {
    //                 guestOptions.style.display = "none";
    //                 userOptions.style.display = "flex";
    //             }
    //             if (userNameSpan) {
    //                 if (data.rol_id === 1) { // Si es ADMINISTRADOR
    //                     userNameSpan.textContent = `Admin: ${data.nombre_usuario || data.nombre_completo || 'Desconocido'}`;
    //                 } else { // Si es CLIENTE
    //                     userNameSpan.textContent = `: ${data.nombre_completo || data.nombre_usuario || 'Desconocido'}`;
    //                 }
    //             }
    //         } else {
    //             if (guestOptions && userOptions) {
    //                 guestOptions.style.display = "flex";
    //                 userOptions.style.display = "none";
    //             }
    //             if (userNameSpan) {
    //                 userNameSpan.textContent = "";
    //             }
    //         }
    //     })
    //     .catch(error => {
    //         console.error("Error al obtener sesión (fetch a getSession.php):", error);
    //         if (guestOptions && userOptions) {
    //             guestOptions.style.display = "flex";
    //             userOptions.style.display = "none";
    //         }
    //     });
    // */

    // --- Lógica de modales de Login/Registro (Idealmente en un archivo JS separado como `auth.js`) ---
    // Si estos modales son globales a todo tu sitio, esta lógica no debería ir en `producto.js`.
    // La dejé aquí comentada para que tengas el contexto, pero fuertemente recomiendo moverla.
    // Esto es solo un ejemplo de cómo podrías tener las referencias si los modales están en el mismo DOM.

    const loginModal = document.getElementById("login-modal");
    const registerModal = document.getElementById("register-modal");
    const openLoginModalBtn = document.getElementById("open-login-modal");
    const openRegisterModalBtn = document.getElementById("open-register-modal");
    const closeLoginModalBtn = document.getElementById("close-login-modal");
    const closeRegisterModalBtn = document.getElementById("close-register-modal");
    const registerLinkInLogin = document.getElementById("show-register"); // Enlace "Registrarse" dentro del modal de login

    // Funciones genéricas para mostrar/ocultar modales de autenticación
    function showModal(modalElement) {
        if (modalElement) {
            modalElement.style.display = "flex"; // Usa flex para centrar
            setTimeout(() => { // Pequeño retraso para que la transición CSS funcione
                modalElement.classList.add('show');
            }, 10); 
        }
    }

    function hideModal(modalElement) {
        if (modalElement) {
            modalElement.classList.remove('show');
            setTimeout(() => {
                modalElement.style.display = "none";
            }, 300); // Coincide con la duración de la transición CSS
        }
    }

    // Event Listeners para abrir/cerrar modales de autenticación
    if (openLoginModalBtn) {
        openLoginModalBtn.addEventListener("click", () => showModal(loginModal));
    }
    if (closeLoginModalBtn) {
        closeLoginModalBtn.addEventListener("click", () => hideModal(loginModal));
    }
    if (openRegisterModalBtn) {
        openRegisterModalBtn.addEventListener("click", () => showModal(registerModal));
    }
    if (closeRegisterModalBtn) {
        closeRegisterModalBtn.addEventListener("click", () => hideModal(registerModal));
    }
    if (registerLinkInLogin) {
        registerLinkInLogin.addEventListener("click", (event) => {
            event.preventDefault();
            hideModal(loginModal);
            // Pequeño retraso para que el modal de login se oculte antes de mostrar el de registro
            setTimeout(() => {
                showModal(registerModal);
            }, 350); 
        });
    }

    // Cerrar modales si se hace clic fuera de su contenido
    window.addEventListener('click', (event) => {
        if (event.target === loginModal) {
            hideModal(loginModal);
        }
        if (event.target === registerModal) {
            hideModal(registerModal);
        }
    });

    // --- Lógica de envío de formularios de Login/Registro (también idealmente en auth.js) ---
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const logoutBtn = document.getElementById("logout-btn"); // Botón de cerrar sesión en la navbar

    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            event.preventDefault();
            let usuario = document.getElementById("login-usuario").value;
            let password = document.getElementById("login-password").value;
            
            // Primero, verificar el rol del usuario (esto puede ser parte de auth.php también)
            fetch("../model/mObtDatos.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `usuario=${usuario}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status} al obtener datos de usuario`);
                }
                return response.json();
            })
            .then(data => {
                if (data.rol_id == 1) { // ADMINISTRADOR
                    loginAdmin(usuario, password);
                } else if (data.rol_id == 2) { // CLIENTE
                    fetch("../controller/auth.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `usuario=${usuario}&password=${password}`
                    })
                    .then(response => {
                       if (!response.ok) {
                           throw new Error(`Error HTTP: ${response.status} al autenticar cliente`);
                       }
                       return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.href = "../controller/redirigir.php";
                        } else {
                            alert("Usuario o contraseña incorrectos para cliente.");
                        }
                    })
                    .catch(error => console.error("Error en el login del cliente:", error));
                } else {
                    alert("Usuario no registrado o rol desconocido.");
                }
            })
            .catch(error => {
                console.error("Error al verificar el rol del usuario:", error);
                alert("Error al intentar iniciar sesión. Por favor, inténtelo de nuevo.");
            });
        });
    }

    function loginAdmin(usuario, password) {
        fetch("../controller/authAdmin.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `usuario=${usuario}&password=${password}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status} al autenticar administrador`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.href = "../Administrador.php";
            } else {
                alert("Usuario o contraseña incorrectos para administrador.");
            }
        })
        .catch(error => console.error("Error en el login de administrador:", error));
    }

    if (registerForm) {
        registerForm.addEventListener("submit", function(event) {
            event.preventDefault();
            let nombreCompleto = document.getElementById("register-nombre").value;
            let usuario = document.getElementById("register-usuario").value;
            let password = document.getElementById("register-password").value;
            fetch("../model/register.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `nombreCompleto=${nombreCompleto}&usuario=${usuario}&password=${password}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status} al registrar usuario`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert("Registro exitoso, ahora inicia sesión.");
                    hideModal(registerModal); // Ocultar el modal de registro
                    // Opcional: Mostrar el modal de login automáticamente
                    // showModal(loginModal);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Error en el registro:", error));
        });
    }

    // Listener para el botón de cerrar sesión de la navbar
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function(event) {
            event.preventDefault(); // Previene la acción por defecto del enlace
            fetch("../controller/logout.php")
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status} al cerrar sesión`);
                    }
                    // Si el cierre de sesión es exitoso, redirigir al inicio o recargar la página
                    window.location.href = "../index.html"; 
                })
                .catch(error => console.error("Error al cerrar sesión:", error));
        });
    }
});

// Nota: La función 'btnQuienes' se eliminó porque en tu HTML (producto.php)
// ya tienes un enlace directo a "../controller/usercontrolador.php?accion=quienes_somos"
// y no necesitas un manejador de eventos JavaScript adicional si solo hace una redirección simple.