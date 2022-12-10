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
 * 
 * - This file is part of /app/admin/index.php
 */

 $html = "";
switch($path[1]) {
    case "content" :

        $html = "<div class=\"input-group me-auto\">
        <input class='m-form' placeholder=\"search...\" style=\"width: unset;\"/>
        <button class='btn'><i class=\"ic-search\"></i></button>
    </div><a href='new/' class='btn text-primary bg-primary'><i class='ic-add'></i> Add</a>";
        break;
}

return $html;