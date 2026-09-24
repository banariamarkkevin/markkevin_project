<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'database.php';

$query = "SELECT id, firstname, lastname, cource, year_level FROM students";
$result = $conn->query($query);

// Store rows in an array
$students = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Add Student
        </button>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search student by name, course, or year level...">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="studentTableBody">
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $row): ?>
                    <tr class="student-row">
                        <td class="first-name"><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td class="last-name"><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td class="cource"><?php echo htmlspecialchars($row['cource']); ?></td>
                        <td class="year-level"><?php echo htmlspecialchars($row['year_level']); ?></td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                            <!-- Delete Link -->
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr id="noDataRow">
                    <td colspan="5" class="text-center">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="insert.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="lastname" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Course</label>
            <input type="text" name="cource" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Year Level</label>
            <input type="text" name="year_level" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Student</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modals Loop -->
<?php if (!empty($students)): ?>
    <?php foreach ($students as $row): ?>
        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="update.php" method="POST">
                <div class="modal-body">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" value="<?php echo htmlspecialchars($row['firstname']); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($row['lastname']); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Course</label>
                    <input type="text" name="cource" class="form-control" value="<?php echo htmlspecialchars($row['cource']); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Year Level</label>
                    <input type="text" name="year_level" class="form-control" value="<?php echo htmlspecialchars($row['year_level']); ?>" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Search Filter Script -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('.student-row');

    rows.forEach(row => {
        const firstName = row.querySelector('.first-name').textContent.toLowerCase();
        const lastName = row.querySelector('.last-name').textContent.toLowerCase();
        const cource = row.querySelector('.cource').textContent.toLowerCase();
        const yearLevel = row.querySelector('.year-level').textContent.toLowerCase();
        
        if (firstName.includes(filter) || lastName.includes(filter) || cource.includes(filter) || yearLevel.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

</body>
</html>