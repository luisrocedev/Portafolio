document.addEventListener("DOMContentLoaded", () => {
    // 1. Inicializar Navegación de Secciones
    initSections();
  
    // 2. Inicializar Panel de Opciones (Light / Dark / Monospaced)
    initThemePanel();
  
    // 3. Efecto Parallax en el background (body::before)
    initParallax();
  
    // 4. Fade-in global (para .fade-in)
    initFadeInGlobal();
  
    // 5. Intersection Observer (scroll reveal)
    initScrollReveal();
  
    // 6. Canvas Animado
    initCanvasAnimation();
  });
  
  /* ===============================
     Módulo 1: Navegación y 
     animación escalonada de secciones
  =============================== */
  function initSections() {
    const sections = document.querySelectorAll("main section");
    const links = document.querySelectorAll(".nav-list li a");
  
    // Mostrar HOME por defecto
    showSection("home");
  
    links.forEach(link => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        const sectionId = link.getAttribute("data-section");
        showSection(sectionId);
      });
    });
  
    function showSection(sectionId) {
      sections.forEach(sec => {
        sec.style.display = (sec.id === sectionId) ? "flex" : "none";
      });
      animateSectionItems(sectionId);
    }
  
    // .section-item => animación escalonada
    function animateSectionItems(sectionId) {
      const items = document.querySelectorAll(`#${sectionId} .section-item`);
      items.forEach((item, index) => {
        item.classList.remove("show");
        setTimeout(() => {
          item.classList.add("show");
        }, 150 * index);
      });
    }
  }
  
  /* ===============================
     Módulo 2: Panel de Opciones 
     (Light / Dark / Monospaced)
  =============================== */
  function initThemePanel() {
    const toggleDark = document.getElementById("toggle-dark");
    const toggleMono = document.getElementById("toggle-mono");
  
    // Leer del localStorage si deseas
    // Ejemplo: const savedDark = localStorage.getItem("dark-mode") === "true";
  
    toggleDark.addEventListener("change", () => {
      document.body.classList.toggle("light-mode", !toggleDark.checked);
      document.body.classList.toggle("dark-mode", toggleDark.checked);
      // Guardar en localStorage si quieres: localStorage.setItem("dark-mode", toggleDark.checked);
    });
  
    toggleMono.addEventListener("change", () => {
      document.body.classList.toggle("mono-font", toggleMono.checked);
      // localStorage.setItem("mono-font", toggleMono.checked);
    });
  }
  
  /* ===============================
     Módulo 3: Parallax con mouse
  =============================== */
  function initParallax() {
    document.addEventListener("mousemove", (e) => {
      const moveX = (e.clientX / window.innerWidth - 0.5) * 10;
      const moveY = (e.clientY / window.innerHeight - 0.5) * 10;
      document.documentElement.style.setProperty("--parallaxX", `${moveX}px`);
      document.documentElement.style.setProperty("--parallaxY", `${moveY}px`);
    });
  }
  
  /* ===============================
     Módulo 4: Fade-in Global 
     (para .fade-in)
  =============================== */
  function initFadeInGlobal() {
    setTimeout(() => {
      document.querySelectorAll(".fade-in").forEach(el => {
        el.classList.add("show");
      });
    }, 500);
  }
  
  /* ===============================
     Módulo 5: Intersection Observer
     (Scroll Reveal)
  =============================== */
  function initScrollReveal() {
    const revealEls = document.querySelectorAll(".scroll-reveal");
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("in-view");
        }
      });
    }, { threshold: 0.15 });
  
    revealEls.forEach(el => {
      observer.observe(el);
    });
  }
  
  /* ===============================
     Módulo 6: Canvas Animado
  =============================== */
  function initCanvasAnimation() {
    const canvas = document.getElementById("bgCanvas");
    const ctx = canvas.getContext("2d");
    let w, h;
    let time = 0;
  
    // Parámetros 
    const numBlocks = 6;       
    const baseGray = 60;       
    const grayStep = 10;       
    const minAlpha = 0.02;     
    const alphaStep = 0.03;    
    const baseOffsetStep = 20; 
    const waveAmplitude = 10;  
    const waveSpeed = 0.01;    
  
    function resizeCanvas() {
      w = window.innerWidth;
      h = window.innerHeight;
      canvas.width = w;
      canvas.height = h;
    }
  
    // Evitar triggers múltiples en resize
    let resizeRAF;
    window.addEventListener("resize", () => {
      if (resizeRAF) cancelAnimationFrame(resizeRAF);
      resizeRAF = requestAnimationFrame(resizeCanvas);
    });
  
    resizeCanvas();
  
    function drawBlocks() {
      ctx.clearRect(0, 0, w, h);
      const blockHeight = h / numBlocks;
  
      for (let i = 0; i < numBlocks; i++) {
        const gray = baseGray + i * grayStep;
        const alpha = minAlpha + i * alphaStep;
        const baseOffsetX = i * baseOffsetStep;
        const wave = waveAmplitude * Math.sin(time + i);
        const offsetX = baseOffsetX + wave;
        const offsetWidth = w - offsetX;
  
        ctx.fillStyle = `rgba(${gray}, ${gray}, ${gray}, ${alpha})`;
        ctx.fillRect(offsetX, i * blockHeight, offsetWidth, blockHeight);
      }
    }
  
    function animate() {
      requestAnimationFrame(animate);
      time += waveSpeed;
      drawBlocks();
    }
  
    animate();
  }
  