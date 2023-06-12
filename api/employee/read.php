<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");

        include_once '../../config/database.php';
        include_once '../../models/employees.php';

$database = new Database();
$db = $database->getConnection();
if(isset($_GET['id'])){ //cek id
    $item = new Employee($db);
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();

    $item->getSingleEmployee();
    if($item->name != null){

// create array
    $emp_arr = array(
    "id" => $item->id,
    "name" => $item->name,
    "email" => $item->email,
    "age" => $item->age,
    "designation" => $item->designation,
    "created" => $item->created
 );

http_response_code(200);
echo json_encode($emp_arr);

}
else{
http_response_code(404);
echo json_encode("Employee not found.");
 }
}
else {
$items = new Employee($db);
$stmt = $items->getEmployees();
$itemCount = $stmt->rowCount();

echo json_encode($itemCount);
if($itemCount > 0){

    $employeeArr = array();
        $employeeArr["body"] = array();
    $employeeArr["itemCount"] = $itemCount;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $e = array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "age" => $age,
            "designation" => $designation,
            "created" => $created
        );
        array_push($employeeArr["body"], $e);
        }
    echo json_encode($employeeArr);
}
    else{
        http_response_code(404);
        echo json_encode(
        array("message" => "No record found.")
        );
    }
}
?>
