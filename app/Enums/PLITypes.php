<?php

namespace App\Enums;

/**
 * Enum PLITypes
 *
 * Represents the different types of Public Liability Insurance (PLI)
 * a user can hold.
 */
enum PLITypes: int
{
    /** PLI provided internally through the club. */
    case Club = 0;
    
    /** PLI obtained through a third-party provider. */
    case ThirdParty = 1;

    /**
     * Get the human-readable label for the PLI type.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::Club => 'Club',
            self::ThirdParty => 'Third Party',
        };
    }
}
