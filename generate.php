<link rel="stylesheet" type="text/css" href="styles.css">

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
        echo "<p>Error: You must select at least one character type.</p>";
        echo "<a href='index.php'>Go Back</a>";
        exit;
    }

    $password = '';
    $charactersLength = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, $charactersLength - 1)];
    }

    echo "<h1>Your Generated Password:</h1>";
    echo "<p style='font-size: 24px;'><strong>$password</strong></p>";
    echo "<a href='index.php'>Generate another password</a>";
} else {
    header('Location: index.php');
    exit;
}
// Function to copy password
echo "<p style='font-size: 24px;'><strong id='password'>$password</strong></p>";
echo "<button onclick='copyPassword()'>Copy to Clipboard</button>";
echo "<script>
function copyPassword() {
    var copyText = document.getElementById('password').innerText;
    navigator.clipboard.writeText(copyText).then(function() {
        alert('Password copied to clipboard');
    }, function(err) {
        alert('Could not copy password: ', err);
    });
}
</script>";

?>
