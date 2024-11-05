<?php
header("content-type: Application/json");
include('db.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'),true);


switch($method) {
    case 'GET':
      handLeGet($mysqli);
      break; 

    case 'POST':
       handLePost($mysqli , $input);
       break;
    
    case 'PUT':
        handLePut($mysqli , $input);
        break;       
    
    case 'DELETE':
        handLeDelete($mysqli, $input);
        break;
        
    default:
    echo json_encode(['message' => 'Invalid request Method']);
    break;
}


function handleGet($mysqli) {
    $sql = "SELECT * FROM users";
    $result = $mysqli->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function handlePost($mysqli, $input) {
  $checkSql = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $mysqli->prepare($checkSql);
    $checkStmt->bind_param("s", $input['email']);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        echo json_encode(['message' => 'User with this email already exists']);
        return;
    }

    $sql = "INSERT INTO users (name, email) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $input['name'], $input['email']);
    $stmt->execute();
    echo json_encode(['message' => 'User created successfully']);
}

function handlePut($mysqli, $input) {
    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $input['name'], $input['email'], $input['id']);
    $stmt->execute();
    echo json_encode(['message' => 'User updated successfully']);
}

function handleDelete($mysqli, $input) {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $input['id']);
    $stmt->execute();
    echo json_encode(['message' => 'User deleted successfully']);
}

?>