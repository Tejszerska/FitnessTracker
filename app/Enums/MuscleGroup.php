<?php

namespace App\Enums;

enum MuscleGroup: string
{
    case ARMS = 'Arms';
    case BACK = 'Back';
    case BICEPS = 'Biceps';
    case CALVES = 'Calves';
    case CHEST = 'Chest';
    case CORE = 'Core';
    case FOREARMS = 'Forearms'; // Dodane
    case FULL_BODY = 'Full Body';
    case GLUTES = 'Glutes';
    case HAMSTRINGS = 'Hamstrings';
    case LEGS = 'Legs';
    case QUADRICEPS = 'Quadriceps';
    case SHOULDERS = 'Shoulders';
    case TRICEPS = 'Triceps';
}
