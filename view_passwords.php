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
    <title>Generated Passwords</title>
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
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 900px;
            overflow: hidden;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #ffeb3b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: center;
            font-size: 16px;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        th {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
        }
        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }
        tr:hover {
            background: rgba(255, 255, 255, 0.2);
            transition: background 0.3s ease;
        }
        td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        td:first-child {
            text-align: left;
        }
        a {
            color: #ffeb3b;
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-link {
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
                padding: 10px;
            }
            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
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
                        <td title="<?php echo htmlspecialchars($password['password']); ?>"><?php echo htmlspecialchars($password['password']); ?></td>
                        <td><?php echo htmlspecialchars($password['strength']); ?></td>
                        <td><?php echo htmlspecialchars($password['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="back-link">
            <a href="index.php">Back to Generator</a> | 
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
