<?php

class App_Form_Element_Select extends App_Form_Element_FormElementAbstract
{
    public function __construct($name, Array $options = null) {
        parent::__construct($name, $options);
    }

    public function build() {
        $value = "";
        if (is_string($this->_options["value"])) {
            $value = $this->_options["value"];
        }

        $this->_xhtml = <<<XHTML
            <div class="form-group clearfix">
            <label class="control-label">{$this->_options["element_label"]}</label>
            <select class="form-control html-select clearfix" name="{$this->_name}" value="{$value}">
                <option>--</option>
XHTML;

        $o = $this->_options['options'];

        foreach ($o as $option) {
            $selected = $option["element_option_id"] == $value ? "selected" : "";
            $this->_xhtml .= <<<XHTML
                    <option value="{$option["element_option_id"]}" {$selected} >
                        {$option["element_option_label"]}
                    </option>
XHTML;
        }

        $this->_xhtml .= " </select><span class='caret'></span></div>";

        return $this;
    }

    public function isValid(Array $data) {
        //validate if name exists in array
        if (array_key_exists($this->_name, $data)) {
            $optionsUser = $data[$this->_name];

            foreach ($optionsUser as $ou) {
                $key = array_key_exists($ou, $this->_options['options']);
                if ($key === false) {
                    $this->_message = $this->_options["element_label"] . ", option no valid";
                    return false;
                }
            }

            $this->_value=array($this->_options['element_id']=> array($optionsUser));
        } else {
            //check if it is required
            if ($this->_options['element_required']) {
                $this->_message = $this->_options["element_label"] . ", is required";
                return false;    
            }
        }
        return true;
    }
}