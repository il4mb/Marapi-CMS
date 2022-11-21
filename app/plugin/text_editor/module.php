<?php
namespace MarapiPlugin;

use classes\DOCUMENT;
use classes\PluginInterface;
use classes\UriManager;

class TextEditor implements PluginInterface {

    public function onPanel($document) {

        $menu = $document->getMenu();
        array_push($menu, "<a href='/mrp/text_editing'>Text editor</a>");

        $document->setMenu($menu);

        //$uriM = new UriManager();
        //$document->setDocument("<html><head></head><body><h1>hallo</h1></body></html>");

    }

    public function onFront($main) {
        
        echo "im in front <i>'print from plugin text editor'</i>";
    }
}

return new TextEditor();