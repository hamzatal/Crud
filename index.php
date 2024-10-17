<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
    try {
        $student_id = $_POST['delete_student'];
        $sql = "DELETE FROM students WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        echo "<div class='alert alert-success'>Record deleted successfully.</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error deleting record: " . $e->getMessage() . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-2">
    <h2 class="text-center mb-6">Student List</h2>
    <a href='add.php' class='btn btn-outline-success mb-3' style='padding-inline: 70px;'>Add Student</a>
    <?php
    try {
        $sql = "SELECT id, firstname, lastname, email FROM students";
        $stmt = $conn->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            echo "<table class='table table-bordered table-striped'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['firstname']) . "</td>
                        <td>" . htmlspecialchars($row['lastname']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>
                            <!-- Delete form -->
                            <form method='POST' action='' style='display:inline-block;'>
                                <button type='submit' name='delete_student' value='" . htmlspecialchars($row['id']) . "' class='btn btn-outline-danger'>Delete</button>
                            </form>
                            <!-- Update button -->
                            <a href='update.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-outline-warning'>Update</a>
                        </td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info'>No records found.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error fetching data: " . $e->getMessage() . "</div>";
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
