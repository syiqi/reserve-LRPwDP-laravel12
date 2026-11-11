<?php
// run-scheduler.php
echo "Starting Laravel scheduler loop..." . PHP_EOL;

while (true) {
    echo "[" . date('Y-m-d H:i:s') . "] Running Laravel scheduler..." . PHP_EOL;

    $output = [];
    exec('php artisan schedule:run', $output);
    echo implode(PHP_EOL, $output) . PHP_EOL;

    sleep(60);
}