<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    if ($password == 'cbtenjoyer') {
        // Clear the suggestions, voted IPs, and submission counts
        file_put_contents('voting/suggestions.json', json_encode([]));
        file_put_contents('voting/voted_ips.json', json_encode([]));
        file_put_contents('voting/submission_counts.json', json_encode([]));
        echo "<script>alert('Data has been reset.'); window.location.href='site.html';</script>";
    } else {
        echo "<script>alert('Incorrect password.'); window.location.href='site.html';</script>";
    }
} else {
    header('Location: site.html');
    exit;
}
?>
