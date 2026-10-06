<section class="timeline">
  <h2>Mes Projets</h2>

  <div class="timeline-item jouer">
    <div class="timeline-marker">🎮</div>
    <div class="timeline-content">
      <h3>RenewEarth</h3>
      <p>City-builder environnemental basé sur MonoGame.</p>
      <span class="date">2025</span>
    </div>
  </div>

  <div class="timeline-item creer">
    <div class="timeline-marker">🛠️</div>
    <div class="timeline-content">
      <h3>DinaFramework</h3>
      <p>Framework C# simplifiant la création de jeux.</p>
      <span class="date">2024</span>
    </div>
  </div>

  <div class="timeline-item explorer">
    <div class="timeline-marker">🌌</div>
    <div class="timeline-content">
      <h3>ProcGen Worlds</h3>
      <p>Recherche sur la génération procédurale 2D réaliste.</p>
      <span class="date">2023</span>
    </div>
  </div>
</section>

<style>
.timeline {
  border-left: 3px solid #333;
  margin: 2rem 0;
  padding-left: 2rem;
}
.timeline-item {
  margin-bottom: 2rem;
  position: relative;
}
.timeline-marker {
  position: absolute;
  left: -2.3rem;
  background: #fff;
  border: 2px solid #333;
  border-radius: 50%;
  padding: 0.3rem 0.5rem;
  font-size: 1.2rem;
}
.timeline-content h3 {
  margin: 0;
  font-size: 1.2rem;
}
.timeline-content .date {
  font-size: 0.8rem;
  color: #888;
}
.jouer .timeline-marker { border-color: #4CAF50; }
.creer .timeline-marker { border-color: #2196F3; }
.explorer .timeline-marker { border-color: #9C27B0; }
</style>
<section class="atelier">
  <h2>Mes Projets</h2>

  <article class="section">
    <h3>🎮 Jouer</h3>
    <p class="intro">Ici je façonne des mondes où l’on peut s’évader et vivre des aventures.</p>
    <ul>
      <li><strong>RenewEarth</strong> — Construis une ville durable, entre écologie et stratégie.</li>
      <li><strong>RPG de la Tour</strong> — Gravir 100 étages et survivre aux défis.</li>
      <li><strong>Idle Game</strong> — L’art de la patience, version textuelle.</li>
    </ul>
  </article>

  <article class="section">
    <h3>🛠️ Créer</h3>
    <p class="intro">Dans mon atelier, je forge des outils pour accélérer la création.</p>
    <ul>
      <li><strong>DinaFramework</strong> — Mon framework C# personnel.</li>
      <li><strong>ServiceLocator</strong> — Gestion souple et centralisée des services.</li>
      <li><strong>LevelManager</strong> — Intégration de cartes Tiled.</li>
    </ul>
  </article>

  <article class="section">
    <h3>🌌 Explorer</h3>
    <p class="intro">Voici mes terrains de recherche et mes expérimentations.</p>
    <ul>
      <li><strong>One Life</strong> — Une seule vie, des choix irréversibles.</li>
      <li><strong>ProcGen Worlds</strong> — Génération procédurale 2D réaliste.</li>
      <li><strong>Tutoriels</strong> — Partage de connaissances techniques.</li>
    </ul>
  </article>
</section>

<style>
.atelier {
  max-width: 800px;
  margin: auto;
  font-family: Georgia, serif;
  line-height: 1.6;
}
.atelier h3 {
  margin-top: 2rem;
  font-size: 1.4rem;
  border-bottom: 2px solid #ddd;
  padding-bottom: 0.3rem;
}
.atelier .intro {
  font-style: italic;
  color: #555;
}
.atelier ul {
  list-style-type: none;
  padding-left: 0;
}
.atelier li {
  margin-bottom: 0.6rem;
}
</style>
<?php
// Exemple de structure (tu peux la remplacer par ta base de données ou ton système actuel)
$quests = [
    [
        "title" => "RenewEarth",
        "description" => "Un city-builder environnemental où chaque décision influence l'avenir de la planète.",
        "status" => "En développement",
        "progress" => 45
    ],
    [
        "title" => "Idle Cats",
        "description" => "Un idle game textuel centré sur l’adoption et la gestion de chats mignons.",
        "status" => "Jouable",
        "progress" => 80
    ],
    [
        "title" => "RPG de la Tour",
        "description" => "Un RPG narratif où le héros vieillit réellement au fil du temps.",
        "status" => "Prototype",
        "progress" => 20
    ]
];
?>

<div class="quests-container">
    <?php foreach($quests as $quest): ?>
        <div class="quest-card">
            <h2 class="quest-title">⚔️ <?= htmlspecialchars($quest["title"]) ?></h2>
            <p class="quest-desc"><?= htmlspecialchars($quest["description"]) ?></p>
            <div class="quest-status">
                <span class="status-label"><?= htmlspecialchars($quest["status"]) ?></span>
            </div>
            <div class="quest-progress">
                <div class="progress-bar" style="width: <?= $quest["progress"] ?>%;"></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<style>
    .quests-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin: 30px auto;
    max-width: 1000px;
}

.quest-card {
    background: #1c1c1c;
    border: 2px solid #444;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    transition: transform 0.2s ease-in-out;
}
.quest-card:hover {
    transform: scale(1.03);
    border-color: #ffd700;
}

.quest-title {
    font-size: 1.4em;
    color: #ffd700;
    margin-bottom: 10px;
}

.quest-desc {
    font-size: 1em;
    color: #ddd;
    margin-bottom: 15px;
}

.quest-status {
    margin-bottom: 10px;
}
.status-label {
    background: #ffd700;
    color: #000;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: bold;
}

.quest-progress {
    background: #333;
    border-radius: 8px;
    height: 12px;
    overflow: hidden;
}
.progress-bar {
    background: linear-gradient(90deg, #ffd700, #ff8c00);
    height: 100%;
}

</style>