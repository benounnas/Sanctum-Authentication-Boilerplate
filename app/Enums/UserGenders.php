<?php
namespace App\Enums;

enum UserGenders: string
{
    case MAN = 'MAN';
    case WOMAN = 'WOMAN';
    case  UNKNOWN = 'UNKNOWN';


    public function isMan(): bool
    {
        return match ($this){
            self::MAN => true,
            default => false
        };
    }

    public function isWoman(): bool
    {
        return match ($this){
            self::WOMAN => true,
            default => false
        };
    }


}
