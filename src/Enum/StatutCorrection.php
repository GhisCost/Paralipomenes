<?php
namespace App\Enum;
enum StatutCorrection: string {
    case ENCOURS = "En cours de correction";
    case ATTENTE = "En attente de validation";
    case TERMINER = "Terminer";
}