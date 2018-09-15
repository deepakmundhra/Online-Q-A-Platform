<?php
include('dbconn.php');
if(!empty($_COOKIE['username']))
	$_SESSION['value'][0]=$_COOKIE['username'];
if(!empty($_COOKIE['password']))
	$_SESSION['value'][1]=$_COOKIE['password'];
if(!empty($_REQUEST['id'])){
	$qid=$_REQUEST['id'];
	$stat=1;
	$ddd="UPDATE questions SET questions_status='{$stat}' WHERE question_id='{$qid}'";
	$db->query($ddd) or die($db->error);
}
?>
<html>
	<head>
		<title>First Page</title>
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
					</table>";
				}
					else
					{
						$k=$_SESSION['value'][0];
						$name="SELECT first_name FROM user_details WHERE email='{$k}'";
						$r=$db->query($name) or die($db->error);
						$rws=$r->fetch_array()or die($db->error);
						echo "<br><h3><ul>
									<li>
										Welcome
									</li>
        							<li>".$rws[0]."&#9662;
            								<ul class='dropdown'>
                								<li><a href='profile.php'>Profile</a></li>
                								<li><a href='update.php'>Update</a></li>
            								</ul>
        							</li>
    							</ul></h3>";
					}
					?>
				</form>
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
		</div>
		<div id="hmid">
			<table width="96%">
				<tr>
					<form action="search.php" method="GET">
					<td width="80"><input type="text" name="query2" placeholder="Search"/><input type="submit" value="Search" /></td>
					</form>
					<td width="120" align="center"><a href="first.php">Home</a></td>
					<td width="120" align="center"><a href="aboutus.php">About Us</a></td>
					<td width="120" align="center"><a href="contactus.php">Contact Us</a></td>
					<?php 
						if(empty($_SESSION['value']))
						echo"<td  width=130 align=right><b><a href='register.php' style='font-size:20'>Sign Up</a></b></td>";
						else
						echo"<td  width=130 align=center><b><a href=logout.php>"."Logout"."</a></b></td>";
					?>
				</tr>
			</table>
		</div>
		<div id="leftpanel">
			<div id="leftm">
				<form>
				<table align="center" width="90%">
					<tr><td align="center"><h2>Categories</h2><hr></td></tr>							
							<?php 
						$sqlll="SELECT category FROM categories";
						$res=$db->query($sqlll) or die($db->error);
						while($rwws=$res->fetch_array())
							echo "<tr><td><input type='submit' height='25px' width='100px' value='".strtoupper($rwws[0])."' name='".$rwws[0]."'/></td></tr>";
					?>
					<tr><td><input type="submit" value=<?php echo strtoupper("others");?> name="others"/></td></tr>
					<?php?>
				</table>
			</form>
			<?php
					$sqlll="SELECT category FROM categories";
						$res=$db->query($sqlll) or die($db->error);
						while($rwws=$res->fetch_array())
				 		{
				 			if(!empty($_REQUEST[$rwws[0]]))
				 				header("Location:register.php?id=".$rwws[0]."");
				 		}
			?>
			</div>
		</div>
		<div id="contents">
			<div id="contentsm">
				<p align="center"><br>
					<?php if(!empty($_REQUEST['id'])){
					echo"<form method='POST'>
					<table>
						<tr></tr>
						<tr><td>";
							$sqlll = "SELECT answer_id,answer,users_id,category,datetimes FROM answers WHERE answer_id='{$qid}'";
							$res=$db->query($sqlll) or die($db->error);
						    $rws=$res->fetch_array();
						    $su="SELECT email FROM user_details WHERE users_id='{$rws[2]}'";
  							$res=$db->query($su) or die($db->error);
  							$rw=$res->fetch_array()or die($db->error);
  							echo "Q.".$rws[1]."</td></tr><tr><td>";
				 			echo "<b>ID:</b>".$rws[0]." <b>Answered by:</b>".$rw[0]."<br><b>Category:</b>".$rws[3]." <b>Posted:</b>".$rws[4]."<br>";
				 			echo"<tr><td><textarea name='a'></textarea></td></tr>
				 			<tr><td><input type='submit' name='b' value='Answer' class='button'/></td></tr>";
							echo"</table>";
							echo"</form>";	
					if(!empty($_REQUEST['b']))
					{
						$answ=$_REQUEST['a'];
						$sql = "INSERT INTO comments VALUES('','{$answ}','{$rws[0]}','{$_SESSION['value'][0]}',NOW(),'')";
						$db->query($sql) or die($db->error);
						if($db->affected_rows==1)
						{
						echo"<h2>Successfully Posted!!</h2>
					<br><a href='content.php'>Continue</a>";
					}
					else
						echo "Error";
				}
			}
		?>	
		</p>
		</div>
		</div>
		<div id="rightpanel">
		<div id="rightm">
			<table align="center" width="90%">
						<tr><td align="center"><h2>Improve your feed</h2><hr></td></tr>
						<tr><td align="center">
						<form method="POST" >
						<input type="submit" value="Ask a question" name="askquestion"<?php if(empty($_SESSION['value']))echo "onclick='error()'";?>/><form></td></tr>
						<form method="POST">
						<tr><td align="center"><input type="submit" value="Answer a question" name="answerquestion"<?php if(empty($_SESSION['value'])) echo "onclick='error()'";?>/></td></tr>
						</form>
						<?php if(!empty($_REQUEST['askquestion'])&&!empty($_SESSION['value']))
									header("Location:askquestion.php");
						?>
						<?php if(!empty($_REQUEST['answerquestion'])&&!empty($_SESSION['value']))
									header("Location:answerquestion.php");
						?>
			</table>
			</form>
		</div>
		</div>
	</div>
	</body>
</html>