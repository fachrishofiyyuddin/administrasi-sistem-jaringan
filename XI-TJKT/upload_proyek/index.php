<?php
$upload_dir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_siswa = htmlspecialchars($_POST["nama"]);
    $file = $_FILES["file_project"];

    if ($file["error"] == 0) {
        $file_ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        if ($file_ext == "zip") {
            $filename = "webprofil_" . strtolower(str_replace(" ", "_", $nama_siswa)) . ".zip";
            $destination = $upload_dir . $filename;

            if (move_uploaded_file($file["tmp_name"], $destination)) {
                $message = "✅ File berhasil diupload!";
            } else {
                $message = "❌ Gagal mengupload file.";
            }
        } else {
            $message = "❌ Hanya file .zip yang diizinkan.";
        }
    } else {
        $message = "❌ Error saat mengupload file.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload Proyek Web Profil</title>
    <style>
        body {
            font-family: Arial;
            margin: 30px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        input,
        label {
            display: block;
            width: 100%;
            margin-top: 10px;
        }

        .msg {
            margin-top: 20px;
            font-weight: bold;
        }

        ul {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Upload Proyek Web Profil (ZIP)</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Siswa:</label>
            <input type="text" name="nama" required>

            <label>File ZIP:</label>
            <input type="file" name="file_project" accept=".zip" required>

            <button type="submit">Upload</button>
        </form>

        <?php if (isset($message)) echo "<p class='msg'>$message</p>"; ?>

        <h3>Daftar File yang Sudah Di-upload:</h3>
        <ul>
            <?php
            if (is_dir($upload_dir)) {
                foreach (scandir($upload_dir) as $file) {
                    if ($file !== "." && $file !== "..") {
                        echo "<li><a href='$upload_dir$file' target='_blank'>$file</a></li>";
                    }
                }
            }
            ?>
        </ul>
    </div>
</body>

</html>