<?php

namespace SiteStroy\Helpers;

class Validate
{
    private string $value = '';
    private array $rules = [];
    private string $error = '';
    public function require()
    {
        if(mb_strlen($this->value) === 0){
            $this->error = 'Обязательное поле';
        }
    }
}