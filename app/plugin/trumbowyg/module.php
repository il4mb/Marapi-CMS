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

use classes\PluginInterface;
use classes\UriManager;

class module implements PluginInterface
{

    public function onPanel($document)
    {

        $uriManager = new UriManager();
        $path = $uriManager->getPath();

        if (array_key_exists(1, $path) 
            && array_key_exists(2, $path) 
            && $path[1] == "content" 
            && $path[2] == "new") {

            $document->head .= "
            \n<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.26.0/ui/trumbowyg.min.css\" integrity=\"sha512-Zi7Hb6P4D2nWzFhzFeyk4hzWxBu/dttyPIw/ZqvtIkxpe/oCAYXs7+tjVhIDASEJiU3lwSkAZ9szA3ss3W0Vug==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\" />
            \n<script src=\"https://code.jquery.com/jquery-3.6.1.min.js\" integrity=\"sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=\" crossorigin=\"anonymous\"></script>
            \n<script src=\"https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.26.0/trumbowyg.min.js\" integrity=\"sha512-ZfWLe+ZoWpbVvORQllwYHfi9jNHUMvXR4QhjL1I6IRPXkab2Rquag6R0Sc1SWUYTj20yPEVqmvCVkxLsDC3CRQ==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"></script>";

            
            $document->body .= "<script>".file_get_contents(__DIR__."/script.js")."</script>";

        }

        
        //   $menu["text_editing"]= "<a {ATTR} href='/mrp/text_editing'>Text editor</a>";


        //$uriM = new UriManager();
        //$document->setDocument("<html><head></head><body><h1>hallo</h1></body></html>");

    }

    public function onFront($main)
    {

        //echo "SAYA AKTIV";
        // echo "im in front <i>'print from plugin text editor'</i>";
    }
}

return new module();
