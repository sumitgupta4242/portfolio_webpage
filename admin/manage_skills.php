<?php
require_once 'admin_header.php';

// Handle Add Skill
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_skill'])) {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    if (!empty($name) && !empty($category)) {
        $stmt = $pdo->prepare("INSERT INTO skills (name, category) VALUES (?, ?)");
        $stmt->execute([$name, $category]);
    }
}

// Handle Delete Skill
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_skills.php"); // Redirect to avoid re-deleting on refresh
    exit;
}

// Fetch all skills
$skills = $pdo->query("SELECT * FROM skills ORDER BY category, name")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Manage Skills</h1>
<p>Add or remove skills from your portfolio.</p>

<table>
    <thead>
        <tr>
            <th>Skill Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($skills as $skill): ?>
        <tr>
            <td><?php echo htmlspecialchars($skill['name']); ?></td>
            <td><?php echo htmlspecialchars($skill['category']); ?></td>
            <td>
                <a href="manage_skills.php?delete=<?php echo $skill['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this skill?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="form-container">
    <h2>Add New Skill</h2>
    <form action="manage_skills.php" method="post">
        <div class="form-group">
            <label for="name">Skill Name</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" id="category" required placeholder="e.g., Programming, Tools & Frameworks">
        </div>
        <input type="submit" name="add_skill" value="Add Skill" class="btn">
    </form>
</div>

<?php require_once 'admin_footer.php'; ?>