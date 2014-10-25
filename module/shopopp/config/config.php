<?php
$config['route']['homepage']['path'] = '/';
$config['route']['homepage']['controller'] = 'homepage';
$config['route']['homepage']['name'] = 'homepage';

$config['route']['product']['path'] = '/produkt/<product_category%s>/<product_name%s>';
$config['route']['product']['controller'] = 'product';
$config['route']['product']['name'] = 'product';

$config['route']['product']['path'] = '/kategorie/<category_name%s>';
$config['route']['product']['controller'] = 'category';
$config['route']['product']['name'] = 'category';

$config['route']['product']['path'] = '/hledat/<search_text%s>';
$config['route']['product']['controller'] = 'search';
$config['route']['product']['name'] = 'search';

$config['route']['basket']['path'] = '/basket';
$config['route']['basket']['controller'] = 'basket';
$config['route']['basket']['name'] = 'basket';

$config['route']['node']['path'] = '/node/<node_name%s>';
$config['route']['node']['controller'] = 'node';
$config['route']['node']['name'] = 'node';

$config['system']['lang'] = 'cz';

