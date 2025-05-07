// assets/js/script.js
document.addEventListener("DOMContentLoaded", function() {
  // —— DARK MODE TOGGLER ——
  const THEME_KEY = 'gqc-theme';
  const toggle = document.getElementById('dark-mode-toggle');
  if (toggle) {
    if (localStorage.getItem(THEME_KEY) === 'dark') {
      document.body.classList.add('dark');
    }
    toggle.addEventListener('click', () => {
      const isDark = document.body.classList.toggle('dark');
      localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
    });
  }

  // —— LIVE JOIN COUNTER (+7 every 30s, persisted) ——
  const el = document.getElementById("join-count");
  if (el) {
    const COUNT_KEY = 'gqc-join-count';
    // Load previous count or start at 0
    let count = parseInt(localStorage.getItem(COUNT_KEY), 10);
    if (isNaN(count)) count = 0;
    // Initialize display
    el.textContent = count;

    // Every 30 seconds, add 7, update display & persist
    setInterval(() => {
      count += 7;
      el.textContent = count;
      localStorage.setItem(COUNT_KEY, count);
    }, 30 * 1000);
  }
});
