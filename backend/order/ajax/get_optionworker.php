<?php
	header('Content-Type: application/json');
	session_start();
	if (!isset($_SESSION['loggedin'])) {
		http_response_code(400);
		echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
		die;
	}

	if ($_SERVER["REQUEST_METHOD"] == "GET" ) {
		include('../../conn.php');		
		$ky = $_GET["ky"];
		$em = $_GET["em"];
		try{
			switch($ky)
			{
				case "GetByEmployer" :
					
					$sql = "select w.wkcode id, concat(w.wkname, ' ', w.lastname, ' / ', w.passport) text 
					from employment e
						inner join employer e2 on e2.empcode = e.empcode
						inner join worker w on w.wkcode  = e.wkcode
					where e.status = 'Y'
						and e.empcode = ? ;";
					$stmt = $conn->prepare($sql);  
					$stmt->bind_param('s', $em);
					if (!$stmt->execute()){
						throw new mysqli_sql_exception(); 
						die;
					}  
					$resultSet = $stmt->get_result();
					$res = $resultSet->fetch_all(MYSQLI_ASSOC);
					$stmt->free_result(); 
					echo json_encode($res);
					break;
				case "GetByWorker" :
					break;
				defalut:
					var_dump($_GET);
					break; 
			}
		} catch (mysqli_sql_exception $e){
			http_response_code(400);
			echo json_encode(array('status' => '0', 'message' => 'Unhandle error!'));
			die;
		}finally{
			$conn->close();	
			die;
		} 
	}	

	exit;
