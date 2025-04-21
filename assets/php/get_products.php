<?php
header('Content-Type: application/json');
require_once __DIR__ . '/conn.php';

try {
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }
    
    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            "id" => $row["id_product"], 
            "name" => $row["product_name"], 
            "desc" => $row["product_desc"],
            "price"=>$row["price"],
            "image" => $row["img"]
        );
    }
    
    echo json_encode($data, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>