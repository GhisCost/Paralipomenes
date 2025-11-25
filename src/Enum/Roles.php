<?php
namespace App\Enum;
enum Roles: string {

    case CONTRIBUTEUR ="Contributeur";
    case ADMINISTRATEUR ="Administrateur";
    case CORRECTEUR = "Correcteur";
}