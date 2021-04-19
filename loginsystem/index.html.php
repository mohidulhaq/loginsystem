<html>
	<head>
		<style>
			body{
				text-align:center;
			}
			
			.data_input_field_wrapper{
				width:300px;margin:auto;
			}

			.data_input_field{
				display:flex;
				flex-direction:column;
				margin-bottom:6px;
				border:0px solid #f00;
			}

			.data_input_field label{
				flex:1;
				line-height:30px;
				font-weight:bold;
				border:0px solid #3ef;
			}
			
			.data_input_field input{
				flex:2;
				line-height:30px;
				padding:3px 12px;
				border:1px solid rgba(255,255,255,0.25);
				border-radius:3px;
				box-shadow:0 0 3px #555;
				-moz-box-shadow:0 0 3px #555;
				-webkit-box-shadow:0 0 3px #555;
			}

		</style>
		
		<title></title>
	</head>
	<body>
	<?php
	
		session_start();

		$link = mysqli_connect('localhost', 'root', '');
		if (!$link){
			$output = 'Unable to connect to the database server.';
			echo $output;
			exit();
		}

		if (!mysqli_select_db($link, 'loginsystem')){
			$output = 'Unable to locate the loginsystem database.';
			echo $output;
			exit();
		}
		
		if(isset($_GET['p']) && $_GET['p'] == 'logout'){
			if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true){
				unset($_SESSION['logged-in']);
				$_SESSION['username'] = "";
				
				header("Location: ../../loginsystem/");
				exit();
			}	
		}
		
		if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== true){
			if(isset($_POST['submit']) && $_POST['submit'] == "Login"){
				if(isset($_POST['user']) && isset($_POST['pass']) &&  $_POST['user'] !== "" && $_POST['pass'] !== ""){
					$chkuser = mysqli_real_escape_string($link, $_POST['user']);
					$chkpass = mysqli_real_escape_string($link, $_POST['pass']);
					
					//$chkpassmd5 = MD5($chkpass);
					
					$sql = "SELECT UserId FROM accounts WHERE UserId='$chkuser' AND Pass='$chkpass'";
					$res = mysqli_query($link, $sql);
					if(mysqli_num_rows($res) > 0){
						$dat = mysqli_fetch_array($res);
						$userid = $dat['UserId'];
						
						if($chkuser === $userid){
							$_SESSION['logged-in'] = true;
							$_SESSION['username'] = $userid;
						}
						else{
							
						}
					}else{
						echo "<span style='color:red;'>Username or password incorrect!</span>";
					}
				}else{
					echo "<span style='color:red;'>Username or Password empty!</span>";
				}
			}
		}
			
		
		if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== true){
	?>
		<h1>Account Login</h1>
		<div class="data_input_field_wrapper">
			<form action="" method="post">
				<div class="data_input_field">
					<label>Username: </label>
					<input type="text" name="user" />
				</div>
				
				<div class="data_input_field">
					<label>Password: </label>
					<input type="password" name="pass" />
				</div>
				
				<div class="data_input_field">
					<label>&nbsp;</label>
					<input type="submit" name="submit" value="Login" />
				</div>
			</form>
		</div>
	<?php
		}else{
			echo "You are logged-in. <a style='color:red;' href='.?p=logout'>Logout</a>";
		}
	?>	
		
	</body>
</html>