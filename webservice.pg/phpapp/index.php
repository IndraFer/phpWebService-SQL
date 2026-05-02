<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MariaDB Connection Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .status-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>MariaDB Connection Test</h1>
        <?php
        $servername = "mariadb";  // Gunakan nama service Docker MariaDB
        $username = "root";
        $password = "root_password";
        $database = "mysql";

        // Membuat koneksi
        $conn = new mysqli($servername, $username, $password, $database);

        // Cek koneksi
        if ($conn->connect_error) {
            echo '<div class="status-message error">Connection failed: ' . $conn->connect_error . '</div>';
        } else {
            echo '<div class="status-message success">Connected successfully to MariaDB database!</div>';
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
