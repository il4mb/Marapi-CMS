<?php
namespace plugins;

use classes\PluginInterface;

class TextEditor implements PluginInterface {

    public function onPanel() {

        echo "panel";
    }

    public function onFront($main) {
        
        echo "im in front <i>'print from plugin text editor'</i>";
    }
}

return new TextEditor();