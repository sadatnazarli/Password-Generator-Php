<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Password Generator</title>
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
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 14px;
            text-align: left;
        }

        input[type="number"],
        button {
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="number"] {
            background: rgba(255, 255, 255, 0.8);
        }

        button {
            background: #6a11cb;
            color: white;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            transition: background 0.3s;
        }

        button:hover {
            background: #2575fc;
        }

        .password-output {
            margin-top: 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
        }

        .password-output .password {
            font-size: 24px;
            font-weight: bold;
            color: #ffeb3b;
            word-wrap: break-word;
        }

        .strength-bar {
            margin-top: 15px;
            height: 12px;
            width: 100%;
            background-color: #ddd;
            border-radius: 10px;
            overflow: hidden;
        }

        .strength-level {
            height: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Generator</h1>
        <form method="POST" action="">
            <label for="length">Password Length:</label>
            <input type="number" name="length" id="length" min="4" max="64" value="12" required>
            <label><input type="checkbox" name="include_lowercase" checked>Include Lowercase Letters</label>
            <label><input type="checkbox" name="include_uppercase" checked>Include Uppercase Letters</label>
            <label><input type="checkbox" name="include_numbers" checked>Include Numbers</label>
            <label><input type="checkbox" name="include_symbols">Include Symbols</label>
            <button type="submit">Generate Password</button>
        </form>

        <?php
        include 'db.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $length = isset($_POST['length']) ? (int)$_POST['length'] : 12;
            $include_lowercase = isset($_POST['include_lowercase']);
            $include_uppercase = isset($_POST['include_uppercase']);
            $include_numbers = isset($_POST['include_numbers']);
            $include_symbols = isset($_POST['include_symbols']);

            $lowercase = 'abcdefghijklmnopqrstuvwxyz';
            $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numbers = '0123456789';
            $symbols = '!@#$%^&*()-_=+[]{}|;:",.<>?/';

            $characters = '';
            if ($include_lowercase) $characters .= $lowercase;
            if ($include_uppercase) $characters .= $uppercase;
            if ($include_numbers) $characters .= $numbers;
            if ($include_symbols) $characters .= $symbols;

            if (empty($characters)) {
                echo "<div class='password-output'>Error: Please select at least one character type.</div>";
                exit;
            }

            $password = '';
            $charactersLength = strlen($characters);
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[random_int(0, $charactersLength - 1)];
            }

            function assessStrength($password) {
                $strength = 0;
                if (preg_match('/[a-z]/', $password)) $strength++;
                if (preg_match('/[A-Z]/', $password)) $strength++;
                if (preg_match('/[0-9]/', $password)) $strength++;
                if (preg_match('/[\W]/', $password)) $strength++;
                if (strlen($password) >= 12) $strength++;
                switch ($strength) {
                    case 5: return ['Very Strong', 'green', '100%'];
                    case 4: return ['Strong', '#6a11cb', '80%'];
                    case 3: return ['Medium', 'orange', '60%'];
                    case 2: return ['Weak', 'red', '40%'];
                    default: return ['Very Weak', 'darkred', '20%'];
                }
            }

            [$strengthLabel, $color, $width] = assessStrength($password);

            $stmt = $pdo->prepare("INSERT INTO passwords (password, strength) VALUES (:password, :strength)");
            $stmt->execute(['password' => $password, 'strength' => $strengthLabel]);

            $file = fopen('passwords.txt', 'a');
            fwrite($file, "$password - $strengthLabel (" . date('Y-m-d H:i:s') . ")\n");
            fclose($file);

            echo "<div class='password-output'>
                    <p>Your Generated Password: <span class='password'>$password</span></p>
                    <p>Password Strength: <strong>$strengthLabel</strong></p>
                    <div class='strength-bar'>
                        <div class='strength-level' style='width: $width; background-color: $color;'></div>
                    </div>
                  </div>";
        }

        echo "<div class='password-output'>";
        echo "<h3>Previously Generated Passwords:</h3>";

        $stmt = $pdo->query("SELECT password, strength, created_at FROM passwords ORDER BY created_at DESC LIMIT 10");
        $passwords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($passwords) {
            echo "<ul>";
            foreach ($passwords as $entry) {
                echo "<li><strong>{$entry['password']}</strong> - {$entry['strength']} ({$entry['created_at']})</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No passwords generated yet.</p>";
        }

        echo "</div>";
        ?>
    </div>
</body>
</html>
