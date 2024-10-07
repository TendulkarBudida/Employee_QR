<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success = "";

// Handle Create
if (isset($_POST['create'])) {
    $emp_code = $_POST['emp_code'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $doj = $_POST['doj'];
    $contact_no = $_POST['contact_no'];
    $mail_id = $_POST['mail_id'];
    $agency_name = $_POST['agency_name'];

    $sql = "INSERT INTO emp_details (emp_code, name, designation, doj, contact_no, mail_id, agency_name)
            VALUES ('$emp_code', '$name', '$designation', '$doj', '$contact_no', '$mail_id', '$agency_name')";
    
    if ($conn->query($sql) === TRUE) {
        $success = "New record created successfully";
    } else {
        $errors[] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Update
if (isset($_POST['update'])) {
    $emp_code = $_POST['emp_code'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $doj = $_POST['doj'];
    $contact_no = $_POST['contact_no'];
    $mail_id = $_POST['mail_id'];
    $agency_name = $_POST['agency_name'];

    $sql = "UPDATE emp_details SET name='$name', designation='$designation', doj='$doj', contact_no='$contact_no', mail_id='$mail_id', agency_name='$agency_name' WHERE emp_code='$emp_code'";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Record updated successfully";
    } else {
        $errors[] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    $emp_code = $_POST['emp_code'];

    $sql = "DELETE FROM emp_details WHERE emp_code='$emp_code'";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Record deleted successfully";
    } else {
        $errors[] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Search
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM emp_details";
if ($search) {
    $sql .= " WHERE emp_code LIKE '%$search%' OR name LIKE '%$search%' OR designation LIKE '%$search%' OR contact_no LIKE '%$search%' OR mail_id LIKE '%$search%' OR agency_name LIKE '%$search%'";
}
$result = $conn->query($sql);
$total_employees = $result->num_rows;

// // Fetch all records
// $sql = "SELECT * FROM emp_details";
// $result = $conn->query($sql);
// $total_employees = $result->num_rows;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CRUD Operations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style_crud.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../images/download.jpeg" width="50px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="qr.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="">CRUD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>

    <div class="container" style="margin-top:100px">
        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error) { echo $error . "<br>"; } ?>
            </div>
        <?php } ?>

        <?php if (!empty($success)) { ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php } ?>

        <h2>Employee Details</h2>
        <form method="get" action="" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search employees" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <div class="scrollable-table">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employee Code</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Date of Joining</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Agency Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['emp_code']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['designation']; ?></td>
                        <td><?php echo $row['doj']; ?></td>
                        <td><?php echo $row['contact_no']; ?></td>
                        <td><?php echo $row['mail_id']; ?></td>
                        <td><?php echo $row['agency_name']; ?></td>
                        <td style="width: 170px;"> <!-- Adjust width as needed -->
                            <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#updateEmployeeForm" aria-expanded="false" aria-controls="updateEmployeeForm" onclick="fillUpdateForm('<?php echo $row['emp_code']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['designation']; ?>', '<?php echo $row['doj']; ?>', '<?php echo $row['contact_no']; ?>', '<?php echo $row['mail_id']; ?>', '<?php echo $row['agency_name']; ?>'); collapseCreateForm();">Update</button>
                            <!-- <div style="margin-top: 5px;"> -->
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="emp_code" value="<?php echo $row['emp_code']; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                </form>
                            <!-- </div> -->
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <button class="btn btn-primary my-3" type="button" data-bs-toggle="collapse" data-bs-target="#createEmployeeForm" aria-expanded="false" aria-controls="createEmployeeForm" onclick="collapseUpdateForm()">
            Create New Employee
        </button>
        <div class="collapse mb-3" id="createEmployeeForm">
            <div class="card card-body">
                <h2>Create New Employee</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="emp_code" class="form-label">Employee Code</label>
                        <input type="text" class="form-control" id="emp_code" name="emp_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" required>
                    </div>
                    <div class="mb-3">
                        <label for="doj" class="form-label">Date of Joining</label>
                        <input type="date" class="form-control" id="doj" name="doj" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_no" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                    </div>
                    <div class="mb-3">
                        <label for="mail_id" class="form-label">Email</label>
                        <input type="email" class="form-control" id="mail_id" name="mail_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="agency_name" class="form-label">Agency Name</label>
                        <input type="text" class="form-control" id="agency_name" name="agency_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create">Create</button>
                </form>
            </div>
        </div>

        <div class="collapse mb-3" id="updateEmployeeForm">
            <div class="card card-body">
                <h2>Update Employee</h2>
                <form method="post" id="updateForm">
                    <div class="mb-3">
                        <label for="update_emp_code" class="form-label">Employee Code</label>
                        <input type="text" class="form-control" id="update_emp_code" name="emp_code" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="update_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="update_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="update_designation" name="designation" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_doj" class="form-label">Date of Joining</label>
                        <input type="date" class="form-control" id="update_doj" name="doj" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_contact_no" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="update_contact_no" name="contact_no" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_mail_id" class="form-label">Email</label>
                        <input type="email" class="form-control" id="update_mail_id" name="mail_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_agency_name" class="form-label">Agency Name</label>
                        <input type="text" class="form-control" id="update_agency_name" name="agency_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function fillUpdateForm(emp_code, name, designation, doj, contact_no, mail_id, agency_name) {
            document.getElementById('update_emp_code').value = emp_code;
            document.getElementById('update_name').value = name;
            document.getElementById('update_designation').value = designation;
            document.getElementById('update_doj').value = doj;
            document.getElementById('update_contact_no').value = contact_no;
            document.getElementById('update_mail_id').value = mail_id;
            document.getElementById('update_agency_name').value = agency_name;
        }

        function collapseCreateForm() {
            var createForm = new bootstrap.Collapse(document.getElementById('createEmployeeForm'), {
                toggle: false
            });
            createForm.hide();
        }

        function collapseUpdateForm() {
            var updateForm = new bootstrap.Collapse(document.getElementById('updateEmployeeForm'), {
                toggle: false
            });
            updateForm.hide();
        }
    </script>
</body>
</html>

<?php 
$conn->close(); 
?>
