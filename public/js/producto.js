/* public/js/producto.js */
function cambiarImagen(url) {
    const imagenAmpliada = document.getElementById("imagenAmpliada");
    if (imagenAmpliada) {
        imagenAmpliada.src = url; // Actualizar la fuente de la imagen ampliada
    } else {
        console.error("No se encontró el elemento de imagen ampliada.");
    }
}

// REMOVIDO: La función cambiarCantidad se mueve a carrito.js
// REMOVIDO: La función agregarAlCarrito se mueve a carrito.js
// REMOVIDO: La función mostrarModal se mueve a carrito.js (o se considera un archivo utilitario)
// REMOVIDO: El window.onclick para cerrar el modal se mueve a carrito.js

document.addEventListener("DOMContentLoaded", function() {
    console.log("JavaScript cargado correctamente.");

    let loginForm = document.getElementById("login-form");
    let registerForm = document.getElementById("register-form");
    let userOptions = document.getElementById("user-options");
    let guestOptions = document.getElementById("guest-options");
    let logoutBtn = document.getElementById("logout-btn");
    let btnQuienes = document.getElementById("btn-quienes");
    let btnLogin = document.getElementById("open-login-modal");
    let btnRegister = document.getElementById("open-register-modal");
    let loginModal = document.getElementById("login-modal");
    let registerModal = document.getElementById("register-modal");
    let closeLoginModal = document.getElementById("close-login-modal");
    let closeRegisterModal = document.getElementById("close-register-modal");
    let registerLink = document.getElementById("show-register");

    // ✅ Comprobar sesión al cargar la página
document.addEventListener("DOMContentLoaded", function() {
    // Es buena práctica obtener las referencias a los elementos una sola vez fuera de la función fetch
    const guestOptions = document.getElementById("guest-options");
    const userOptions = document.getElementById("user-options");
    const userNameSpan = document.getElementById("user-name"); // Asegúrate de que este ID exista en tu HTML

    // Depuración: Asegúrate de que los elementos HTML se encuentren
    console.log("Elementos HTML:", { guestOptions, userOptions, userNameSpan });

    // Asegúrate de que los elementos existan antes de intentar manipularlos
    if (!guestOptions || !userOptions || !userNameSpan) {
        console.error("Error: No se encontraron los elementos del navbar. Verifica los IDs en tu HTML.");
        return; // Detiene la ejecución si los elementos no están presentes
    }

    fetch("../controller/getSession.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Sesión detectada (data desde getSession.php):", data); // 🔍 Debugging en consola

            // Condición para determinar si un usuario está logueado y no es un "visitante" hardcodeado
            // Un usuario está logueado si tiene un usuario_id NO NULO y un rol_id que no sea el de visitante (si usas 3 para visitante)
            // Si getSession.php devuelve 'null's para visitantes, la primera parte (data.usuario_id) es suficiente.
            const isUserLoggedIn = data.usuario_id !== null && data.usuario_id !== 0 && data.rol_id !== null && data.rol_id !== 3;

            if (isUserLoggedIn) {
                // El usuario ha iniciado sesión (es cliente o admin real)

                if (data.rol_id === 1) { // Si es un ADMINISTRADOR (rol_id = 1)
                    // Mostrar las opciones de usuario logueado para el administrador
                    guestOptions.style.display = "none";
                    userOptions.style.display = "flex";
                    // Puedes mostrar un nombre específico para el admin o "Administrador"
                    userNameSpan.textContent = `Admin: ${data.nombre_usuario || data.nombre_completo}`;
                    // Aquí podrías añadir lógica para mostrar/ocultar botones específicos de admin
                } else { // Si es un CLIENTE (rol_id = 2 u otro que no sea 1 o 3)
                    guestOptions.style.display = "none";
                    userOptions.style.display = "flex";
                    userNameSpan.textContent = `: ${data.nombre_completo || data.nombre_usuario}`; // Preferir nombre_completo
                }
            } else {
                // Usuario no logueado (visitante)
                guestOptions.style.display = "flex";    // Mostrar botones "Iniciar sesión" y "Registrarse"
                userOptions.style.display = "none";     // Ocultar datos de usuario logueado
                userNameSpan.textContent = "";          // Limpiar el nombre de usuario
            }
        })
        .catch(error => {
            console.error("Error al obtener sesión (fetch):", error);
            // En caso de error, puedes decidir mostrar las opciones de invitado por defecto
            if (guestOptions && userOptions) {
                guestOptions.style.display = "flex";
                userOptions.style.display = "none";
            }
        });

    // ... (Tu código para el manejo de formularios de login/logout, etc.) ...
});

    // Manejo del login adaptado para clientes y administradores
    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            event.preventDefault();
            let usuario = document.getElementById("login-usuario").value;
            let password = document.getElementById("login-password").value;
            fetch("model/mObtDatos.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `usuario=${usuario}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.rol_id == 1) {
                        loginAdmin(usuario, password);
                    } else if (data.rol_id == 2) {
                        fetch("./controller/auth.php", {
                                method: "POST",
                                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                body: `usuario=${usuario}&password=${password}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.href = "controller/redirigir.php";
                                } else {
                                    alert("Usuario o contraseña incorrectos");
                                }
                            })
                            .catch(error => console.error("Error en el login:", error));
                    } else {
                        alert("Usuario no registrado");
                    }
                });
        });
    }

    // Funcion de Login de Administrador adaptado
    function loginAdmin(usuario, password) {
        fetch("./controller/authAdmin.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `usuario=${usuario}&password=${password}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "Administrador.php"; // Redirige a `Administrador.php`
                } else {
                    alert("Usuario o contraseña incorrectos");
                }
            })
            .catch(error => console.error("Error en el login de administrador:", error));
    }

    // Manejo del registro
    if (registerForm) {
        registerForm.addEventListener("submit", function(event) {
            event.preventDefault();
            let nombreCompleto = document.getElementById("register-nombre").value;
            let usuario = document.getElementById("register-usuario").value;
            let password = document.getElementById("register-password").value;
            fetch("model/register.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `nombreCompleto=${nombreCompleto}&usuario=${usuario}&password=${password}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Registro exitoso, ahora inicia sesión.");
                        document.getElementById("register-modal").style.display = "none";
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Error en el registro:", error));
        });
    }

    // Acción para "¿Quiénes Somos?"
    if (btnQuienes) {
        btnQuienes.addEventListener("click", function() {
            window.location.href = "../controller/usercontrolador.php?accion=quienes_somos";
        });
    }

    // Acción para "Iniciar Sesión"
    if (btnLogin) {
        btnLogin.addEventListener("click", function() {
            fetch("../controller/usercontrolador.php?accion=login")
                .then(response => response.json())
                .then(data => {
                    if (data.modal === "login") {
                        loginModal.style.opacity = "1";
                        loginModal.style.visibility = "visible";
                    } else {
                        console.error("No se recibió la respuesta esperada para abrir el modal.");
                    }
                })
                .catch(error => console.error("Error al solicitar el modal de login:", error));
        });
    }

    // Acción para cerrar el modal de login
    if (closeLoginModal) {
        closeLoginModal.addEventListener("click", function() {
            loginModal.style.opacity = "0";
            loginModal.style.visibility = "hidden";
        });
    }

    // Cerrar modal de registro con la X
    if (closeRegisterModal) {
        closeRegisterModal.addEventListener("click", function() {
            registerModal.style.opacity = "0";
            registerModal.style.visibility = "hidden";
        });
    }

    // Cerrar el modal si se hace clic fuera del contenido
    // REVISAR: Si tienes un modal de producto y otros, esta lógica puede interferir.
    // window.addEventListener("click", function(event) {
    //     if (event.target === loginModal) {
    //         loginModal.style.opacity = "0";
    //         loginModal.style.visibility = "hidden";
    //     }
    //     if (event.target === registerModal) {
    //         registerModal.style.opacity = "0";
    //         registerModal.style.visibility = "hidden";
    //     }
    // });
    // **Nota:** El `window.onclick` para cerrar modales de login/registro ya no necesita estar aquí si lo manejarás individualmente o con una lógica más específica. Si tu modal de "producto agregado" también se cierra así, asegúrate de que no haya conflicto.

    // Acción para "Registrarse"
    if (btnRegister) {
        btnRegister.addEventListener("click", function() {
            fetch("../controller/usercontrolador.php?accion=registro")
                .then(response => response.json())
                .then(data => {
                    if (data.modal === "registro") {
                        registerModal.style.opacity = "1";
                        registerModal.style.visibility = "visible";
                    }
                });
        });
    }

    // Pasar del login al registro
    if (registerLink) {
        registerLink.addEventListener("click", function(event) {
            event.preventDefault();
            loginModal.style.opacity = "0";
            loginModal.style.visibility = "hidden";
            setTimeout(function() {
                registerModal.style.opacity = "1";
                registerModal.style.visibility = "visible";
            }, 300);
        });
    }

    // Cerrar sesión
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function() {
            // RUTA CORREGIDA: Desde public/js/ a controller/logout.php
            fetch("../controller/logout.php")
                .then(() => {
                    window.location.href = "../index.html"; // Redirigir a la página principal
                })
                .catch(error => console.error("Error al cerrar sesión:", error));
        });
    }
});
function agregarAlCarrito(producto_id, cantidad) {
    // Realiza una petición POST a MAgregarAlCarrito.php para agregar el producto

    fetch('../model/MAgregarAlCarrito.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        // CAMBIO AQUÍ: Usa ${} para interpolar los valores de las variables
        body: `producto_id=${producto_id}&cantidad=${cantidad}` 
        // ¡Ojo! Asegúrate de que las variables 'producto_id' y 'cantidad'
        // que pasas a la función tengan valores válidos cuando se llama.
    })
    .then(res => {
        // Mejorar el manejo de errores para respuestas no JSON o errores HTTP
        if (!res.ok) {
            // Si la respuesta no es 2xx, lanza un error que será capturado por el .catch
            return res.json().then(errorData => {
                throw new Error(errorData.message || 'Error en el servidor');
            }).catch(() => {
                // Si ni siquiera es JSON, o el JSON es inválido
                throw new Error(`HTTP error! status: ${res.status}`);
            });
        }
        return res.json(); // Convierte la respuesta en JSON
    })
    .then(data => {
        // Si el servidor responde con éxito
        if (data.status === 'success') {
            mostrarModal('Producto agregado al carrito.', 'success');
        } else {
            // Si hubo un error, muestra el mensaje recibido o uno genérico
            mostrarModal(data.message || 'Error al agregar al carrito.', 'error');
        }
    })
    .catch(error => {
        // En caso de error en la red o inesperado, se muestra en consola y modal de error
        console.error("Error al agregar al carrito (fetch):", error);
        mostrarModal(error.message || 'Error de red al agregar al carrito.', 'error');
    });
}
function mostrarModal(mensaje, tipo) {
  const modal = document.getElementById("modal");
  const modalMensaje = document.getElementById("modal-mensaje");

  modalMensaje.textContent = mensaje;
  modal.style.display = "flex";

  setTimeout(() => {
    modal.style.display = "none";
  }, 2000);
}

// Función para mostrar el modal de mensaje (ya la tenías y es correcta)
function mostrarModal(mensaje) {
    const modal = document.getElementById("modal");
    const modalMensaje = document.getElementById("modal-mensaje");
    modalMensaje.textContent = mensaje;
    modal.style.display = "flex"; // Usa flex para centrar
    setTimeout(() => {
        modal.style.display = "none";
    }, 2000); // El modal desaparece después de 2 segundos
}

// Función para cambiar la imagen principal (si la usas)
function cambiarImagen(nuevaSrc) {
    document.getElementById('imagenAmpliada').src = nuevaSrc;
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

// Función para agregar el producto al carrito.
// Esta función realizará una petición al servidor y mostrará el mensaje.
function agregarAlCarrito(producto_id, cantidad) {
    const cantidadFinal = parseInt(cantidad); // Asegúrate de que sea un número entero

    if (isNaN(cantidadFinal) || cantidadFinal < 1) {
        mostrarModal("Por favor, introduce una cantidad válida.");
        return;
    }

    // Realizar la petición POST a mAgregarAlCarrito.php
    fetch('../model/mAgregarAlCarrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Es importante para enviar datos POST
        },
        body: `producto_id=${producto_id}&cantidad=${cantidadFinal}`
    })
    .then(response => {
        // Manejar respuestas HTTP que no sean OK (ej. 401 Unauthorized, 500 Internal Server Error)
        if (!response.ok) {
            // Intentar leer el cuerpo de la respuesta como JSON para un mensaje de error del servidor
            return response.json().then(errorData => {
                throw new Error(errorData.message || `Error HTTP: ${response.status}`);
            }).catch(() => {
                // Si la respuesta no es JSON (ej. HTML de error 404/500), lanzar un error genérico
                throw new Error(`Error HTTP: ${response.status} al agregar al carrito.`);
            });
        }
        return response.json(); // Si la respuesta es OK, la parseamos como JSON
    })
    .then(data => {
        if (data.status === 'success') {
            // Mostrar mensaje de éxito desde el backend o un mensaje predeterminado
            mostrarModal(data.message || "Producto agregado al carrito con éxito.");

            // Opcional: Si tienes una forma de actualizar el icono/contador del carrito en el navbar, hazlo aquí
            // Por ejemplo, si app.js tiene una función llamada 'actualizarContadorCarrito'
            // if (typeof actualizarContadorCarrito === 'function') {
            //     actualizarContadorCarrito();
            // }

        } else {
            // Si el backend devuelve status: 'error'
            mostrarModal(data.message || "Error al agregar el producto al carrito.");
        }
    })
    .catch(error => {
        console.error('Error al agregar al carrito:', error);
        // Personaliza el mensaje de error para el usuario
        if (error.message.includes("401")) { // Si el error es por HTTP 401 (Usuario no autenticado)
            mostrarModal("Necesitas iniciar sesión para agregar productos al carrito.");
            // Aquí podrías abrir un modal de login o redirigir
            // Ejemplo: $('#loginModal').modal('show'); // Si usas Bootstrap modals
        } else {
            mostrarModal(`Error al agregar al carrito: ${error.message}.`);
        }
    });
}

// Puedes añadir aquí cualquier otra función específica de producto.js
// como el manejo de modals de login/registro si los mueves aquí.