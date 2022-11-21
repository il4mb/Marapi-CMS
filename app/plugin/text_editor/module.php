<?php
/**
 * Copyright 2022 Ilham B
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
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