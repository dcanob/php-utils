<?php

/**
 * App_ConfigFactory_Php
 *
 * @author nebiros
 */
class App_ConfigFactory_Php implements App_ConfigFactory_ConfigAdapterInterface {
    /**
     *
     * @var array
     */
    protected $_options = null;

    /**
     *
     * @param array $options
     */
    public function __construct($options = null) {
        $this->_options = $options;
    }

    /**
     *
     * @return array
     */
    public function getOptions() {
        return $this->_options;
    }

    /**
     *
     * @param string $file
     * @return array
     * @throws Exception 
     */
    public function read($file = null) {
        if (empty($file)) {
            $file = $this->_options["file"];
        }

        $tmp = $file;
        $file = realpath($tmp);
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (!is_file($file)) {
            throw new InvalidArgumentException("File '{$tmp}' not found");
        }

        if ($ext != "php") {
            throw new Exception("File '{$tmp}' must be a PHP file");
        }

        $php = require $file;
        if (empty($php)) {
            throw new Exception("There's not an explicit return in '{$tmp}'");
        }

        $section = $this->_options["section"];
        if (empty($section)) {
            $section = APPLICATION_ENV;
        }

        $env = $php[$section];
        if (empty($env)) {
            throw new Exception("Section '" . $section . "' not found in '{$tmp}'");
        }
        
        return $env;
    }
}
