<?php
require_once 'admin_header.php';

$message = '';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        $stmt = $pdo->prepare("UPDATE general_info SET item_value = ? WHERE item_key = ?");
        $stmt->execute([$value, $key]);
    }

    // Handle resume upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $target_dir = "../assets/uploads/";
        $target_file = $target_dir . basename($_FILES["resume"]["name"]);
        
        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
            $resume_path = "assets/uploads/" . basename($_FILES["resume"]["name"]);
            $stmt = $pdo->prepare("UPDATE general_info SET item_value = ? WHERE item_key = 'resume_link'");
            $stmt->execute([$resume_path]);
        }
    }
    $message = "Information updated successfully!";
}

// Fetch current info
$stmt = $pdo->query("SELECT item_key, item_value FROM general_info");
$info = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<h1>Edit General Information</h1>
<p>Update your name, tagline, social links, and about me section.</p>

<?php if ($message): ?>
    <p class="success-msg"><?php echo $message; ?></p>
<?php endif; ?>

<div class="form-container">
    <form action="edit_general.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($info['name']); ?>">
        </div>
        <div class="form-group">
            <label for="tagline">Tagline</label>
            <input type="text" name="tagline" id="tagline" value="<?php echo htmlspecialchars($info['tagline']); ?>">
        </div>
        <div class="form-group">
            <label for="about_me">About Me</label>
            <textarea name="about_me" id="about_me"><?php echo htmlspecialchars($info['about_me']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($info['email']); ?>">
        </div>
        <div class="form-group">
            <label for="linkedin_link">LinkedIn URL</label>
            <input type="url" name="linkedin_link" id="linkedin_link" value="<?php echo htmlspecialchars($info['linkedin_link']); ?>">
        </div>
        <div class="form-group">
            <label for="github_link">GitHub URL</label>
            <input type="url" name="github_link" id="github_link" value="<?php echo htmlspecialchars($info['github_link']); ?>">
        </div>
         <div class="form-group">
            <label for="resume">Upload New Resume (Optional)</label>
            <p>Current: <a href="../<?php echo htmlspecialchars($info['resume_link']); ?>" target="_blank">View Resume</a></p>
            <input type="file" name="resume" id="resume">
        </div>
        <input type="submit" value="Save Changes" class="btn">
    </form>
</div>

<?php require_once 'admin_footer.php'; ?>