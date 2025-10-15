<?php
// --- Fetch all data from the database ---
require_once 'includes/db.php';

// General Info
$general_info_stmt = $pdo->query("SELECT item_key, item_value FROM general_info");
$info = $general_info_stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Skills
$skills_stmt = $pdo->query("SELECT category, GROUP_CONCAT(name ORDER BY id SEPARATOR ', ') as names FROM skills GROUP BY category");
$skills = $skills_stmt->fetchAll(PDO::FETCH_ASSOC);

// Projects
$projects_stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
$projects = $projects_stmt->fetchAll(PDO::FETCH_ASSOC);

// Experience
$experience_stmt = $pdo->query("SELECT * FROM experience ORDER BY id DESC");
// --- THIS IS THE CORRECTED LINE ---
$experiences = $experience_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($info['name']); ?> | Creative Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div id="background-layers">
        <div class="background-layer" id="bg-hero" data-theme="orbs"></div>
        <div class="background-layer" id="bg-skills" data-theme="aurora"></div>
        <div class="background-layer" id="bg-projects" data-theme="warp"></div>
        <div class="background-layer" id="bg-experience" data-theme="aurora"></div>
    </div>

    <div id="scroll-progress"></div>
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <main id="scroll-container">

        <header class="hero fullscreen-section" data-bg="bg-hero" data-accent="#7B2BFC">
            <div class="hero-content-column">
                <div class="hero-text-content">
                    <h1 class="anim-fade-in"><?php echo htmlspecialchars($info['name']); ?></h1>
                    <p class="anim-fade-in anim-delay-1"><?php echo htmlspecialchars($info['tagline']); ?></p>
                    <div class="hero-about anim-fade-in anim-delay-2">
                        <p><?php echo nl2br(htmlspecialchars($info['about_me'])); ?></p>
                    </div>
                    <div class="hero-links anim-fade-in anim-delay-3">
                        <a href="<?php echo htmlspecialchars($info['resume_link']); ?>" class="btn" download>Download Resume</a>
                        <div class="social-links">
                            <a href="<?php echo htmlspecialchars($info['linkedin_link']); ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                            <a href="<?php echo htmlspecialchars($info['github_link']); ?>" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="mailto:<?php echo htmlspecialchars($info['email']); ?>"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-image-column">
                </div>
        </header>

        <section id="skills" class="container fullscreen-section" data-bg="bg-skills" data-accent="#00ffc3">
            <h2>My Skillset</h2>
            <div class="skills-grid">
                <?php foreach ($skills as $skill_group): ?>
                <div class="skill-category">
                    <h3><?php echo htmlspecialchars($skill_group['category']); ?></h3>
                    <p><?php echo htmlspecialchars($skill_group['names']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="projects" class="container fullscreen-section" data-bg="bg-projects" data-accent="#ffb347">
            <a href="projects.php"><h2>My Projects</h2></a>
            
            <div class="marquee">
                <div class="marquee-content">
                    <?php foreach (array_merge($projects, $projects) as $project): ?>
                    <a href="projects.php" class="project-card-link">
                        <div class="project-card">
                            <div class="card-image">
                                 <img src="assets/uploads/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                            </div>
                            <div class="card-glass-pane"></div>
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                                <div class="card-details">
                                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                                    <small>Tech: <?php echo htmlspecialchars($project['technologies']); ?></small>
                                    <div class="project-links-visual">View Project <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="experience" class="container fullscreen-section" data-bg="bg-experience" data-accent="#fb6f92">
             <h2>Experience & Achievements</h2>
             <div class="experience-list">
                <?php foreach ($experiences as $exp): ?>
                <div class="experience-item">
                    <h3><?php echo htmlspecialchars($exp['title']); ?></h3>
                    <p><?php echo htmlspecialchars($exp['description']); ?></p>
                </div>
                <?php endforeach; ?>
             </div>
        </section>

        <footer class="site-footer fullscreen-section">
            <div class="footer-content">
                <h2>Get In Touch</h2>
                <p>Feel free to reach out. I'm always open to discussing new projects or creative ideas.</p>
                <a href="mailto:<?php echo htmlspecialchars($info['email']); ?>" class="btn"><?php echo htmlspecialchars($info['email']); ?></a>
            </div>
        </footer>

    </main>

    <script src="assets/js/main.js"></script>
</body>
</html>