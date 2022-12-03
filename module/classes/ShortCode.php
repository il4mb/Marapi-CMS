<?php

namespace module;

class shortCode
{

    public $codes = [], $onRenderHandler = [];

    public function analyze($html)
    {

        preg_match_all('/(?<=\{)[A-Z_]+(?=\})/', $html, $codes);

        $this->codes = array_merge($this->codes, $codes[0]);
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
