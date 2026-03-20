<?php
// index.php — Homepage
require_once 'config/db.php';
require_once 'includes/auth.php';

$pageTitle  = 'CodeCurate – Master Programming with Curated Tutorials';
$activeSlug = 'home';

// Fetch courses for category tabs
$courses = $pdo->query("SELECT * FROM courses ORDER BY sort_order")->fetchAll();

// Fetch stats
$totalVideos  = $pdo->query("SELECT COUNT(*) FROM videos")->fetchColumn();
$totalCourses = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();

// Fetch trending tutorials (top 8 by views_raw)
$trendingVideos = $pdo->query(
    "SELECT v.*, c.name AS course_name, c.slug AS course_slug, c.lang_class
     FROM videos v
     JOIN courses c ON c.id = v.course_id
     ORDER BY v.views_raw DESC
     LIMIT 8"
)->fetchAll();

include 'includes/header.php';
?>

<!-- ── HERO ──────────────────────────────────── -->
<div class="hero-wrapper">
<section class="hero">
  <div class="hero-content">
    <div class="hero-badge">
      <span class="ping-wrap"><span class="ping-ring"></span><span class="ping-dot"></span></span>
      <?= $totalVideos ?>+ Online Tutorials Available
    </div>
    <h1>Master Coding with <span class="blue">Online</span> Tutorials</h1>
    <p>High-quality, community-vetted programming lessons for every skill level. From zero to senior engineer with hands-on projects.</p>
    <div class="hero-actions">
      <button class="btn-lg" onclick="document.getElementById('trending').scrollIntoView({behavior:'smooth'})">
        Start Learning Now <i class="fas fa-arrow-right"></i>
      </button>
    </div>
    <div class="hero-social">
      <div class="avatars">
        <div class="av"><img src="https://i.pravatar.cc/80?img=11" alt=""/></div>
        <div class="av"><img src="https://i.pravatar.cc/80?img=47" alt=""/></div>
        <div class="av"><img src="https://i.pravatar.cc/80?img=32" alt=""/></div>
        <div class="av-count">+12k</div>
      </div>
      <div class="hero-social-text">Join <strong>12,000+</strong> developers learning today</div>
    </div>
  </div>
  <div class="hero-visual-wrap">
    <div class="hero-glow"></div>
    <div class="hero-visual">
      <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=900&q=80" alt="Coding on laptop"/>
      <div class="hero-visual-overlay"></div>
    </div>
  </div>
</section>
</div>

<!-- ── STATS ─────────────────────────────────── -->
<div class="stats-strip">
  <div class="stat-card">
    <div class="stat-icon"><i class="fas fa-terminal"></i></div>
    <div><div class="stat-val"><?= $totalVideos ?></div><div class="stat-lbl">Tutorials</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon"><i class="fas fa-users"></i></div>
    <div><div class="stat-val">12k+</div><div class="stat-lbl">Learners</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon"><i class="fas fa-star"></i></div>
    <div><div class="stat-val">4.8</div><div class="stat-lbl">Avg. Rating</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
    <div><div class="stat-val"><?= $totalCourses ?></div><div class="stat-lbl">Categories</div></div>
  </div>
</div>

<!-- ── CATEGORIES ────────────────────────────── -->
<section class="categories-section" id="categories">
  <div class="section-header">
    <div class="section-title"><i class="fas fa-compass"></i> Explore Categories</div>
    <span class="view-all">View All <i class="fas fa-chevron-right view-all-chevron"></i></span>
  </div>
  <div class="cat-tabs">
    <button class="cat-tab active" data-cat="all"><i class="fas fa-code"></i> All Tech</button>
    <?php foreach ($courses as $course): ?>
      <a class="cat-tab" href="course.php?slug=<?= htmlspecialchars($course['slug']) ?>">
        <i class="<?= htmlspecialchars($course['fa_icon']) ?>"></i>
        <?= htmlspecialchars($course['name']) ?>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ── TRENDING ──────────────────────────────── -->
<section class="tutorials-section" id="trending">
  <div class="section-header">
    <div class="section-title"><i class="fas fa-chart-line"></i> Trending Tutorials</div>
    <div class="sort-bar">
      Sort by:
      <select class="sort-select" id="sortSelect" aria-label="Sort tutorials by" onchange="sortCards()">
        <option value="popular">Most Popular</option>
        <option value="recent">Most Recent</option>
      </select>
      <i class="fas fa-chevron-down sort-chevron"></i>
    </div>
  </div>

  <div class="cards-grid" id="cardsGrid">
    <?php foreach ($trendingVideos as $v): ?>
    <div class="tut-card"
         data-views="<?= $v['views_raw'] ?>"
         data-id="<?= $v['id'] ?>">
      <div class="card-thumb">
        <img src="https://img.youtube.com/vi/<?= htmlspecialchars($v['yt_id']) ?>/mqdefault.jpg"
             loading="lazy"
             onerror="this.src='https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=480&q=70'"
             alt="<?= htmlspecialchars($v['title']) ?>"/>
        <span class="duration-badge"><?= htmlspecialchars($v['duration']) ?></span>
        <span class="card-lang-badge <?= htmlspecialchars($v['lang_class']) ?>">
          <?= htmlspecialchars($v['course_name']) ?>
        </span>
        <div class="card-play-overlay">
          <div class="card-play-circle"><i class="fas fa-play"></i></div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-top-row">
          <span class="card-rating-inline"><i class="fas fa-star"></i> 4.9</span>
          <span class="card-level level-<?= strtolower($v['level']) ?>"><?= htmlspecialchars($v['level']) ?></span>
        </div>
        <div class="card-title"><?= htmlspecialchars($v['title']) ?></div>
        <div class="card-stats-row">
          <span class="cstat"><i class="fas fa-eye"></i> <?= htmlspecialchars($v['views']) ?> views</span>
          <span class="cstat"><i class="far fa-heart"></i> <?= htmlspecialchars($v['likes']) ?></span>
          <span class="cstat"><i class="far fa-comment"></i> <?= htmlspecialchars($v['comments']) ?></span>
        </div>
        <a class="btn-watch"
           href="https://www.youtube.com/watch?v=<?= htmlspecialchars($v['yt_id']) ?>"
           target="_blank" rel="noopener">
          <span class="yt-dot"><i class="fas fa-play"></i></span>
          Watch Now on YouTube
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="browse-wrap">
    <a class="btn-browse" href="#courses">
      <i class="fas fa-layer-group"></i> Browse More Tutorials
    </a>
  </div>
</section>

<script>
function sortCards() {
  const val   = document.getElementById('sortSelect').value;
  const grid  = document.getElementById('cardsGrid');
  const cards = [...grid.querySelectorAll('.tut-card')];
  cards.sort((a, b) => {
    if (val === 'popular') return Number(b.dataset.views) - Number(a.dataset.views);
    return Number(b.dataset.id)    - Number(a.dataset.id);
  });
  cards.forEach(c => grid.appendChild(c));
}
</script>

<?php include 'includes/footer.php'; ?>
