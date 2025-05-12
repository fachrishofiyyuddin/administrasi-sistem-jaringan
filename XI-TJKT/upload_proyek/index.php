<?php
$upload_dir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_siswa = htmlspecialchars($_POST["nama"]);
    $file = $_FILES["file_project"];

    if ($file["error"] == 0) {
        $file_ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        if ($file_ext == "zip") {
            $filename = "webprofil_" . strtolower(str_replace(" ", "_", $nama_siswa)) . "_" . basename($file["name"]);
            $destination = $upload_dir . $filename;

            // Cek apakah file berhasil dipindahkan ke folder uploads
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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Proyek Web Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input,
        label {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .msg {
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
            color: #333;
        }

        ul {
            margin-top: 20px;
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 10px 0;
            text-align: center;
        }

        ul li a {
            text-decoration: none;
            color: #007BFF;
        }

        ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Upload Proyek Web Profil (ZIP)</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Siswa:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="file_project">File ZIP:</label>
            <input type="file" id="file_project" name="file_project" accept=".zip" required>

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