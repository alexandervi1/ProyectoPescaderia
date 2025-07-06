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

    // Comprobar sesión al cargar la página
    fetch("../controller/getSession.php")
        .then(response => response.json())
        .then(data => {
            console.log("Sesión detectada:", data);
            if (data.rol_id !== 3 && data.nombre_usuario !== "visitante") {
                if (data.rol_id === 1) { // Lógica para Administrador - ¡Revisa esto!
                    // Si es ADMINISTRADOR, puedes redirigirlo o mostrar opciones de admin
                    // Por ahora, tu código muestra opciones de invitado, lo cual es inusual.
                    // Quizás quieras redirigir a un panel de admin.
                    // guestOptions.style.display = "flex";
                    // userOptions.style.display = "none";
                    console.log("Usuario Administrador detectado. Considerar redirigir o mostrar panel.");
                    // Ejemplo de redirección: window.location.href = "Administrador.php";
                    guestOptions.style.display = "none"; // Ocultar opciones de invitado
                    userOptions.style.display = "flex"; // Mostrar opciones de usuario para que vea su nombre/cerrar sesión
                    document.getElementById("user-name").textContent = `: ${data.nombre_usuario} (Admin)`;

                } else if (data.rol_id === 2) { // Si es CLIENTE
                    guestOptions.style.display = "none";
                    userOptions.style.display = "flex";
                    document.getElementById("user-name").textContent = `: ${data.nombre_usuario}`;
                }
            } else { // Usuario visitante
                guestOptions.style.display = "flex";
                userOptions.style.display = "none";
                document.getElementById("user-name").textContent = "";
            }
        })
        .catch(error => console.error("Error al obtener sesión:", error));

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