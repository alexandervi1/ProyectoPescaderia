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