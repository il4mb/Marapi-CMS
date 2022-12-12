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

namespace module;

class shortCode
{

    public $codes = [], $onRenderHandler = [];

    public function analyze($html)
    {

        preg_match_all('/(?<=\{)[A-Z_]+(?=\})/', $html, $codes);

        $this->codes = array_merge($this->codes, $codes[0]);
    }

    public function addShortCode($code) {
        
        array_push($this->codes, $code);
    }

    public function addOnRender($handler)
    {

        array_push($this->onRenderHandler, $handler);
    }

    /**
     * @param String $html Html string
     * @param Bool $clear if enabled will clear all if some shortcode has no replaced
     */
    public function render($html, $clear = true)
    {

        foreach ($this->onRenderHandler as $handler) {

            if (gettype($handler) == "object")
                foreach ($this->codes as $code) {

                    $response = $handler($code);
                    if ($clear) {
                        $html = str_replace("{" . strtoupper($code) . "}", $response, $html);
                    } else {
                        if (strlen($response) > 0) {
                            $html = str_replace("{" . strtoupper($code) . "}", $response, $html);
                        }
                    }
                }
        }

        return $html;
    }
}
