<?php
session_start();

// Check if user is not authenticated, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require 'db_connection.php';

$data_found = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve employee code from the form
    $emp_code = $_POST['emp_code'];

    if (!empty($emp_code)) {
        // Query to fetch data for the entered employee code
        $sql = "SELECT * FROM emp_details WHERE emp_code = '$emp_code'";
        $result = $conn->query($sql);
        
        // Fetch the result set into an associative array
        $row = [];
        if ($result->num_rows > 0) { 
            $row = $result->fetch_all(MYSQLI_ASSOC); 
        } else {
            $data_found = false;
        }
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Code Scanner / Employee Details</title>
  <link rel="stylesheet" href="../css/style_qr.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .navbar {
      background-color: #ADD8E6;
      width: 100%;
    }


    .container {
      padding: 20px;
      max-width: 1200px;
      margin: auto;
    }

    h1 {
      font-size: 1.5em;
      text-align: center;
    }

    .section {
      margin-bottom: 20px;
    }

    #my-qr-reader, #qr-display {
      padding: 80px;
      width: 100%;
      max-width: 400px;
      margin-bottom: 10px;
    }

    .employee-details {
      background: #f9f9f9;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 1.2em;
      }

      .section {
        margin-bottom: 15px;
      }

      #my-qr-reader, #qr-display {
        width: 100%;
        padding: 80px;
      }

      .employee-details {
        padding: 8px;
      }
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">
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
            <a class="nav-link active" aria-current="page" href="">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="crud.php">CRUD</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Log Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container" style="margin-top:100px">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1>Scan QR Codes</h1>
        <div class="section align-items-center">
          <div id="my-qr-reader" style="padding: 100px"></div>
          <!-- <div id="qr-display"></div> -->
        </div>
      </div>

      <div class="col-md-6">
        <h1>Employee Details</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <input type="hidden" name="emp_code">
          <input type="hidden" value="Get Details">
        </form>

        <?php if (isset($row) && !empty($row)) { ?>
          <div class="employee-details">
            <?php foreach ($row as $rows) { ?>
              <div class="card mb-4 shadow-sm">
                <div class="card-body">
                  <h5 class="card-title"><strong>Employee Code: </strong><?php echo $rows['emp_code']; ?></h5>
                  <p class="card-text"><strong>Name: </strong><?php echo $rows['name']; ?></p>
                  <p class="card-text"><strong>Designation: </strong><?php echo $rows['designation']; ?></p>
                  <p class="card-text"><strong>DOJ: </strong><?php echo $rows['doj']; ?></p>
                  <p class="card-text"><strong>Contact No: </strong><?php echo $rows['contact_no']; ?></p>
                  <p class="card-text"><strong>Mail ID: </strong><?php echo $rows['mail_id']; ?></p>
                  <p class="card-text"><strong>Agency Name: </strong><?php echo $rows['agency_name']; ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } elseif (!$data_found && !empty($_POST['emp_code'])) { ?>
          <div class="alert alert-warning" role="alert">
            Data Not Found
          </div>
        <?php } ?>
      </div>
    </div>
  </div>


  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="../js/script_qr.js"></script>
</body>

<object data="../svg/background.svg" type="image/svg+xml" style="margin-top: -650px;">
  Your browser does not support SVG
</object>
</html>

<?php 
mysqli_close($conn); 
?>