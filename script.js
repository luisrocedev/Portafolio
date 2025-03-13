document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll(".section");
    const links = document.querySelectorAll(".sidebar nav ul li a");

    function showSection(sectionId) {
        sections.forEach(sec => {
            sec.style.display = "none"; // Ocultar todas las secciones
        });
        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.style.display = "flex"; // Mostrar la sección activa
        }
    }

    // Mostrar solo "Home" al inicio
    showSection("home");

    links.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const section = e.target.getAttribute("data-section");
            showSection(section);
        });
    });

    // 🎥 Animación de Entrada de Proyectos
    function showProjects() {
        const projectItems = document.querySelectorAll(".project-item");
        projectItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add("show");
            }, index * 200);
        });
    }

    // Si se entra en la sección de Projects, activar animación
    document.querySelector("[data-section='projects']").addEventListener("click", () => {
        setTimeout(showProjects, 300);
    });

    // 🌌 Efecto Parallax en el fondo
    document.addEventListener("mousemove", (e) => {
        const moveX = (e.clientX / window.innerWidth - 0.5) * 10;
        const moveY = (e.clientY / window.innerHeight - 0.5) * 10;
        document.documentElement.style.setProperty("--parallaxX", `${moveX}px`);
        document.documentElement.style.setProperty("--parallaxY", `${moveY}px`);
    });

    // 🌟 Animación de Fade-In para texto e imágenes
    setTimeout(() => {
        document.querySelectorAll(".fade-in").forEach(el => {
            el.classList.add("show");
        });
    }, 500);
});