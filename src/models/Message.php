<?php

class Message
{
    private $message;

    public function __construct($message = [])
    {
        $this->message = $message;
    }

    public function get()
    {
        return $this->message;
    }

    public function set($message)
    {
        $this->message = $message;
    }
}
