<?php

/**
 *
 * @author nebiros
 */
class App_FilterFactory {
    /**
     *
     * @param string $class
     * @param array $options
     * @return App_Filter_Input 
     */
    public static function inputFactory($class, Array $options = array()) {
        $klass = "App_Filter_Input_" . ucfirst($class);

        if (!class_exists($klass)) {
            throw new InvalidArgumentException("filter input class '{$class}' not found");
        }

        $input = new $klass($options["data"], $options["options"]);
        return $input;
    }
}