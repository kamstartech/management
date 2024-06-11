<?php
class transactions{

	public $core;
	public $service;

	public function configService() {
		$this->service->output = TRUE;
		return $this->service;
	}

        public function runService($core) {
              $this->core = $core;
		$status = $this->core->cleanGet['TranStatus'];	

		if($this->core->item == "queryTrans"){
			$this->queryStatus();
		} else if($status == "v" || $status == "V" || $this->core->item == "reverseTrans"){
			$this->reverseTransaction();
		} else {
			$this->postTransaction();
		}

        }

	public function reverseTransaction() {

		$sql = "SELECT `TransactionID` FROM `transactions` WHERE `TransactionID` = '$transactionid'";
		$run = $this->core->database->doSelectQuery($sql);

      	 	$output = '<?xml version="1.0"?>'. "\n" .
		'<QueryStatusResponse status="ERROR">' . "\n" .
		'<Transaction id="'.$transactionid.'" status="ERROR" errorMessage="NO_SUCH_ENTRY"></Transaction>' . "\n" .
		'</QueryStatusResponse>';

		if($run->num_rows > 0){
			$sql = "DELETE FROM `transactions` WHERE `TransactionID` = '$transactionid'";
			$run = $this->core->database->doSelectQuery($sql);

        	        $output = '<?xml version="1.0"?>'. "\n" .
			'<QueryStatusResponse status="SUCCESS">' . "\n" .
			'<Transaction id="'.$transactionid.'" status="SUCCESS" errorMessage="SUCCESS"></Transaction>' . "\n" .
			'</QueryStatusResponse>';
		}

		echo $output;
	}

	public function postTransaction(){

		$ipaddr = $_SERVER['REMOTE_ADDR']; 
		$file = "log/zanaco.txt";
	
		$input = "\n\n" . date("Y-m-d H:i:s") . " STARTED input from: $ipaddr ============= \n";

		$transactionid = $this->core->cleanPost['TranID'];

		$keyset = $this->core->cleanPost['Key'];
		$requestid = $this->core->cleanPost['RequestId'];
		$tranid = $this->core->cleanPost['TranID'];
		$key = $this->core->cleanPost['Key'];
		$date = $this->core->cleanPost['Date'];
		$amount = $this->core->cleanPost['Amount'];
		$type = $this->core->cleanPost['Type'];
		$studentid = $this->core->cleanPost['StudentID'];  
		$phone = $this->core->cleanPost['Phone'];
		$name = $this->core->cleanPost['Name'];
		$status = $this->core->cleanPost['TranStatus'];


		$calkeya = base64_encode(sha1("f59b51f8f0d0f06dcbe600d525f6dce8b27bb5c1" . "$transactionid"));
		$calkeyb = base64_encode(sha1("fd9b0906018fa37d123456789cae56a3ae89970" . "$transactionid"));

		$status = "SUCCESS";
		$error = "";

		// LOG ALL ZANACO INPUT FOR TESTING AND ACCOUNTING PURPOSES (THEY SOMETIMES SEND STRANGE THINGS)

		foreach ($_POST as $key => $value){
			$input .=  "Field POST ".htmlspecialchars($key)." is ".htmlspecialchars($value). "\n";
		}

		foreach ($_GET as $key => $value){
			$input .=  "Field GET ".htmlspecialchars($key)." is ".htmlspecialchars($value). "\n";
		}


		// SET THE VARIOUS ERROR MESSAGES, ORDERD BY ERROR LEVEL

		if(empty($transactionid)){
			$statusheader = "STATUS_ERROR_INTERFACE";
			$status = "ERR_MISSING_TRANID";
			$error = $status;
		}

		if(empty($requestid)){
			$statusheader = "STATUS_ERROR_INTERFACE";
			$status = "ERR_MISSING_REQUESTID";
			$error = $status;
		}

		if($keyset != $calkeya && $keyset != $calkeyb){
			$statusheader = "STATUS_ERROR_INTERFACE";
			$status = "ERR_INVALID_KEY";
			$error = $status;
		}


		$sql = "SELECT * FROM `basic-information` WHERE `ID` = '$studentid'";
		$run = $this->core->database->doSelectQuery($sql);

		if($run->num_rows ==  0){
			$log = "UNKNOWN STUDENT ID $studentid";
		}


		// TEMPORARY LOGGING FEATURE
		file_put_contents($file, $input, FILE_APPEND);
		file_put_contents($file, $output, FILE_APPEND);



		$sql = "SELECT * FROM `transactions` WHERE `TransactionID` = '$tranid'";

		$run = $this->core->database->doSelectQuery($sql);

		if($run->num_rows > 0){

	                $output = '<?xml version="1.0"?>'. "\n" .
			'<QueryStatusResponse status="SUCCESS">' . "\n" .
			'<Transaction id="'.$tranid.'" status="SUCCESS" errorMessage="SUCCESS"></Transaction>' . "\n" .
			'</QueryStatusResponse>';
			echo $output;
			return;
			
		}

		$data = $this->core->database->escape($input);
		$sql = "INSERT INTO `transactions` (`ID`, `UID`, `RequestID`, `TransactionID`, `StudentID`, `NRC`, `TransactionDate`, `Amount`, `Name`, `Type`, `Hash`, `Timestamp`, `Phone`, `Status`, `Error`, `Data`)
			VALUES (NULL, '$studentid', '$requestid', '$tranid', '$studentid', '$nrc', '$date', '$amount', '$name', '$type', '$keyset', CURRENT_TIMESTAMP, '$ipaddr', '$statusheader', '$status', '$data');";

		$qr = FALSE;
		if($statusheader != "STATUS_ERROR_INTERFACE"){
			$qr = $this->core->database->doInsertQuery($sql, TRUE);
			if($qr == TRUE){
				
			} else {
				$statusheader = "STATUS_ERROR_INTERFACE";
				$status = "ERR_GENERAL_FAILURE";
				$error = $status;
			}
	
		}


		$output ='<?xml version="1.0"?>' . "\n" .
			'<PostTranResponse status="'.$statusheader.'" errorMessage="">'  . "\n" .
			'<Transaction id="'.$transactionid.'" status="'.$status.'" errorMessage="'.$error.'"></Transaction>'  . "\n" .
			'</PostTranResponse>';


		echo $output;
		
		$sql = "SELECT * FROM `transactions` WHERE `TransactionID` = '$tranid' AND `Status` != 'PROCESSED'";

		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$tranid =  $fetch["ID"];
			file_get_contents('http://41.63.0.222/transactions.php?id='.$tranid);
		}



	}

	public function queryStatus(){

		$transactionid = $this->core->cleanPost['TranID'];	

		$sql = "SELECT * FROM `transactions` WHERE `TransactionID` = '$transactionid'";

		$run = $this->core->database->doSelectQuery($sql);

		if($run->num_rows > 0){

	                $output = '<?xml version="1.0"?>'. "\n" .
			'<QueryStatusResponse status="SUCCESS">' . "\n" .
			'<Transaction id="'.$transactionid.'" status="SUCCESS" errorMessage="SUCCESS"></Transaction>' . "\n" .
			'</QueryStatusResponse>';
			
		}

		echo $output;
	}

}
?>

