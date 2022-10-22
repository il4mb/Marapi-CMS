<?php
/**
 * @author ILHAMB <durianbohong@gmail.com>
 */
require_once __DIR__."/module/init.php";

use classes\UriManager;
use classes\Main;

$uriM = new UriManager();
//print_r($uriM->in_array());
$main = new Main();

//echo $main->theme->params['@name'];