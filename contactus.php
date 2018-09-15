<?php
include('dbconn.php');
if(!empty($_COOKIE['username']))
	$_SESSION['value'][0]=$_COOKIE['username'];
if(!empty($_COOKIE['password']))
	$_SESSION['value'][1]=$_COOKIE['password'];
?>
<html>
	<head>
		<title>Contact Us</title>
		<link rel="stylesheet" type="text/css" href="registerpage.css"/>
		<script type="text/javascript">
		function error(){
			alert('Please Login');
		}
		</script>
	</head>
	<body>
		<div id="wrapper">
		<div id="header">
			<div id="logo">
				<img src="logo.jpg" height="120" width="150">
			</div>
			<div id="title">
			</div>
			<div id="user">
			<form method="POST">
					<?php if(empty($_SESSION['value'])){
					echo"<table cellspacing='6'>
						<tr>
							<td><font color='white'>Email</font></td>
							<td><input type='text' placeholder='Enter Email' name='username'/></td>
						</tr>
						<tr>
							<td><font color='White'>Password</td>
							<td><input type='password' placeholder='Enter Password' name='password'/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type='submit' value='Login' name='login'/></td>
						</tr>
					</table></form>";
				}
					else
					{
						$k=$_SESSION['value'][0];
						$name="SELECT first_name FROM user_details WHERE email='{$k}'";
						$r=$db->query($name) or die($db->error);
						$rws=$r->fetch_array()or die($db->error);
						echo "<br><br>"."<h3>"."Welcome "."<a href='first.php'>".$rws[0]."</a></h3>";
					}
					?>
					<?php if(!empty($_REQUEST['login']))
						{
							if(empty($_REQUEST['username'])||empty($_REQUEST['password']))
							echo "<p align='center'><font color='red'>Please fill all detials</font></p>"."<br>";
							else
							{
								$email=$_REQUEST['username'];
								$pass=md5($_REQUEST['password']);

									$check="SELECT email,password FROM user_details WHERE email='{$email}'";
									$r=$db->query($check) or die($db->error);
									$rs=$r->fetch_array();
									if($rs[1]==$pass)
									{
										setcookie('username',$_REQUEST['username'],time()+10);
										setcookie('password',$_REQUEST['password'],time()+10);
										$_SESSION['value'][0]=$_COOKIE['username'];
										$_SESSION['value'][1]=$_COOKIE['password'];
										header('Location:first.php');
									}
									else
										echo "<p align='center'><font color='red'>Incorrect Details</font></p>";
							}
						}
					?>
		</div>
		<div id="hmid">
			<table width="96%">
				<tr>
					<td width=120 align=right><a href="first.php">Home</a></td>
					<td width=120 align=right><font color="white"><a href="aboutus.php">About Us</a></font></td>
					<td width=120 align=right><font color="white"><a href="contactus.php">Contact Us</font></td>
					<?php 
						if(empty($_SESSION['value']))
						echo"<td  width=130 align=right><b><a href='register.php' style='font-size:20'>Sign Up</a></b></td>";
						else
						echo"<td  width=130 align=right><b><a href=logout.php>"."logout"."</a></b></td>";
					?>
				</tr>
			</table>
		</div>
		<div id="leftpanel">
		</div>
		<div id="contents">
			<div id="contentsms">
				<div id="aboutus">
					<br>
					<p align="centre"><h1><u>CONTACT US</u></h1></p>
				</div>
				<div id="contactmail">
				<form method="POST">
				<table align="left">
					<br><br>
					<tr>
						<td align="center"><font size="5">Feedback:</font></td>
					</tr>
					<tr></tr><br><tr><br></tr>
					<tr><td><font size="5">Subject:</font><textarea rows="1" cols="78" name="sub"></textarea></td></tr>
					<tr>
						<td><p align="center"><textarea rows="12" cols="102" name="feedback"></textarea></p></td>
					</tr>
					<tr>
						<td ><center><input type="submit" name="submit" style="margin-top: 25px;" class="button"<?php if(empty($_SESSION['value'])) echo "onclick='error()'";?>/></center></td>
					</tr>
				</table></form>
				<?php 
				if(!empty($_SESSION['value'])&&!empty($_REQUEST['submit']))
				{
					echo $raw=$_REQUEST['feedback'];
					echo $sub=$_REQUEST['sub'];
					mail('hello@gmail.com',$sub,$raw);
				}
				?>
				</div>
			</div>
		</div>
		<div id="rightpanel">
		</div>
	</div>
</body>
</html>