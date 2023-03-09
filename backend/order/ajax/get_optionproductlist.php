<?php
header('Content-Type: application/json');
include('../../conn.php');

session_start();
if (!isset($_SESSION['loggedin'])) {
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
    die;
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $productgroupid = $_GET["g"];
        $sql = "
        select id id, productname text 
        from productlists
        where productgroupid = $productgroupid order by seq;";
        $stmt = $conn->prepare($sql);
        if (!$stmt->execute()){
            throw new mysqli_sql_exception("Insert data error."); 
        } 

        $resultSet = $stmt->get_result();
        $res = $resultSet->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC

        // Free result set
        $stmt->free_result();

        $conn->close();
        echo json_encode($res);
    } catch (mysqli_sql_exception $e) {
        mysqli_close($conn);

        http_response_code(400);
        echo json_encode(array('status' => '0', 'message' => "Sql fail."));
    }
}else{
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => "Not foind request."));
}
exit;