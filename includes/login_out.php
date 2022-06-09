 <?php 
//wenn der user angemeldet ist, dann bekommt er ein div angezeigt =>du bist als bla angemeldet & link zum ausloggen
if(isset($_SESSION['aut_user'])){
	if(isset($_SESSION['login_error'])){
	 echo($_SESSION['login_error']);
	 unset($_SESSION['login_error']);
	}
	 echo("<div align=\"center\" width=\"90%\" style=\"border:4px solid #96B566; padding:10px 0; background-color:#333333; color:white;\">Du bist als: <br /><span style=\"color:#96B566; text-decoration:underline; \"> ".$_SESSION['aut_user']." </span><br />angemeldet<br /><br /><a href=\"logout.php\">Ausloggen</a></div>");
}
// wenn der user nicht angemeldet ist, 
else{
//wenn der user nicht berechtigt ist: dann wird message (nicht angemeldet fuer zugriff) ausgeprintet || bei fehlerhafter eingabe (falscher username/passwort)
	 if(isset($_SESSION['login_message'])){
	 echo($_SESSION['login_message']);
	 unset($_SESSION['login_message']);
	 }
	 if(isset($_SESSION['login_error'])){
	 echo($_SESSION['login_error']);
	 unset($_SESSION['login_error']);
	 }

?>
<br />
<!-- loginformular -->

<form action="auth.php" method="post">
<table>
<tr>
	<td>Username</td>
</tr>
<tr>
	<td><input type="text" name="username" size="20" maxlength="50" /></td>
</tr>
<tr>
	<td>Passwort</td>
</tr>
<tr>
	<td><input type="password" name="password" size="12" maxlength="12" /></td>
</tr>
</table>
<p><input type="submit" name="login" value="einloggen"/></p>
</form>
<?php } ?>