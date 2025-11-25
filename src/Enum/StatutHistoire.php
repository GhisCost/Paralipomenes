<?php
namespace App\Enum;
enum StatutHistoire: string {
    case ENCOURS ="En cours de redaction";
    case CORRECTION = "En correction";
    case PUBLIER = "Publié";
}