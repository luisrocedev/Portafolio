/**
 * Portfolio Dinámico - JavaScript
 * Inspirado en zunedaalim.com
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Loading Screen
  initLoadingScreen();

  // 2. Navbar Scroll Effect
  initNavbar();

  // 3. Theme Toggle
  initThemeToggle();

  // 4. Scroll Animations
  initScrollAnimations();

  // 5. Smooth Scroll
  initSmoothScroll();

  // 6. Background Canvas Animation
  initCanvasAnimation();
});

/**
 * 1. Loading Screen con barra de progreso
 */
function initLoadingScreen() {
  const loadingScreen = document.querySelector('.loading-screen');
  const loadingBar = document.querySelector('.loading-bar');
  
  if (!loadingScreen || !loadingBar) return;

  let progress = 0;
  const interval = setInterval(() => {
    progress += 3;
    loadingBar.style.width = `${progress}%`;
    
    if (progress >= 100) {
      clearInterval(interval);
      setTimeout(() => {
        loadingScreen.classList.add('hide');
        setTimeout(() => {
          loadingScreen.remove();
        }, 500);
      }, 300);
    }
  }, 30);
}

/**
 * 2. Navbar scroll effect
 */
function initNavbar() {
  const navbar = document.querySelector('.navbar');
  
  if (!navbar) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
}

/**
 * 3. Theme Toggle (Dark/Light Mode)
 */
function initThemeToggle() {
  const themeToggle = document.getElementById('theme-toggle');
  const body = document.body;
  
  if (!themeToggle) return;

  // Cargar tema guardado
  const savedTheme = localStorage.getItem('theme') || 'dark';
  if (savedTheme === 'light') {
    body.classList.add('light-mode');
    themeToggle.innerHTML = '<span>🌙</span>';
  }

  themeToggle.addEventListener('click', () => {
    body.classList.toggle('light-mode');
    
    if (body.classList.contains('light-mode')) {
      themeToggle.innerHTML = '<span>🌙</span>';
      localStorage.setItem('theme', 'light');
    } else {
      themeToggle.innerHTML = '<span>☀</span>';
      localStorage.setItem('theme', 'dark');
    }
  });
}

/**
 * 4. Scroll Animations (Fade Up)
 */
function initScrollAnimations() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, observerOptions);

  // Observar todos los elementos con clase 'fade-up'
  document.querySelectorAll('.fade-up').forEach(el => {
    observer.observe(el);
  });
}

/**
 * 5. Smooth Scroll para links de navegación
 */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      
      if (target) {
        const offsetTop = target.offsetTop - 80; // 80px para el navbar
        
        window.scrollTo({
          top: offsetTop,
          behavior: 'smooth'
        });
      }
    });
  });
}

/**
 * 6. Background Canvas Animation
 */
function initCanvasAnimation() {
  const canvas = document.getElementById('bgCanvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let particles = [];
  let animationId;

  // Configurar canvas
  function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }

  resizeCanvas();
  window.addEventListener('resize', resizeCanvas);

  // Clase Particle
  class Particle {
    constructor() {
      this.x = Math.random() * canvas.width;
      this.y = Math.random() * canvas.height;
      this.size = Math.random() * 2 + 1;
      this.speedX = Math.random() * 0.5 - 0.25;
      this.speedY = Math.random() * 0.5 - 0.25;
      this.opacity = Math.random() * 0.5 + 0.2;
    }

    update() {
      this.x += this.speedX;
      this.y += this.speedY;

      // Wrap around edges
      if (this.x > canvas.width) this.x = 0;
      if (this.x < 0) this.x = canvas.width;
      if (this.y > canvas.height) this.y = 0;
      if (this.y < 0) this.y = canvas.height;
    }

    draw() {
      ctx.fillStyle = `rgba(255, 255, 255, ${this.opacity})`;
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  // Crear partículas
  function createParticles() {
    particles = [];
    const particleCount = Math.floor((canvas.width * canvas.height) / 15000);
    
    for (let i = 0; i < particleCount; i++) {
      particles.push(new Particle());
    }
  }

  createParticles();

  // Animar
  function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    particles.forEach(particle => {
      particle.update();
      particle.draw();
    });

    // Conectar partículas cercanas
    connectParticles();

    animationId = requestAnimationFrame(animate);
  }

  // Conectar partículas cercanas con líneas
  function connectParticles() {
    const maxDistance = 100;
    
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < maxDistance) {
          const opacity = (1 - distance / maxDistance) * 0.2;
          ctx.strokeStyle = `rgba(255, 255, 255, ${opacity})`;
          ctx.lineWidth = 0.5;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
        }
      }
    }
  }

  // Iniciar animación
  animate();

  // Recrear partículas al redimensionar
  window.addEventListener('resize', () => {
    cancelAnimationFrame(animationId);
    createParticles();
    animate();
  });
}

/**
 * Utilidades adicionales
 */

// Parallax effect en hero
document.addEventListener('mousemove', (e) => {
  const hero = document.querySelector('.hero');
  if (!hero) return;

  const mouseX = e.clientX / window.innerWidth;
  const mouseY = e.clientY / window.innerHeight;
  
  const moveX = (mouseX - 0.5) * 20;
  const moveY = (mouseY - 0.5) * 20;

  hero.style.transform = `translate(${moveX}px, ${moveY}px)`;
});

// Active nav link al hacer scroll
window.addEventListener('scroll', () => {
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-menu a');
  
  let current = '';
  
  sections.forEach(section => {
    const sectionTop = section.offsetTop;
    const sectionHeight = section.clientHeight;
    
    if (window.scrollY >= sectionTop - 200) {
      current = section.getAttribute('id');
    }
  });

  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === `#${current}`) {
      link.classList.add('active');
    }
  });
});

// Scroll to top cuando se recarga la página
window.addEventListener('beforeunload', () => {
  window.scrollTo(0, 0);
});

console.log('%c✨ Portfolio desarrollado con PHP + MySQL', 'color: #00ff88; font-size: 16px; font-weight: bold;');
console.log('%c🚀 ¿Buscas a alguien para tu proyecto?', 'color: #00d4ff; font-size: 14px;');
