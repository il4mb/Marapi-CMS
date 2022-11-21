<?php

use classes\Plugin;

$key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_NUMBER_INT);
$plugins = Plugin::getListPlugin();

if (isset($_POST['type'])) {

    $type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);
    /**
     * @var Plugin $plugin Plugin object
     */
    $plugin = null;

    if (array_key_exists($key, $plugins)) {
        $plugin = $plugins[$key];
    } else return;


    if (0 == strcmp(strtolower($type), "switch")) {

        if ($plugin->is_active()) {
            $plugin->setInactive();

            echo "0";
        } else {

            $plugin->setActive();

            echo "1";
        }
    } else 
    if (0 == strcmp(strtolower($type), "delete")) {

        $plugin->delete();
    }

    exit;
}

if ($key != null) {


    if (array_key_exists($key, $plugins)) {

        echo json_encode($plugins[$key]);
    }
}
