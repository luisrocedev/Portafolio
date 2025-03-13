document.addEventListener("DOMContentLoaded", () => {
    const introSection = document.getElementById("home");
    const projectsSection = document.getElementById("projects");

    // Asegurar que "Home" esté visible al cargar
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
            } else if (section === "home") {
                projectsSection.style.display = "none";
                introSection.style.display = "flex";
            }
        });
    });
});

// 🎥 Animación de Entrada de Proyectos
function showProjects() {
    const projectItems = document.querySelectorAll(".project-item");
    projectItems.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add("show");
        }, index * 150);
    });
}

// 🌌 Efecto Parallax en el fondo
document.addEventListener("mousemove", (e) => {
    const moveX = (e.clientX / window.innerWidth - 0.5) * 10;
    const moveY = (e.clientY / window.innerHeight - 0.5) * 10;
    document.documentElement.style.setProperty("--parallaxX", `${moveX}px`);
    document.documentElement.style.setProperty("--parallaxY", `${moveY}px`);
});
function showProjects() {
    const projectItems = document.querySelectorAll(".project-item");
    projectItems.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add("show");
        }, index * 200); // Efecto más suave
    });
}
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        document.querySelectorAll(".fade-in").forEach(el => {
            el.classList.add("show");
        });
    }, 500);
});

