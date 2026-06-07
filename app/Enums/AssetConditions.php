<?php

namespace App\Enums;

/**
 * Enum AssetConditions
 *
 * Represents the physical condition of an asset owned by the club.
 */
enum AssetConditions: string
{
    /** The asset is completely new and unused. */
    case NEW = 'new';
    
    /** The asset is in good working condition. */
    case GOOD = 'good';
    
    /** The asset shows signs of wear but is still usable. */
    case WORN = 'worn';
    
    /** The asset is damaged and may need repair. */
    case DAMAGED = 'damaged';
    
    /** The asset is no longer fit for use and has been retired. */
    case RETIRED = 'retired';
}
