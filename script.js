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
 */
function initLoadingScreen() {
  const loadingScreen = document.querySelector(".loading-screen");
  const loadingBar = document.querySelector(".loading-bar");
  if (!loadingScreen || !loadingBar) return;

  let progress = 0;
  const interval = setInterval(() => {
    progress += 2;
    if (progress >= 100) {
      clearInterval(interval);
      setTimeout(() => {
        loadingScreen.classList.add("hide");
        setTimeout(() => {
          loadingScreen.remove();
        }, 600);
      }, 300);
    }
    loadingBar.style.width = `${progress}%`;
  }, 30);
}

/**
 * 2) Navigation + Section Animations
 */
function initSections() {
  const sections = document.querySelectorAll("main section");
  const links = document.querySelectorAll(".nav-list li a");

  // Show HOME section by default
  showSection("home");

  // Event listeners for navigation links
  links.forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const sectionId = link.getAttribute("data-section");
      showSection(sectionId);
      updateActiveLink(link);
    });
  });

  // Activate the first link by default
  if (links.length > 0) {
    links[0].classList.add("active");
  }

  // Function to show sections with smooth transition
  function showSection(sectionId) {
    sections.forEach(sec => {
      if (sec.id === sectionId) {
        sec.style.display = "flex"; // Use flex to ensure proper alignment
        setTimeout(() => {
          sec.scrollTop = 0;
          sec.classList.add("active");
          animateSectionItems(sectionId);
        }, 50);
      } else {
        sec.classList.remove("active");
        setTimeout(() => {
          if (!sec.classList.contains("active")) {
            sec.style.display = "none";
          }
        }, 500);
      }
    });

    // Update URL hash without reloading the page
    history.pushState(null, null, `#${sectionId}`);
  }

  // Function to animate items within the active section
  function animateSectionItems(sectionId) {
    const items = document.querySelectorAll(`#${sectionId} .section-item`);
    items.forEach((item, index) => {
      item.classList.remove("show");
      setTimeout(() => {
        item.classList.add("show");
      }, 100 + 80 * index);
    });
  }

  // Function to update the active link in navigation
  function updateActiveLink(activeLink) {
    links.forEach(link => link.classList.remove("active"));
    activeLink.classList.add("active");
  }

  // Observer to reveal elements on scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("in-view");
        if (entry.target.classList.contains("section-item")) {
          entry.target.classList.add("show");
        }
      }
    });
  }, {
    threshold: 0.15,
    rootMargin: "0px 0px -10% 0px"
  });

  // Observe all elements with the class scroll-reveal
  document.querySelectorAll(".scroll-reveal").forEach(el => {
    observer.observe(el);
  });

  // Check if there is a hash in the URL on load
  window.addEventListener("load", () => {
    const hash = window.location.hash.substring(1);
    if (hash) {
      const navLink = document.querySelector(`[data-section="${hash}"]`);
      if (navLink) navLink.click();
    }
  });

  // Ensure scrolls work correctly within each section
  sections.forEach(section => {
    section.addEventListener('scroll', () => {
      const revealElements = section.querySelectorAll('.scroll-reveal:not(.in-view)');
      revealElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        const sectionRect = section.getBoundingClientRect();
        if (rect.top < sectionRect.bottom - 100) {
          el.classList.add('in-view');
          if (el.classList.contains("section-item")) {
            el.classList.add("show");
          }
        }
      });
    });
  });
}

/**
 * 3) DARK/LIGHT TOGGLE
 *    If checked => dark => label "LIGHT"
 *    If unchecked => light => label "DARK"
 */
function initThemePanel() {
  const toggleDark = document.getElementById("toggle-dark");
  const modeLabel = document.getElementById("mode-label");

  function updateMode() {
    if (toggleDark.checked) {
      document.body.classList.remove("light-mode");
      document.body.classList.add("dark-mode");
      modeLabel.textContent = "LIGHT";
    } else {
      document.body.classList.remove("dark-mode");
      document.body.classList.add("light-mode");
      modeLabel.textContent = "DARK";
    }
  }

  toggleDark.addEventListener("change", updateMode);
  updateMode();
}

/**
 * 4) PARALLAX
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
 */
function initCanvasAnimation() {
  const canvas = document.getElementById("bgCanvas");
  const ctx = canvas.getContext("2d");
  let w, h;
  let time = 0;

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
