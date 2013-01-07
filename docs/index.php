<?php
require_once '../app/configs/config.php';
require_once APP_PATH . 'includes/preload.php';

if ($_SERVER['SERVER_NAME'] == API_SERVER_NAME) {
    $application = new ApiApplication();
    $application->run();
}
else {
    $application = new PApplication();
    $application->run();
}