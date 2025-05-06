<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if the user is not logged in
    exit();
}

$conn = new mysqli("localhost", "root", "", "course_registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM courses"; // Fetch all courses from the courses table
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
</head>
<body>
    <h1>Available Courses</h1>
    <table>
        <tr>
            <th>Course Name</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['course_name']; ?></td>
                <td>
                    <!-- Button to select course -->
                    <form action="store_course.php" method="POST">
                        <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                        <input type="submit" value="Select Course">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
