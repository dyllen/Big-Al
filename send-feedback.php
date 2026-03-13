<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Method not allowed.'
    ]);
    exit;
}

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput ?: '', true);

$message = '';
if (is_array($data) && isset($data['message'])) {
    $message = trim((string)$data['message']);
} elseif (isset($_POST['message'])) {
    $message = trim((string)$_POST['message']);
}

if ($message === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'error' => 'Feedback message is required.'
    ]);
    exit;
}

$to = 'dylan@chottomotto.com.au';
$subject = 'Feedback from Big Al';
$sanitizedMessage = preg_replace('/\r\n|\r|\n/', PHP_EOL, $message) ?? $message;

$rawHost = isset($_SERVER['HTTP_HOST']) ? (string)$_SERVER['HTTP_HOST'] : 'localhost';
$hostWithoutPort = explode(':', $rawHost)[0] ?? 'localhost';
$serverHost = preg_replace('/[^a-zA-Z0-9.-]/', '', $hostWithoutPort) ?: 'localhost';
$fromAddress = 'noreply@' . $serverHost;
$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'From: Big Al Feedback <' . $fromAddress . '>',
    'Reply-To: ' . $fromAddress
];

$sent = mail($to, $subject, $sanitizedMessage, implode("\r\n", $headers));

if (!$sent) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server could not send email.'
    ]);
    exit;
}

echo json_encode(['success' => true]);
