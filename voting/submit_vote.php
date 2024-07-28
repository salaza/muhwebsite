<?php
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$ip = getUserIP();

// Load existing suggestions and submission counts
$suggestions = json_decode(file_get_contents('suggestions.json'), true);
$submission_counts = json_decode(file_get_contents('submission_counts.json'), true);

// Initialize submission_counts array if it's null
if ($submission_counts === null) {
    $submission_counts = [];
}

// Check if the IP has already submitted 3 suggestions
if (isset($submission_counts[$ip]) && $submission_counts[$ip] >= 2) {
    echo "<script>alert('You have already submitted 2 suggestions.'); window.location.href='submit_vote.html';</script>";
    exit;
}

// Add the new suggestion
$new_suggestion = array('name' => $_POST['name'], 'suggestion' => $_POST['suggestion'], 'votes' => 0);
$suggestions[] = $new_suggestion;

// Increment the submission count for the IP
if (isset($submission_counts[$ip])) {
    $submission_counts[$ip] += 1;
} else {
    $submission_counts[$ip] = 1;
}

// Save the updated suggestions and submission counts back to their respective files
file_put_contents('suggestions.json', json_encode($suggestions));
file_put_contents('submission_counts.json', json_encode($submission_counts));

header('Location: voting.php');
exit;
?>
