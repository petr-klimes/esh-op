<?php
$config['system']['env'] = 'devel';
//$config['system']['environment'] = 'production';
// nactu vsechny globalni itemy
foreach (glob('config/items/*.global.php') as $filename) {
    include_once $filename;
}

// a pak nactu ty dle env - ty muzou pripadne global prepsat 
foreach (glob('config/items/*.' . $config['system']['env'] . '.php') as $filename) {
    include_once $filename;
}


