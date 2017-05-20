<?php
namespace Components\Database\Schema;

require_once __DIR__.'/Integer.php';
require_once __DIR__.'/String.php';
require_once __DIR__.'/Timestamp.php';

class Field
{
    public $name;

    public $type;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __call($name,$arguments)
    {
        if ($name == 'default') {
            call_user_func_array([$this,'setDefault'],$arguments);
        }
    }

    public function integer($length)
    {
        $this->type = new Integer($length);

        return $this;
    }

    public function string()
    {
        $this->type = new String;

        return $this;
    }

    public function timestamp()
    {
        $this->type = new Timestamp;

        return $this;
    }

    public function increments()
    {
        $this->type->increments();

        return $this;
    }

    public function unique()
    {
        $this->type->unique();

        return $this;
    }

    public function setDefault($value)
    {
        $this->type->default($value);
    }
}