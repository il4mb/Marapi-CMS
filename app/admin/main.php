<?php

use classes\UriManager;

$conf = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/.json"), true);
$uriManager = new UriManager();

$menus = [
    [
        "dashboard"
    ],
    "hr",
    [
        'content'
    ],
    [
        'PAGE'
    ],
    [
        'MENU'
    ],
    'hr',
    [
        'THEME'
    ],
    [
        'PLUGIN'
    ],
    [
        'USERS'
    ],
    'hr',
    [
        'SETTING'
    ]
];


$menu = '';
foreach ($menus as $key => $item) {

    if (gettype($item) == 'array') {
        $menu .= "<a href='/mrp/" . strtolower(preg_replace('/[^a-z0-0]+/siU', "-", $item[0])) . "'>" . strtoupper($item[0]) . "</a>";
    } else $menu .= "<hr/>";
}




print $menu . "Hallo";
