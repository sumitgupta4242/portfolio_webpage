<?php
require_once 'admin_header.php';
$message = '';
$upload_dir = '../assets/uploads/';

// --- Handle Form Submissions (Add/Edit/Delete) ---

// Handle DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // First, get the image filename to delete the file
    $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();
    if ($project && file_exists($upload_dir . $project['image'])) {
        unlink($upload_dir . $project['image']); // Delete the image file
    }
    // Then, delete the database record
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_projects.php");
    exit;
}

// Handle ADD or EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $technologies = $_POST['technologies'];
    $github_link = $_POST['github_link'];
    $live_link = $_POST['live_link'];
    $id = $_POST['id'];
    $image_name = $_POST['current_image']; // Keep old image by default

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Generate a unique name for the file
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }
    
    if (empty($id)) { // ADD NEW PROJECT
        $sql = "INSERT INTO projects (title, description, technologies, github_link, live_link, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $technologies, $github_link, $live_link, $image_name]);
        $message = "Project added successfully!";
    } else { // UPDATE EXISTING PROJECT
        $sql = "UPDATE projects SET title=?, description=?, technologies=?, github_link=?, live_link=?, image=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $technologies, $github_link, $live_link, $image_name, $id]);
        $message = "Project updated successfully!";
    }
}

// --- Fetch Data for Display ---
$edit_project = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $edit_project = $stmt->fetch(PDO::FETCH_ASSOC);
}

$projects = $pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Manage Projects</h1>
<?php if ($message): ?><p class="success-msg"><?php echo $message; ?></p><?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Technologies</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $project): ?>
        <tr>
            <td><img src="<?php echo $upload_dir . htmlspecialchars($project['image']); ?>" alt="Project Image"></td>
            <td><?php echo htmlspecialchars($project['title']); ?></td>
            <td><?php echo htmlspecialchars($project['technologies']); ?></td>
            <td>
                <a href="manage_projects.php?edit=<?php echo $project['id']; ?>">Edit</a>
                <a href="manage_projects.php?delete=<?php echo $project['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure? This will delete the project and its image.');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="form-container">
    <h2><?php echo $edit_project ? 'Edit Project' : 'Add New Project'; ?></h2>
    <form action="manage_projects.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $edit_project['id'] ?? ''; ?>">
        <input type="hidden" name="current_image" value="<?php echo $edit_project['image'] ?? ''; ?>">

        <div class="form-group">
            <label for="title">Project Title</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($edit_project['title'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Short Description</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($edit_project['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="technologies">Technologies Used (comma separated)</label>
            <input type="text" name="technologies" id="technologies" value="<?php echo htmlspecialchars($edit_project['technologies'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="github_link">GitHub Link (Optional)</label>
            <input type="url" name="github_link" id="github_link" value="<?php echo htmlspecialchars($edit_project['github_link'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="live_link">Live Demo Link (Optional)</label>
            <input type="url" name="live_link" id="live_link" value="<?php echo htmlspecialchars($edit_project['live_link'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="image">Project Image</label>
            <?php if ($edit_project && $edit_project['image']): ?>
                <p>Current image: <img src="<?php echo $upload_dir . htmlspecialchars($edit_project['image']); ?>" alt="" style="max-width: 150px; display: block; margin-top: 10px;"></p>
                <p>Upload a new image to replace it:</p>
            <?php endif; ?>
            <input type="file" name="image" id="image" <?php echo $edit_project ? '' : 'required'; ?>>
        </div>
        <input type="submit" value="<?php echo $edit_project ? 'Update Project' : 'Add Project'; ?>" class="btn">
        <?php if ($edit_project): ?>
            <a href="manage_projects.php" style="margin-left: 10px;">Cancel Edit</a>
        <?php endif; ?>
    </form>
</div>

<?php require_once 'admin_footer.php'; ?>