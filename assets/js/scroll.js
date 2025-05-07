// scroll.js
window.addEventListener('DOMContentLoaded', () => {
    const els = document.querySelectorAll('.animate-up, .animate-down, .animate-left, .animate-right');
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.style.animationPlayState = 'running';
          obs.unobserve(e.target);
        }
      });
    }, { threshold: 0.2 });
  
    els.forEach(el => {
      el.style.animationPlayState = 'paused';
      obs.observe(el);
    });
  });