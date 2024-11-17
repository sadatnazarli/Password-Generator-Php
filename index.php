<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Password Generator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        h1 { color: #333; }
        form { max-width: 400px; margin: auto; }
        label { display: block; margin-top: 10px; }
        button { margin-top: 20px; padding: 10px 20px; }
    </style>
</head>
<body>
    <h1>PHP Password Generator</h1>
    <form action="generate.php" method="POST">
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
</body>
</html>
