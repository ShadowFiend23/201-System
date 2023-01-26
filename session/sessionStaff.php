<?php 
	date_default_timezone_set('Asia/Manila');
	session_start();
	if(isset($_SESSION["type"])){
		if($_SESSION["type"] == 'admin'){

			$_SESSION = array();
			session_destroy();
			header("Location: login.php");

		}
	}else{

		$_SESSION = array();
		session_destroy();
		header("Location: login.php");

	}
		
?>
<input type="hidden" id="department" value="<?php echo $_SESSION["type"]  ?>" >