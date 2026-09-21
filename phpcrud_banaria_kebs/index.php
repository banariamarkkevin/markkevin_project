<?php
include 'database.php';

$query = "SELECT id, firstname, lastname FROM students";
$result = $conn->query($query);
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

    <button
        type="button"
        class="btn btn-primary mb-3"
        data-bs-toggle="modal"
        data-bs-target="#addModal">
        Add Student
    </button>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php while ($row = $result->fetch_assoc()) { ?>

            <tr>

                <td>
                    <?php echo htmlspecialchars($row['firstname']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['lastname']); ?>
                </td>

                <td>

                    <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal<?php echo $row['id']; ?>">
                        Edit
                    </button>

                    <a
                        href="delete.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this student?');">
                        Delete
                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<div
    class="modal fade"
    id="addModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="insert.php" method="post">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Add Student
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            First Name
                        </label>

                        <input
                            type="text"
                            name="firstname"
                            class="form-control"
                            required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="lastname"
                            class="form-control"
                            required>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Close
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Add Student
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<?php

$result2 = $conn->query($query);

while ($row = $result2->fetch_assoc()) {

?>

<div
    class="modal fade"
    id="editModal<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="update.php" method="post">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Student
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <!-- ID -->
                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo $row['id']; ?>">


                    <!-- FIRST NAME -->
                    <div class="mb-3">

                        <label class="form-label">
                            First Name
                        </label>

                        <input
                            type="text"
                            name="firstname"
                            class="form-control"
                            value="<?php echo htmlspecialchars($row['firstname']); ?>"
                            required>

                    </div>


                    <!-- LAST NAME -->
                    <div class="mb-3">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="lastname"
                            class="form-control"
                            value="<?php echo htmlspecialchars($row['lastname']); ?>"
                            required>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Close
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        SAVE CHANGES
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php } ?>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>