(() => {
  const root = document.documentElement;
  const savedTheme = localStorage.getItem('hms-theme');
  if (savedTheme) root.setAttribute('data-theme', savedTheme);

  const toggle = document.getElementById('themeToggle');
  const syncIcon = () => {
    if (!toggle) return;
    const dark = root.getAttribute('data-theme') === 'dark';
    toggle.innerHTML = dark ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
  };
  syncIcon();
  toggle?.addEventListener('click', () => {
    const dark = root.getAttribute('data-theme') === 'dark';
    const next = dark ? 'light' : 'dark';
    root.setAttribute('data-theme', next);
    localStorage.setItem('hms-theme', next);
    syncIcon();
  });

  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebarBackdrop');
  document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    sidebar?.classList.add('open'); backdrop?.classList.add('show');
  });
  backdrop?.addEventListener('click', () => {
    sidebar?.classList.remove('open'); backdrop?.classList.remove('show');
  });
})();
