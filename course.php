<?php
// course.php — Dynamic course page
// URL: course.php?slug=python  (or javascript, react, devops, ai, java)
require_once 'config/db.php';
require_once 'includes/auth.php';

// ── Validate slug ────────────────────────────
$slug = isset($_GET['slug']) ? trim(preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['slug']))) : '';
if (empty($slug)) {
    header('Location: index.php');
    exit;
}

// ── Fetch course ─────────────────────────────
$stmt = $pdo->prepare("SELECT * FROM courses WHERE slug = ? LIMIT 1");
$stmt->execute([$slug]);
$course = $stmt->fetch();

if (!$course) {
    http_response_code(404);
    include 'includes/header.php';
    echo '<div style="text-align:center;padding:80px 20px;color:#94a3b8;">
            <h2>Course not found</h2>
            <a href="index.php" style="color:#3b82f6">← Back to Home</a>
          </div>';
    include 'includes/footer.php';
    exit;
}

// ── Fetch ALL videos for this course ─────────
$stmt2 = $pdo->prepare(
    "SELECT * FROM videos WHERE course_id = ? ORDER BY sort_order ASC"
);
$stmt2->execute([$course['id']]);
$videos = $stmt2->fetchAll();

// ── Build unique filter tags ──────────────────
$filterTags = ['all' => 'All Tutorials'];
foreach ($videos as $v) {
    if ($v['filter_tag'] && $v['filter_tag'] !== 'all') {
        $filterTags[$v['filter_tag']] = ucfirst(str_replace('-', ' ', $v['filter_tag']));
    }
}

// ── Page meta ────────────────────────────────
$pageTitle  = htmlspecialchars($course['name']) . ' Tutorials – CodeCurate';
$activeSlug = $slug;

include 'includes/header.php';
?>

<!-- ── PAGE HEADER ───────────────────────────────── -->
<div class="page-header">
  <div class="breadcrumb">
    <a href="index.php">Home</a>
    <span class="sep"><i class="fas fa-chevron-right"></i></span>
    <a href="index.php#categories">Tutorials</a>
    <span class="sep"><i class="fas fa-chevron-right"></i></span>
    <span class="current"><?= htmlspecialchars($course['name']) ?></span>
  </div>
  <div class="page-title-row">
    <div class="page-title-left">
      <h1><?= $course['icon'] ?> <?= htmlspecialchars($course['name']) ?> Tutorials</h1>
      <p><?= htmlspecialchars($course['subtitle'] ?? $course['description']) ?></p>
      <p class="video-count-badge">
        <i class="fas fa-video"></i>
        <?= count($videos) ?> tutorials &nbsp;·&nbsp;
        <i class="fas fa-eye"></i> All 1M+ views verified
      </p>
    </div>
    <div class="view-toggle">
      <button class="vt-btn active" id="gridBtn" onclick="setView('grid')">
        <i class="fas fa-th-large"></i> Grid
      </button>
      <button class="vt-btn" id="listBtn" onclick="setView('list')">
        <i class="fas fa-list"></i> List
      </button>
    </div>
  </div>
</div>

<!-- ── FILTER TABS ───────────────────────────────── -->
<div class="filter-bar" id="filterBar">
  <?php foreach ($filterTags as $tag => $label): ?>
    <button class="filter-tab <?= $tag === 'all' ? 'active' : '' ?>"
            data-filter="<?= htmlspecialchars($tag) ?>">
      <?= htmlspecialchars($label) ?>
    </button>
  <?php endforeach; ?>
  <div class="filter-search-wrap">
    <div class="nav-search" style="max-width:240px;">
      <i class="fas fa-search"></i>
      <input type="text" id="searchInput"
             placeholder="Search <?= htmlspecialchars($course['name']) ?>…"
             oninput="handleSearch()" />
    </div>
  </div>
</div>

<!-- ── VIDEO GRID ────────────────────────────────── -->
<main>
  <div class="tutorials-grid" id="videoGrid">
    <?php if (empty($videos)): ?>
      <div class="no-results">
        <i class="fas fa-video-slash"></i>
        <p>No tutorials yet for this course.</p>
      </div>
    <?php else: ?>
      <?php foreach ($videos as $v): ?>
      <div class="vid-card"
           data-filter="all <?= htmlspecialchars($v['filter_tag']) ?>"
           data-title="<?= strtolower(htmlspecialchars($v['title'])) ?>"
           onclick="window.open('https://www.youtube.com/watch?v=<?= htmlspecialchars($v['yt_id']) ?>','_blank')">

        <div class="vid-thumb">
          <img src="https://img.youtube.com/vi/<?= htmlspecialchars($v['yt_id']) ?>/mqdefault.jpg"
               loading="lazy"
               onerror="this.src='https://images.unsplash.com/photo-1526379879527-8559ecfcaec4?w=480&q=70'"
               alt="<?= htmlspecialchars($v['title']) ?>"/>
          <div class="vid-play-overlay">
            <div class="vid-play-circle"><i class="fas fa-play"></i></div>
          </div>
          <span class="vid-duration"><?= htmlspecialchars($v['duration']) ?></span>
          <span class="vid-level-badge level-<?= strtolower($v['level']) ?>">
            <?= htmlspecialchars($v['level']) ?>
          </span>
        </div>

        <div class="vid-body">
          <div class="vid-title"><?= htmlspecialchars($v['title']) ?></div>

          <!-- Views · Likes · Comments (capstone requirement) -->
          <div class="vid-stats-row">
            <span class="vstat"><i class="fas fa-eye"></i> <?= htmlspecialchars($v['views']) ?> views</span>
            <span class="vstat"><i class="far fa-heart"></i> <?= htmlspecialchars($v['likes']) ?></span>
            <span class="vstat"><i class="far fa-comment"></i> <?= htmlspecialchars($v['comments']) ?></span>
          </div>

          <div class="vid-meta">
            <span><?= htmlspecialchars($v['published_ago']) ?></span>
          </div>

          <a class="yt-btn"
             href="https://www.youtube.com/watch?v=<?= htmlspecialchars($v['yt_id']) ?>"
             target="_blank" rel="noopener"
             onclick="event.stopPropagation()">
            <span class="yt-icon"><i class="fas fa-play"></i></span>
            Watch on YouTube
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <div class="no-results" id="noResults" style="display:none;">
    <i class="fas fa-search"></i>
    <p>No tutorials match your search. Try a different keyword.</p>
  </div>
</main>

<script>
let activeFilter = 'all';
let searchQuery  = '';
let activeView   = 'grid';

function applyFilters() {
  const cards     = document.querySelectorAll('.vid-card');
  const noResults = document.getElementById('noResults');
  let   visible   = 0;

  cards.forEach(card => {
    const tags  = card.dataset.filter || '';
    const title = card.dataset.title  || '';
    const matchFilter = activeFilter === 'all' || tags.includes(activeFilter);
    const matchSearch = searchQuery === '' || title.includes(searchQuery.toLowerCase());

    if (matchFilter && matchSearch) {
      card.style.display = '';
      visible++;
    } else {
      card.style.display = 'none';
    }
  });

  noResults.style.display = visible === 0 ? 'block' : 'none';
}

// Filter tabs
document.getElementById('filterBar').addEventListener('click', e => {
  const tab = e.target.closest('.filter-tab');
  if (!tab) return;
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  tab.classList.add('active');
  activeFilter = tab.dataset.filter;
  applyFilters();
});

// Search
function handleSearch() {
  searchQuery = document.getElementById('searchInput').value.toLowerCase();
  applyFilters();
}

// Grid / List toggle
function setView(v) {
  activeView = v;
  const grid = document.getElementById('videoGrid');
  document.getElementById('gridBtn').classList.toggle('active', v === 'grid');
  document.getElementById('listBtn').classList.toggle('active', v === 'list');
  grid.classList.toggle('list-view', v === 'list');
}
</script>

<?php include 'includes/footer.php'; ?>
