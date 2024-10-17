<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    try {
        $student_id = $_POST['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        $sql = "UPDATE students SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "<div class='alert alert-success'>Record updated successfully.</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error updating record: " . $e->getMessage() . "</div>";
    }
}
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $sql = "SELECT firstname, lastname, email FROM students WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "<div class='alert alert-danger'>No student ID provided.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-2">
    <h2 class="text-center mb-6">Update Student</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student_id); ?>">
        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($student['firstname']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($student['lastname']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
        </div>
        <button type="submit" name="update_student" class="btn btn-success">Update Student</button>
        <a href="index.php" class="btn btn-outline-info">Back to List</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
