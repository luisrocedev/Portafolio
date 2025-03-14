document.addEventListener("DOMContentLoaded", () => {
    // 1. Loading Screen
    initLoadingScreen();
  
    // 2. Sections + staggered animations
    initSections();
  
    // 3. Dark/Light toggle (default: dark)
    initThemePanel();
  
    // 4. Parallax effect
    initParallax();
  
    // 5. Fade-in global
    initFadeInGlobal();
  
    // 6. Scroll reveal
    initScrollReveal();
  
    // 7. Animated canvas background
    initCanvasAnimation();
  });
  
  /**
   * 1) Loading Screen with progress bar
   *    increments from 0 to 100%, then hides.
   */
  function initLoadingScreen() {
    const loadingScreen = document.querySelector(".loading-screen");
    const loadingBar = document.querySelector(".loading-bar");
    if (!loadingScreen || !loadingBar) return;
  
    let progress = 0;
    const interval = setInterval(() => {
      progress += 2; // increment 2% each step
      if (progress >= 100) {
        progress = 100;
        clearInterval(interval);
  
        // fade out after short delay
        setTimeout(() => {
          loadingScreen.classList.add("hide");
          setTimeout(() => {
            loadingScreen.remove();
          }, 600);
        }, 300);
      }
      // update bar width
      loadingBar.style.width = progress + "%";
    }, 30);
  }
  
  /**
   * 2) Navigation + Section Animations
   *    show chosen section, animate .section-item
   */
  function initSections() {
    const sections = document.querySelectorAll("main section");
    const links = document.querySelectorAll(".nav-list li a");
  
    // default to HOME
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
  
  /**
   * 3) DARK/LIGHT TOGGLE
   *    If checkbox is checked => dark mode => label text => "LIGHT"
   *    If unchecked => light mode => label text => "DARK"
   */
  function initThemePanel() {
    const toggleDark = document.getElementById("toggle-dark");
    const modeLabel = document.getElementById("mode-label");
  
    function updateMode() {
      if (toggleDark.checked) {
        // dark
        document.body.classList.remove("light-mode");
        document.body.classList.add("dark-mode");
        modeLabel.textContent = "LIGHT";
      } else {
        // light
        document.body.classList.remove("dark-mode");
        document.body.classList.add("light-mode");
        modeLabel.textContent = "DARK";
      }
    }
  
    toggleDark.addEventListener("change", updateMode);
    // set initial mode
    updateMode();
  }
  
  /**
   * 4) PARALLAX
   *    moves radial gradient + noise based on mouse
   */
  function initParallax() {
    document.addEventListener("mousemove", (e) => {
      const moveX = (e.clientX / window.innerWidth - 0.5) * 10;
      const moveY = (e.clientY / window.innerHeight - 0.5) * 10;
      document.documentElement.style.setProperty("--parallaxX", `${moveX}px`);
      document.documentElement.style.setProperty("--parallaxY", `${moveY}px`);
    });
  }
  
  /**
   * 5) FADE-IN GLOBAL
   *    .fade-in appear after 500ms
   */
  function initFadeInGlobal() {
    setTimeout(() => {
      document.querySelectorAll(".fade-in").forEach(el => {
        el.classList.add("show");
      });
    }, 500);
  }
  
  /**
   * 6) SCROLL REVEAL
   *    IntersectionObserver reveals .scroll-reveal
   */
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
  
  /**
   * 7) ANIMATED CANVAS
   *    wave-like vertical blocks
   */
  function initCanvasAnimation() {
    const canvas = document.getElementById("bgCanvas");
    const ctx = canvas.getContext("2d");
    let w, h;
    let time = 0;
  
    // wave parameters
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
        const offsetBase = i * baseOffsetStep;
        const wave = waveAmplitude * Math.sin(time + i);
  
        const offsetX = offsetBase + wave;
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
  