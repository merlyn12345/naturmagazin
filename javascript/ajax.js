


function Ajax() {
  //Eigenschaften deklarieren und initialisieren
  this.url="";
  this.params="";
  this.method="GET";
  this.onSuccess=null;
  this.onError=function (msg) {
    alert(msg)
  }
}

Ajax.prototype.doRequest=function() {
   if (!this.url) {
    this.onError("Es wurde kein URL angegeben. Der Request wird abgebrochen.");
    return false;
  }

  if (!this.method) {
    this.method="GET";
  } else {
    this.method=this.method.toUpperCase();
  }

  //Zugriff auf Klasse fr readyStateHandler ermglichen  
  var _this = this;
  
  //XMLHttpRequest-Objekt erstellen
  var xmlHttpRequest=getXMLHttpRequest();
  if (!xmlHttpRequest) {
    this.onError("Es konnte kein XMLHttpRequest-Objekt erstellt werden.");
    return false;
  }
  
  //Fallunterscheidung nach bertragungsmethode
  switch (this.method) {
    case "GET": xmlHttpRequest.open(this.method, this.url+"?"+this.params, true);
                xmlHttpRequest.onreadystatechange = readyStateHandler;
                xmlHttpRequest.send(null);
                break;
    case "POST": xmlHttpRequest.open(this.method, this.url, true);
                 xmlHttpRequest.onreadystatechange = readyStateHandler;
                 xmlHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                 xmlHttpRequest.send(this.params);
                 break;
  }  

  //Private Methode zur Verarbeitung der erhaltenen Daten
  function readyStateHandler() {
    if (xmlHttpRequest.readyState < 4) {
      return false;
    }
    if (xmlHttpRequest.status == 200 || xmlHttpRequest.status==304) {
      if (_this.onSuccess) {
        _this.onSuccess(xmlHttpRequest.responseText, xmlHttpRequest.responseXML);
      }
    } else {
      if (_this.onError) {
        _this.onError("["+xmlHttpRequest.status+" "+xmlHttpRequest.statusText+"] Es trat ein Fehler bei der Datenbertragung auf.");
      }
    }
  }
}

//Gibt browserunabhngig ein XMLHttpRequest-Objekt zurck
function getXMLHttpRequest() 
{
  if (window.XMLHttpRequest) {
    //XMLHttpRequest fr Firefox, Opera, Safari, ...
    return new XMLHttpRequest();
  } else 
  if (window.ActiveXObject) {
    try {   
      //XMLHTTP (neu) fr Internet Explorer 
      return new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
      try {        
        //XMLHTTP (alt) fr Internet Explorer
        return new ActiveXObject("Microsoft.XMLHTTP");  
      } catch (e) {
        return null;
      }
    }
  }
  return false;
}
