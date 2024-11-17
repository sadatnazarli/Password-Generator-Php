<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Password Generator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        h1 { color: #333; text-align: center; }
        form { max-width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; }
        input[type="number"], button { width: 100%; padding: 10px; margin-top: 10px; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
        .password-output { text-align: center; margin-top: 20px; font-size: 18px; color: #333; }
        .password { font-weight: bold; font-size: 24px; color: #007bff; }
    </style>
</head>
<body>
    <h1>PHP Password Generator</h1>

    <form method="POST" action="">
        <label for="length">Password Length:</label>
        <input type="number" name="length" id="length" min="4" max="64" value="12" required>

        <label>
            <input type="checkbox" name="include_lowercase" checked>
            Include Lowercase Letters
        </label>

        <label>
            <input type="checkbox" name="include_uppercase" checked>
            Include Uppercase Letters
        </label>

        <label>
            <input type="checkbox" name="include_numbers" checked>
            Include Numbers
        </label>

        <label>
            <input type="checkbox" name="include_symbols">
            Include Symbols
        </label>

        <button type="submit">Generate Password</button>
    </form>

    <?php
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
    if ($include_lowercase) {
        $characters .= $lowercase;
    }
    if ($include_uppercase) {
        $characters .= $uppercase;
    }
    if ($include_numbers) {
        $characters .= $numbers;
    }
    if ($include_symbols) {
        $characters .= $symbols;
    }

    if (empty($characters)) {
        echo "<div class='password-output'>Error: You must select at least one character type.</div>";
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
            case 5:
                return 'Very Strong';
            case 4:
                return 'Strong';
            case 3:
                return 'Medium';
            case 2:
                return 'Weak';
            default:
                return 'Very Weak';
        }
    }

    $strength = assessStrength($password);

    echo "<div class='password-output'>
            <p>Your Generated Password: <span class='password'>$password</span></p>
            <p>Password Strength: <strong>$strength</strong></p>
          </div>";
}
?>

</body>
</html>
