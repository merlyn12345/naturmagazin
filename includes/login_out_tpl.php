 <?php 
//wenn der user angemeldet ist, dann bekommt er ein div angezeigt =>du bist als bla angemeldet & link zum ausloggen
	if(isset($_SESSION['aut_user'])){
		$name=$_SESSION[aut_user];
		 $login_out="<div align=\"center\" width=\"90%\" style=\"border:4px solid #96B566; padding:10px 0; background-color:#333333; color:white;\">Du bist als: <br /><span style=\"color:#96B566; text-decoration:underline; \"> ".$name." </span><br />angemeldet<br /><br /><a href=\"includes/logout.php\">Ausloggen</a></div>";
	}
// wenn der user nicht angemeldet ist, 
	elseif(!isset($_SESSION['aut_user'])){
//wenn der user nicht berechtigt ist: dann wird message (nicht angemeldet für zugriff) ausgeprintet || bei fehlerhafter eingabe (falscher username/passwort)
			 $login_out= $_SESSION['loginmessage'] . $_SESSION['fail login'] .'
		<br />
<!-- loginformular -->
		<form action="includes/auth.php" method="post">
			<table>
				<tr>
					<td>Username</td>
				<tr>
				</tr>
					<td><input style="text" name="username" size="12" maxlength="12" /></td>
				</tr>
				<tr>
					<td>Passwort</td>
				<tr>
				</tr>
					<td><input type="password" name="passwd" size="12" maxlength="12" /></td>
				</tr>
			</table>
			<p><input type="submit" name="login" value="einloggen"/></p>
		</form>';
	
		}
		$_SESSION['loginmessage']= '';
	
?>