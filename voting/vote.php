<?php
// Function to get the user's IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Load existing suggestions and IP addresses
$suggestions = json_decode(file_get_contents('suggestions.json'), true);
$voted_ips = json_decode(file_get_contents('voted_ips.json'), true);

// Initialize voted_ips array if it's null
if ($voted_ips === null) {
    $voted_ips = [];
}

$ip = getUserIP();

if (in_array($ip, $voted_ips)) {
    // If the IP has already voted, redirect with a message
    echo "<script>alert('You have already voted.'); window.location.href='voting.php';</script>";
    exit;
}

if (isset($_POST['index']) && is_numeric($_POST['index']) && $_POST['index'] >= 0 && $_POST['index'] < count($suggestions)) {
    $index = $_POST['index'];
    if (isset($suggestions[$index]['votes'])) {
        $suggestions[$index]['votes'] += 1;
    } else {
        $suggestions[$index]['votes'] = 1;
    }
    // Add the user's IP to the list of voted IPs
    $voted_ips[] = $ip;
    // Save the updated suggestions and voted IPs back to their respective files
    file_put_contents('suggestions.json', json_encode($suggestions));
    file_put_contents('voted_ips.json', json_encode($voted_ips));
    header('Location: voting.php');
    exit;
} else {
    header('Location: voting.php');
    exit;
}
?>
