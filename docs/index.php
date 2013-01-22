<?php
require_once '../app/configs/config.php';
require_once APP_PATH . 'includes/preload.php';

header('Content-Type: text/html;charset=utf-8');

if ($_SERVER['SERVER_NAME'] == API_SERVER_NAME) {
    $application = new ApiApplication();
    $application->run();
}
else {
    $application = new PApplication();
    $application->run();
}
