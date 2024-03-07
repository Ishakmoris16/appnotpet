<?php include "menu.php"; ?>

<?php
// Include config file
require_once "konfig.php";

// Define variables and initialize with empty values
$judul =  $catatan = $kategori = "";
$judul_err =  $catatan_err = $kategori_err = "";

// Processing form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Judul Buku
    $input_judul = trim($_POST["judul"]);
    if (empty($input_judul)) {
        $judul_err = "Masukkan Judul Buku.";
    } else {
        $judul= $input_judul;
    }

    // Validate Pengarang
    $input_catatan = trim($_POST["catatan"]);
    if (empty($input_catatan)) {
        $catatan_err = "Masukkan Nama Pengarang.";
    } else {
        $catatan = $input_catatan;
    }

    // Validate Tahun Terbit
    $input_kategori = trim($_POST["kategori"]);
    if (empty($input_kategori)) {
        $kategori_err = "Masukkan Tahun Terbit.";
    } else {
        $kategori = $input_kategori;
    }

    // Check input errors before inserting into the database
    if (empty($judul_err) && empty( $catatan_err) && empty($kategori_err)) {
        // Prepare an insert statement
        // Prepare an insert statement
         $sql = "INSERT INTO appnotes (judul, catatan, kategori) VALUES (?, ?, ?)";


        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_judul, $param_catatan, $param_kategori);

            // Set parameters
            $param_judul = $judul;
            $param_catatan =  $catatan;
            $param_kategori = $kategori;

            // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to the landing page
                header("location: tampil.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    }// Close statement
mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($koneksi);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Notes</title>
    <link rel="stylesheet" type="text/css" href="style.php">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom CSS styling can be added here */
        body{
            background-color: DarkSlateGray;
        }
        .container{
            background-color: rgba(40, 37, 37, 0.8);
            color:grey;
            outline: thick ridge black;
            padding:50px;
            border-radius:50px;
        }
        h2{
            text-align: center;
            text-transform: uppercase;
            color:grey;
        }
        label{
            text-align: center;
            text-transform: uppercase;  
        }
    </style>
</head>
<body>

<br><br>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <?php
                    // Display the success message if set
                    if (!empty($message)) {
                        echo '<div class="alert alert-success">' . $message . '</div>';
                    }
                    ?>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h2 class="text-center">Aplikasi Notes</h2>
                    <hr>
                    <div class="mb-3 <?php echo (!empty($judul_err)) ? 'has-error' : ''; ?>">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" value="<?php echo $judul; ?>">
                        <span class="help-block"><?php echo $judul_err; ?></span>
                    </div>
                    <div class="mb-3 <?php echo (!empty($catatan_err)) ? 'has-error' : ''; ?>">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" placeholder="Masukkan catatan" class="form-control"><?php echo $catatan; ?></textarea>
                        <span class="help-block"><?php echo $catatan_err; ?></span>
                    </div>
                    <div class="mb-3 <?php echo (!empty($kategori_err)) ? 'has-error' : ''; ?>">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Masukkan kategori" value="<?php echo $kategori; ?>">
                        <span class="help-block"><?php echo $kategori_err; ?></span>
                    </div>
                    <button type="submit" class="btn btn-success" name="action" value="add">Add</button>
                    <button type="submit" class="btn btn-primary"  name="action" value="save">Save</button>
                    <a href="tampil.php" class="btn btn-secondary">View</a>
                    <button type="reset" class="btn btn-danger">Clear</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>

