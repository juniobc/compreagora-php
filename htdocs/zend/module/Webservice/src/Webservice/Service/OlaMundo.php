<?php

namespace Application\Service;

class OlaMundo
{    
    /**
     * @return string
     */
    public function OlaMundo()
    {
        return "Olá Mundo";
    }
    
    /**
     * @return string
     */
    public function welcame($nome) {
        return "Ola $nome, Seja bem vindo ao WebServer";
    }    
}