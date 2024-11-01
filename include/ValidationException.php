<?php

class ValidationException extends Exception
{

    protected $messages;

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     */
    public function setMessages($messages): self
    {
        $this->messages = $messages;
        return $this;
    }

}