<?php
/**
 * Plugin Interface Marapi
 * @author @ilh4mb
 */
namespace classes;

interface PluginInterface {

    /**
     * Description onPanel()
     * plugin will call in admin panel or private area
     * - you can print anything here
     */
    public function onPanel();

    /**
     * Description onFront()
     * plugin will call in website or public area
     * - dont print any sensitive while use this method
     * @param Main $main - Main Object
     */
    public function onFront($main);

}