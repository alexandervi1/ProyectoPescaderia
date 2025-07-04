// Aquí puedes agregar scripts personalizados para interactividad.
//console.log("Script cargado correctamente.");
document.addEventListener("DOMContentLoaded", function() {
    fetch("controller/getSession.php")
        .then(response => response.json())
        .then(data => {
            if (data.usuario_id) { // Si hay sesión iniciada
                document.getElementById("guest-options").style.display = "none";
                document.getElementById("user-options").style.display = "flex";
                document.getElementById("user-name").textContent = data.nombre_usuario;
            } else {
                document.getElementById("guest-options").style.display = "flex";
                document.getElementById("user-options").style.display = "none";
            }
        })
        .catch(error => console.error("Error al obtener sesión:", error));
});