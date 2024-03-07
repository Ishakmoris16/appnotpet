<?php include "menu.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buku Tamu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body><br>
<?php
                        $nama = $nama_err = $email = $email_err = $subjek = $subjek_err = $pesan = $pesan_err = "";
                        require_once "konfig.php";
                        $message = "";
                        
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_POST["action"])) {
                                $action = $_POST["action"];
                                
                                if ($action == "submit") {
                                    $nama = $_POST["nama"];
                                    $email = $_POST["email"];
                                    $subjek = $_POST["subjek"];
                                    $pesan = $_POST["pesan"];
                                    
                                    $sql = "INSERT INTO tabel_tamu ( nama, email, subjek, pesan) VALUES ('$nama', '$email', '$subjek', '$pesan')";
                                    
                                    if ($koneksi->query($sql) === TRUE) {
                                        $message = "Note added successfully";
                                    } else {
                                        $message = "Error: " . $sql . "<br>" . $conn->error;
                                    }
                                } 
                                }
                            }
                    ?>
  <div class="container mt-3">
    <h1>ISI BUKU TAMU</h1>
    <hr>
    <p>Silakan isi formulir di bawah ini untuk memberikan keterangan lebih lanjut.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <hr>
                        <?php if (!empty($message)) : ?>
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        <?php endif; ?>
                        <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                           <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo $nama; ?>"required>
                            <span class="help-block"><?php echo $nama_err; ?></span>
                        </div><br>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                           <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>"required>
                            <span class="help-block"><?php echo $email_err; ?></span>
                        </div><br>
                        <div class="form-group <?php echo (!empty($subjek_err)) ? 'has-error' : ''; ?>">
                           <input type="text" name="subjek" class="form-control" placeholder="Subject" value="<?php echo $subjek; ?>"required>
                            <span class="help-block"><?php echo $subjek_err; ?></span>
                        </div><br>
                        <div class="form-group <?php echo (!empty($pesan_err)) ? 'has-error' : ''; ?>">
                           <input type="text" name="pesan" class="form-control" placeholder="Pesan" value="<?php echo $pesan; ?>"required>
                            <span class="help-block"><?php echo $pesan_err; ?></span>
                        </div><br>
    
                        <button type="submit" class="btn btn-outline-primary btn-lg btn-rounded" name="action" value="sub"> Submit</button><br><br>
    </form>
  </div>

  <?php
// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $subjek = isset($_POST["subjek"]) ? $_POST["subjek"] : "";
    $pesan = isset($_POST["pesan"]) ? $_POST["pesan"] : "";

    // Perform any necessary validation or processing with the form data

    // Attempt to insert data into the database
    $insertSql = "INSERT INTO tabel_tamu ( nama, email, subjek, pesan) VALUES ('$nama', '$email', '$subjek', '$pesan')";
    if(mysqli_query($koneksi, $insertSql)){
        echo "<div class='alert alert-success' role='alert'>Records added successfully.</div>";
    } else{
        echo "<div class='alert alert-danger' role='alert'>ERROR: Could not able to execute $insertSql. " . mysqli_error($koneksi) . "</div>";
    }
}
?>
        <div class="col-md-8 mx-auto ">
            <!-- Display table -->
            <?php
            $sql = "SELECT id, nama, email, subjek, pesan FROM tabel_tamu";
            if ($result = mysqli_query($koneksi, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-responsive table-bordered table-hover mb-5'>";
                    echo "<thead class='thead-dark'>";
                    echo "<tr>";
                    echo "<th>no</th>";
                    echo "<th>Nama</th>";
                    echo "<th>Email</th>";
                    echo "<th>Subjek</th>";
                    echo "<th>Pesan</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['subjek'] . "</td>";
                        echo "<td>" . $row['pesan'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";

                    // Free result set
                    mysqli_free_result($result);
                } else {
                    echo "<p class='lead'><em>No records were found.</em></p>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>ERROR: Could not able to execute $sql. " . mysqli_error($koneksi) . "</div>";
            }

            // Close connection
            mysqli_close($koneksi);
            ?>
        </div>
    </div>
</div>
<br><br>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>