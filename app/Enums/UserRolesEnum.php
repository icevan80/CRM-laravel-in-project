<?php

namespace App\Enums;

enum UserRolesEnum: int
{
    case Admin = 1;
    case Employee = 2;
    case Customer = 3;
    case Partner = 4;
    case Master = 5;
    case Manager = 6;
    case Director = 7;
    case MasterManager = 10;
}
