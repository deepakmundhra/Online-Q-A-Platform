<?php
include('dbconn.php');
if(empty($_SESSION['value']))
	header('Location:first.php');
if(!empty($_COOKIE['username']))
	$_SESSION['value'][0]=$_COOKIE['username'];
if(!empty($_COOKIE['password']))
	$_SESSION['value'][1]=$_COOKIE['password'];
?>
<html>
	<head>
		<title>Ask A Question</title>
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
					else{
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
							echo "<tr><td align='center'><input type='submit' id='catbut' style='height:25px; width:100px;' value='".strtoupper($rwws[0])."' name='".$rwws[0]."'/></td></tr>";
					?>
					<tr><td align="center"><input type="submit" id="catbut" style="height:25px; width:100px;" value=<?php echo strtoupper("others");?> name="others"/></td></tr>
					<?php?>
				</table>
			</form>
			<?php
					$sqlll="SELECT category FROM categories";
						$res=$db->query($sqlll) or die($db->error);
						while($rwws=$res->fetch_array())
				 		{
				 			if(!empty($_REQUEST[$rwws[0]]))
				 			{
				 				$k="".$rwws[0];
				 				header('Location:first.php?id='.$rwws[0].'');
				 			}
				 		}
				 		if(!empty($_REQUEST['others']))
				 			{
				 				$k=""."others";
				 				header('Location:first.php?id='."others".'');
				 			}
			?>
			</div>
		</div>
		<div id="contents">
		<div id="contentsm">
		<p align="center">
			<form method="POST">
			<p align="center">
			<br><br>
			<table cellspacing="8" cellpadding="10">
			<caption><h1><font color="#28285F">Ask A Question</font></h1></caption>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><b>Category</b>
					<select name="qc">
							<option>Select Category</option>
							<?php 
						$sqlll="SELECT category FROM categories";
						$res=$db->query($sqlll) or die($db->error);
						while($rwws=$res->fetch_array())
							echo "<option>".$rwws[0]."</option>";
					?>
						<option>Others</option>
					</select>
					<input type="text" name="newcat" placeholder="Enter New Category(if any)"/>
				</td>
				<td></td>
			</tr>
			<tr>
				<td><b>Ask Question</b></td>
				<td></td>
			</tr>
			<tr>
				<td><textarea placeholder="Write Your Question" rows="6" cols="50" name="qa"></textarea></td>
				<td></td>
			<tr>
				<td><input type="submit" name="qb" value="Submit" class="button"/></td>
				<td></td>
			</tr>
		</table></p>
		</form>
		<?php
		if (!empty($_REQUEST['qb'])) {
			include('dbconn.php');
			if(empty($_REQUEST['qa'])||empty($_REQUEST['qc']))
				echo "<p align='center'><font color='red'>Please Fill the Information Properly</font></p>";
			else{
				$quest=$_REQUEST['qa'];
				$cat=$_REQUEST['qc'];
				$y=$_SESSION['value'][0];
				$tstamp=date('Y-m-d H:i:s');
				$catn=$_REQUEST['newcat'];
				if(!empty($_REQUEST['newcat'])){
					$sqll = "INSERT INTO categories VALUES('','{$catn}','')";
					$db->query($sqll) or die($db->error);
				}
				$z="SELECT users_id FROM user_details WHERE email='{$y}'";
				$r=$db->query($z) or die($db->error);
				$rw=$r->fetch_array()or die($db->error);
				if(empty($_REQUEST['newcat']))
					$sql = "INSERT INTO questions VALUES('','{$quest}','{$rw[0]}','','{$cat}','{$tstamp}')";
				else
					$sql = "INSERT INTO questions VALUES('','{$quest}','{$rw[0]}','','{$catn}','{$tstamp}')";
				$db->query($sql) or die($db->error);
				if($db->affected_rows==1)
				{
					echo "<p align='center'>";
					echo "Successfully Posted"."<br>";
					echo "</p>";
				}
				else
					echo "No record has been inserted";
			}
		}
		?>
		</p>
		</div>
		</div>
		<div id="rightpanel"><div id="rightm">
			<table align="center" width="90%">
						<tr><td align="center"><h2>Improve your feed</h2><hr></td></tr>
						<tr><td align="center">
						<form method="POST" >
						<input type="submit" value="Ask a question" id="catbut" style="height:25px; width:150px;" name="askquestion"<?php if(empty($_SESSION['value'])) echo "onclick='error()'";?>/><form></td></tr>
						<tr><td align="center"><input type="submit" id="catbut" style="height:25px; width:150px;" value="Answer a question" name="answerquestion"<?php if(empty($_SESSION['value'])) echo "onclick='error()'";?>/></td></tr>
						</form>
						<?php if(!empty($_REQUEST['askquestion'])&&!empty($_SESSION['value']))
									header("Location:askquestion.php");
						?>
						<?php if(!empty($_REQUEST['answerquestion'])&&!empty($_SESSION['value']))
									header("Location:answerquestion.php");
						?>
			</table>
		</div>
		</div>
	</div>
	</body>
</html>