document.addEventListener("DOMContentLoaded", function() {
    let userOptions = document.getElementById("user-options");
    let guestOptions = document.getElementById("guest-options");

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
});