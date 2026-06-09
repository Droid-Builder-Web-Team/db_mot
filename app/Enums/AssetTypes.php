<?php

namespace App\Enums;

/**
 * Enum AssetTypes
 *
 * Represents the various categories of physical assets owned by the club.
 */
enum AssetTypes: string
{
    /** A pop-up display, stand, or tent. */
    case POPUP = 'popup';
    
    /** A promotional or informational banner. */
    case BANNER = 'banner';
    
    /** A branded tablecloth for event tables. */
    case TABLECLOTH = 'tablecloth';
    
    /** Props, backdrops, or structural scenery items. */
    case SCENERY = 'scenery';
    
    /** Any other miscellaneous asset. */
    case OTHER = 'other';
}
