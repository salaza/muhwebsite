<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../xd.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <title>Voting Page</title>
    <style>
        .center-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .suggestion-list {
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
        }
        .suggestion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .suggestion-text {
            flex: 1;
            margin-right: 10px;
        }
        .vote-container {
            display: flex;
            align-items: center;
        }
        .votes-count {
            margin-left: 10px;
            font-weight: bold;
        }
        .home-link {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="home-link">
            <a href="../index.html">Home</a>
        </div>
        <div class="center-text">
            <h1>Vote on Suggestions</h1>
            <div class="suggestion-list">
                <?php
                    $suggestions = json_decode(file_get_contents('suggestions.json'), true);
                    if (!empty($suggestions)) {
                        foreach ($suggestions as $index => $suggestion) {
                            $name = isset($suggestion['name']) ? htmlspecialchars($suggestion['name']) : 'Anonymous';
                            $suggestionText = isset($suggestion['suggestion']) ? htmlspecialchars($suggestion['suggestion']) : 'Unknown suggestion';
                            $votes = isset($suggestion['votes']) ? $suggestion['votes'] : 0;
                            echo "<div class='suggestion'>";
                            echo "<div class='suggestion-text'>" . $suggestionText . "<br><small>by " . $name . "</small></div>";
                            echo "<div class='vote-container'>";
                            echo "<form action='vote.php' method='POST'>";
                            echo "<input type='hidden' name='index' value='" . $index . "'>";
                            echo "<button type='submit'>Vote</button>";
                            echo "</form>";
                            echo "<div class='votes-count'>" . $votes . "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "No suggestions available.";
                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
