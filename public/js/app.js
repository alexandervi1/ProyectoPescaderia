document.addEventListener("DOMContentLoaded", function() {
    console.log("JavaScript cargado correctamente."); // ✅ Verifica que el script se ejecuta ay quiero pito 
    //elementos para conectar con el logueo 
    let loginForm = document.getElementById("login-form");
    let registerForm = document.getElementById("register-form");
    let userOptions = document.getElementById("user-options");
    let guestOptions = document.getElementById("guest-options");
    let logoutBtn = document.getElementById("logout-btn");
    let adminLoginForm = document.getElementById("admin-login-form"); // ❌ Eliminar ya no funciona en el nuevo inicio de sesion
    // Elementos del DOM para ventanas modales
    let btnQuienes = document.getElementById("btn-quienes");
    let btnLogin = document.getElementById("open-login-modal");
    let btnRegister = document.getElementById("open-register-modal");
    let btnAdmin = document.getElementById("open-admin-modal"); // ❌ Eliminar ya no funciona en el nuevo inicio de sesion
    let loginModal = document.getElementById("login-modal");
    let registerModal = document.getElementById("register-modal");
    let closeLoginModal = document.getElementById("close-login-modal");
    let closeRegisterModal = document.getElementById("close-register-modal");
    let registerLink = document.getElementById("show-register");
    let adminLoginModal = document.getElementById("admin-login-modal"); // ❌ Eliminar ya no funciona en el nuevo inicio de sesion
    let closeAdminModal = document.getElementById("close-admin-modal"); // ❌ Eliminar ya no funciona en el nuevo inicio de sesion


    // ✅ Comprobar sesión al cargar la página
    fetch("controller/getSession.php")
        .then(response => response.json())
        .then(data => {
            console.log("Sesión detectada:", data); // 🔍 Debugging en consola

            if (data.rol_id !== 3 && data.nombre_usuario !== "visitante") {
                // Si el usuario ha iniciado sesión
                if (data.rol_id === 1) {
                    guestOptions.style.display = "flex"; // Mostrar botones "Iniciar sesión" y "Registrarse"
                    userOptions.style.display = "none"; // Ocultar datos de usuario
                } else {
                    // Si es CLIENTE, mostrar su información
                    guestOptions.style.display = "none";
                    userOptions.style.display = "flex";
                    document.getElementById("user-name").textContent = `: ${data.nombre_usuario}`; // Mostrar el nombre
                }
            } else {
                // Usuario visitante
                guestOptions.style.display = "flex";
                userOptions.style.display = "none";
                document.getElementById("user-name").textContent = ""; // Limpiar el nombre
            }
        })
        .catch(error => console.error("Error al obtener sesión:", error));

    // ✅ Manejo del login adaptado para clientes y administradores
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
                                    //loginModal.style.opacity = "0";
                                    //loginModal.style.visibility = "hidden";
                                    window.location.href = "controller/redirigir.php";
                                } else {
                                    alert("Usuario o contraseña incorrectos");
                                }
                            })
                            .catch(error => console.error("Error en el login:", error));
                    } else {
                        alert("Usuario no registrado");
                    }
                })
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
                    //adminLoginModal.style.opacity = "0";
                    //adminLoginModal.style.visibility = "hidden";
                    window.location.href = "Administrador.php"; // Redirige a `Administrador.php`
                } else {
                    alert("Usuario o contraseña incorrectos");
                }
            })
            .catch(error => console.error("Error en el login de administrador:", error));
    }

    if (adminLoginForm) { //anterior forman de control de sesion admin
        adminLoginForm.addEventListener("submit", function(event) {
            event.preventDefault();

            let usuario = document.getElementById("admin-usuario").value;
            let password = document.getElementById("admin-password").value;

            fetch("./controller/authAdmin.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `usuario=${usuario}&password=${password}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //adminLoginModal.style.opacity = "0";
                        //adminLoginModal.style.visibility = "hidden";
                        window.location.href = "Administrador.php"; // Redirige a `Administrador.php`
                    } else {
                        alert("Usuario o contraseña incorrectos");
                    }
                })
                .catch(error => console.error("Error en el login de administrador:", error));
        });
    }

    // ✅ Manejo del registro
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

    // ✅ Acción para "¿Quiénes Somos?"
    if (btnQuienes) {
        btnQuienes.addEventListener("click", function() {
            window.location.href = "./controller/usercontrolador.php?accion=quienes_somos";
        });
    }

    // ✅ Acción para "Iniciar Sesión"
    if (btnLogin) {
        btnLogin.addEventListener("click", function() {
            fetch("./controller/usercontrolador.php?accion=login")
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

    // ✅ Acción para cerrar el modal de login
    if (closeLoginModal) {
        closeLoginModal.addEventListener("click", function() {
            loginModal.style.opacity = "0";
            loginModal.style.visibility = "hidden";
        });
    }

    // ✅ Cerrar modal de registro con la X
    if (closeRegisterModal) {
        closeRegisterModal.addEventListener("click", function() {
            registerModal.style.opacity = "0";
            registerModal.style.visibility = "hidden";
        });
    }
    // ✅ Cerrar el modal si se hace clic fuera del contenido
    window.addEventListener("click", function(event) {
        if (event.target === loginModal) {
            loginModal.style.opacity = "0";
            loginModal.style.visibility = "hidden";
        }
        if (event.target === registerModal) {
            registerModal.style.opacity = "0";
            registerModal.style.visibility = "hidden";
        }
        if (event.target === adminLoginModal) { // ❌ eliminar ya no funciona en el nuevo inicio de sesion 
            adminLoginModal.style.opacity = "0";
            adminLoginModal.style.visibility = "hidden";
        }
    });

    // ✅ Acción para "Registrarse"
    if (btnRegister) {
        btnRegister.addEventListener("click", function() {
            fetch("./controller/usercontrolador.php?accion=registro")
                .then(response => response.json())
                .then(data => {
                    if (data.modal === "registro") {
                        registerModal.style.opacity = "1";
                        registerModal.style.visibility = "visible";
                    }
                });
        });
    }

    // ✅ Pasar del login al registro
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
    // ❌ Abrir modal de Administrador (eliminar ya no funciona en el nuevo inicio de sesion)
    if (btnAdmin) {
        btnAdmin.addEventListener("click", function() {
            adminLoginModal.style.opacity = "1";
            adminLoginModal.style.visibility = "visible";
        });
    }

    // ❌ Cerrar modal de Administrador con la "X" (eliminar ya no funciona en el nuevo inicio de sesion)
    if (closeAdminModal) {
        closeAdminModal.addEventListener("click", function() {
            adminLoginModal.style.opacity = "0";
            adminLoginModal.style.visibility = "hidden";
        });
    }

    // ✅ Cerrar sesión
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function() {
            fetch("controller/logout.php")
                .then(() => {
                    window.location.href = "index.html";
                })
                .catch(error => console.error("Error al cerrar sesión:", error));
        });
    }
});