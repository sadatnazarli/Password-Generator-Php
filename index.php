<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Password Generator</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

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
