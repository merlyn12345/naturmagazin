<li><a href="index.php">Startseite</a></li>
<li><a href="regi.php">Registrieren</a></li>
<?php
if(isset($_SESSION['rollenbeschreibung']) && in_array('user', $_SESSION['rollenbeschreibung'])){
?>
	<li><a href="new_post.php">Neuer Post</a></li>	
	<li><a href="user_home.php">Home</a></li>
<?php
}
if(isset($_SESSION['rollenbeschreibung']) && in_array('admin', $_SESSION['rollenbeschreibung'])){
?>
	<li><a href="index_admin.php">Admin</a></li>
<?php
}

?>