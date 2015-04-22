$outputBuffer = fopen("php://output", 'w');
foreach($VAR->data as $row){
    fputcsv($outputBuffer, $row);
}
fclose($outputBuffer);