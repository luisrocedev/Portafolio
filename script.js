document.addEventListener("DOMContentLoaded", () => {
    const introSection = document.getElementById("home");
    const projectsSection = document.getElementById("projects");

    // Mostrar "Home" por defecto
    introSection.style.display = "flex";
    projectsSection.style.display = "none";

    document.querySelectorAll(".sidebar nav ul li a").forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const section = e.target.getAttribute("data-section");

            if (section === "projects") {
                introSection.style.display = "none";
                projectsSection.style.display = "block";
                showProjects();
            } else {
                projectsSection.style.display = "none";
                introSection.style.display = "flex";
            }
        });
    });

    // Activar animación de entrada en los elementos con "fade-in"
    document.querySelectorAll(".fade-in").forEach(el => el.classList.add("show"));
});

// 🎥 Animación de Entrada de Proyectos
function showProjects() {
    document.querySelectorAll(".project-item").forEach((item, index) => {
        setTimeout(() => {
            item.classList.add("show");
        }, index * 200);
    });
}

// 🌌 Efecto Parallax en el fondo
document.addEventListener("mousemove", (e) => {
    document.documentElement.style.setProperty("--parallaxX", `${(e.clientX / window.innerWidth - 0.5) * 10}px`);
    document.documentElement.style.setProperty("--parallaxY", `${(e.clientY / window.innerHeight - 0.5) * 10}px`);
});
