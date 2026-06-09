<?php

namespace App\Enums;


enum UserRole: string {
    case Admin = "admin";
    case Owner = "owner";
    case Manager = 'manager';
    case Technician = "technician";
    public function label(): string {
        return match ($this) {
            self::Admin => 'Admin',
            self::Owner => 'Owner',
            self::Manager => 'Manager',
            self::Technician => 'Technician',
        };
    }
}
