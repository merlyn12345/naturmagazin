<?php
#Beispielklasse mache format
class mache_format {
	public $text;
	public $datei;
	protected $dateiinhalt;

	function __construct()
	{
		$this->tpl_vars = array();
	}
	function lese_datei($datei)
	{
		// gibt es die Datei?
		if (!is_file($datei))
		{
			die('mache_format - lese_datei "' . $datei . '" Datei existiert nicht.');
		}
		$this->dateiinhalt = file_get_contents($datei);
	}
	function assign($var_array)
	{
		// Must be an array...
		if (!is_array($var_array))
		{
			die('template->assign() - Kein Array.');
		}
		$this->tpl_vars = array_merge($this->tpl_vars, $var_array);
	}
	
	function parse() {
	    	if (empty($this->dateiinhalt))
		{
			die('mache_format - fett:datei nicht gelesen');
		}
	
		foreach ($this->tpl_vars AS $key => $content)
		{
			$this->dateiinhalt = str_replace('{' . $key . '}', $content, $this->dateiinhalt);
		}
		return $this->dateiinhalt;
	}
		


	
}

?>