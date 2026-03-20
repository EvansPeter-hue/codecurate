<?php // includes/footer.php ?>

<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <a href="<?= $rootPath ?? '' ?>index.php" class="logo" style="font-size:1.1rem;margin-bottom:12px;display:flex">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="width:18px;height:18px;margin-right:8px">
          <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
        </svg>Learn<span>Code</span>
      </a>
      <p>The community-powered learning platform. Helping developers master modern technology through high-quality curated content.</p>
      <div class="social-icons">
        <div class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></div>
        <div class="social-icon" title="GitHub"><i class="fab fa-github"></i></div>
        <div class="social-icon" title="RSS"><i class="fas fa-rss"></i></div>
        <div class="social-icon" title="Discord"><i class="fab fa-discord"></i></div>
      </div>
    </div>
    <div class="footer-col">
      <h5>Platform</h5>
      <ul>
        <li><a href="#index">Learning Paths</a></li>
        <li><a href="#curated">Curated Lists</a></li>
        <li><a href="#projects">Community Projects</a></li>
        <li><a href="#pricing">Pricing</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h5>Company</h5>
      <ul>
        <li><a href="#About">About Us</a></li>
        <li><a href="#Contact">Contact</a></li>
        <li><a href="#Privacy">Privacy Policy</a></li>
        <li><a href="#Terms">Terms of Service</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© <?= date('Y') ?> LearnCode. All rights reserved.</span>
    <div class="status-dot">All systems operational</div>
    <span>Language: English (US)</span>
  </div>
</footer>

<script>
/* ── Search Overlay ───────────────────────── */
const overlay = document.getElementById('searchOverlay');
function openSearch()  { overlay.showModal ? overlay.showModal() : overlay.setAttribute('open',''); setTimeout(()=>document.getElementById('searchInput').focus(),50); }
function closeSearch() { overlay.close ? overlay.close() : overlay.removeAttribute('open'); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSearch(); if ((e.metaKey||e.ctrlKey) && e.key==='k') { e.preventDefault(); openSearch(); } });
document.getElementById('searchOverlay')?.addEventListener('click', e => { if (e.target === overlay) closeSearch(); });

function handleSearch(q) {
  const items = document.querySelectorAll('.search-result-item');
  items.forEach(item => {
    item.style.display = item.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
  });
}

/* ── Toast ────────────────────────────────── */
let toastTimer;
function showToast(msg) {
  const t = document.getElementById('toast');
  document.getElementById('toastMsg').textContent = msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
}
</script>
</body>
</html>
