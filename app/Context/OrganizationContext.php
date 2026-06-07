<?php

namespace App\Context;

use App\Models\Organization;

class OrganizationContext {

    protected static ?Organization $organization;

    public static function set(Organization $organization) {
        static::$organization = $organization;
    }

    public static function current(): ?Organization {
        return static::$organization;
    }

    public static function id(): ?int {
        return static::$organization?->id;
    }

    public static function clear(): void {
        static::$organization = null;
    }
}
