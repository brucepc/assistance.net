<?php

$str = [ 're', 're:','re (1):', 're(2):' ];
$matches = preg_replace_callback('/^re(\s*\((\d+)\))?:/i', function($m) { return (count($m) == 1 ? 're (1):' : 're (' . ($m[2] + 1) . '):'); }, $str);
var_dump($matches);

?>
