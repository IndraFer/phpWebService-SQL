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
            padding: 24px 32px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 480px;
        }

        h1 {
            color: #333;
            margin-top: 0;
        }

        .status-message {
            margin: 16px 0;
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

        .details {
            color: #888;
            font-size: 0.85em;
            margin: 8px 0 16px;
        }

        .actions a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .actions a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>MariaDB Connection Status</h1>
        <?php
        // Read credentials from the container environment (see env_file in docker-compose.yml),
        // with sensible fallbacks so the page still works without them.
        $host = getenv('MYSQL_HOST') ?: 'mariadb';
        $user = getenv('MYSQL_USER') ?: 'root';
        $pass = getenv('MYSQL_ROOT_PASSWORD') ?: 'root_password';
        $db   = getenv('MYSQL_DATABASE') ?: 'mysql';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<div class="status-message success">Connected successfully to MariaDB database!</div>';
            $conn = null;
        } catch (PDOException $e) {
            echo '<div class="status-message error">Connection failed: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
        <p class="details">Host: <?= htmlspecialchars($host) ?> &middot; Database: <?= htmlspecialchars($db) ?></p>
        <div class="actions">
            <a href="phpinfo.php" target="_blank" rel="noopener">Open PHP Info</a>
        </div>
    </div>
</body>
</html>
