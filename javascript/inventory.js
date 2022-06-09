//hier den absoluten Pfad zum Bidlerverzeichnis eintargen
bildpfad_absolut = 'http://127.0.0.1/blog_neu/images/';

//hier den Dateinamen der Popup-Datei eintragen
popupPhp = 'b_inventory.php';

function open_image_inventory()
{
	inventory = window.open(popupPhp,'netzwerkbilder','left=0,top=0,width=350,height=700,resizable,location=no,toolbar=no,status=no,inventories=no,menubar=no');
	inventory.focus();
}

function update_text(img_url)
{
	
	//alert(img_url);
	//var txtarea = document.getElementById('text');
	var txtarea = document.postform.text;
	var textende = (txtarea.value.substring((txtarea.value.length-5), txtarea.value.length));
	if (textende == "[img]" || textende == "left]")
	{
		var insertstring = bildpfad_absolut+img_url+'[/img]';
		txtarea.value += insertstring;
	}
}
