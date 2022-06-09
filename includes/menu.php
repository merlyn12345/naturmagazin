<?php
// an nutzergruppen angepasstes menue
if(isset($_SESSION['aut_user'])){
	if($_SESSION['rolle'] == 'user'){
		$menu="<ul id=\"menue\"><li id=\"visit\"><a href=\"index.php\">Startseite</a></li><li id=\"active\"><a href=\"categories.php\">Kategorien</a><ul id=\"sub_menue\"><li><a href=\"cat_allg.php\">Allgemein</a></li><li><a href=\"cat_comp.php\">Computer</a></li><li><a href=\"cat_tipps.php\">Tipps</a></li><li><a href=\"cat_links.php\">Links</a></li></ul><li><a href=\"new_post.php\">Neuer Beitrag</a></li><li id=\"active\"><a href=\"user_home.php\">Meine Seite</a><ul id=\"sub_menue\"><li><a href=\"user_posts.php\">Meine Beitr&auml;ge</a></li></ul></li>";
	}
	elseif($_SESSION['rolle'] == 'admin'){
		$menu="<ul id=\"menue\"><li id=\"visit\"><a href=\"index.php\">Startseite</a></li><li id=\"active\"><a href=\"categories.php\">Kategorien</a><ul id=\"sub_menue\"><li><a href=\"cat_allg.php\">Allgemein</a></li><li><a href=\"cat_comp.php\">Computer</a></li><li><a href=\"cat_tipps.php\">Tipps</a></li><li><a href=\"cat_links.php\">Links</a></li></ul><li><a href=\"new_post.php\">Neuer Beitrag</a></li><li id=\"active\"><a href=\"user_home.php\">Meine Seite</a><ul id=\"sub_menue\"></li><li><a href=\"user_posts.php\">Meine Beitr&auml;ge</a></li></ul></li><li id=\"active\"><a href=\"admin_uebersicht.php\">Adminbereich</a><ul id=\"sub_menue\"><li><a href=\"admin_user.php\">Userverwaltung</a></li><li><a href=\"admin_posts.php\">Beitr&auml;ge</a></li></ul></li>";
	}
	else{
		$menu="<ul id=\"menue\"><li id=\"visit\"><a href=\"index.php\">Startseite</a></li><li><a href=\"categories.php\">Kategorien</a><ul id=\"sub_menue\"><li><a href=\"cat_allg.php\">Allgemein</a></li><li><a href=\"cat_comp.php\">Computer</a></li><li><a href=\"cat_tipps.php\">Tipps</a></li><li><a href=\"cat_links.php\">Links</a></li></ul></li><li><a href=\"regi.php\">Registrierung</a></li>";
	}
}
else{
									$menu="<ul id=\"menue\"><li id=\"visit\"><a href=\"index.php\">Startseite</a></li><li><a href=\"categories.php\">Kategorien</a><ul id=\"sub_menue\"><li><a href=\"cat_allg.php\">Allgemein</a></li><li><a href=\"cat_comp.php\">Computer</a></li><li><a href=\"cat_tipps.php\">Tipps</a></li><li><a href=\"cat_links.php\">Links</a></li></ul></li><li><a href=\"regi.php\">Registrierung</a></li>";
}
?>