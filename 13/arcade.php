<?php

$startButton = isset($_REQUEST['sb']);
$leftButton = $_REQUEST['lb'];
$rightButton = $_REQUEST['rb'];

echo json_encode([
    'screen' => time(),
    'sb' => $startButton,
    'lb' => $leftButton,
    'rb' => $rightButton
]);