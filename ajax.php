<?php
/* Request Parameters */
$str_json = file_get_contents('php://input'); 
$data     = json_decode($str_json, true);

$values     = $data["values"];
$operation  = $data["operation"];

$result = 0;
$status = 'OK';

switch ($operation) {
    case 'sum':
        $result = $values[0] + $values[1];
        break;
    case 'subtraction':
        $result = $values[0] - $values[1];
        break;
    case 'division':
        if ($values[1] != 0) {
            $result = $values[0] / $values[1];
        } else {
            $status = 'error';
        }
        break;
    case 'multiplication':
        $result = $values[0] * $values[1];
        break;
    default:
        $status = 'error';
        break;
}

$result_array = [];
$result_array['Result'] = (string)$result;
$result_array['Status'] = $status;

echo json_encode($result_array);

?>