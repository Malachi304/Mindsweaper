<?php
session_start();
include 'config.php';

// Set the correct header
header('Content-Type: application/json');

// Error handling for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is signed in
    if (!isset($_SESSION['username'])) {
        echo json_encode(["status" => "error", "message" => "User not logged in"]);
        exit();
    }

    // Validate score
    $score = json_decode(file_get_contents('php://input'), true)['score'] ?? null;
    if (!is_numeric($score)) {
        echo json_encode(["status" => "error", "message" => "Invalid score"]);
        exit();
    }

    // Insert score into the leaderboard
    $username = $_SESSION['username'];
    $sql = "INSERT INTO leaderboard (name, score) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $score);

    if ($stmt->execute()) {
        $stmt->close();

        // Retrieve the updated leaderboard
        $result = $conn->query("SELECT name, score FROM leaderboard ORDER BY score ASC");
        $leaderboard = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode(["status" => "success", "leaderboard" => $leaderboard]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update leaderboard"]);
    }
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve leaderboard for GET requests
    $result = $conn->query("SELECT name, score FROM leaderboard ORDER BY score ASC");
    $leaderboard = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(["status" => "success", "leaderboard" => $leaderboard]);
    exit();
}
?>
