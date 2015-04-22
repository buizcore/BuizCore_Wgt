<?php 

$outputBuffer = fopen("php://output", 'w');

if ($VAR->head) {
    fputcsv($outputBuffer, $VAR->head);
}

foreach ($VAR->data as $row) {
    fputcsv($outputBuffer, $row);
}

fclose($outputBuffer);

?>