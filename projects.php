<?php
// --- Fetch all projects from the database ---
require_once 'includes/db.php';
$projects_stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
$projects = $projects_stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Fetch general info for the page title ---
$general_info_stmt = $pdo->query("SELECT item_key, item_value FROM general_info WHERE item_key = 'name'");
$info = $general_info_stmt->fetch(PDO::FETCH_KEY_PAIR);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Projects | <?php echo htmlspecialchars($info['name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="project-gallery-body">

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="project-page-container">
        <header class="project-page-header">
            <h1>My Work</h1>
            <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </header>

        <div class="all-projects-grid">
            <?php foreach ($projects as $project): ?>
            <div class="grid-project-card">
                <div class="grid-card-image">
                    <img src="assets/uploads/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                </div>
                <div class="grid-card-content">
                    <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                    <small>Technologies: <?php echo htmlspecialchars($project['technologies']); ?></small>
                    <div class="grid-card-links">
                        <?php if (!empty($project['github_link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['github_link']); ?>" target="_blank" class="card-btn">GitHub</a>
                        <?php endif; ?>
                        <?php if (!empty($project['live_link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['live_link']); ?>" target="_blank" class="card-btn">Live Demo</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cursorDot = document.querySelector('.cursor-dot');
            const cursorOutline = document.querySelector('.cursor-outline');
            window.addEventListener('mousemove', (e) => {
                cursorDot.style.left = `${e.clientX}px`;
                cursorDot.style.top = `${e.clientY}px`;
                cursorOutline.animate({
                    left: `${e.clientX}px`,
                    top: `${e.clientY}px`
                }, { duration: 500, fill: "forwards" });
            });
        });
    </script>
</body>
</html>