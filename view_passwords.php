<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$stmt = $pdo->query("SELECT password, strength, created_at FROM passwords ORDER BY created_at DESC");
$passwords = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Passwords</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .password-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #fff;
            text-align: left;
        }
        th {
            background: #6a11cb;
        }
        a {
            color: #ffeb3b;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="password-container">
        <h1>Generated Passwords</h1>
        <table>
            <thead>
                <tr>
                    <th>Password</th>
                    <th>Strength</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($passwords as $password): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($password['password']); ?></td>
                        <td><?php echo htmlspecialchars($password['strength']); ?></td>
                        <td><?php echo htmlspecialchars($password['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
