<?php

namespace App\Enums;

enum AssetTypes: string
{
    case POPUP = 'popup';
    case BANNER = 'banner';
    case TABLECLOTH = 'tablecloth';
    case SCENERY = 'scenery';
    case OTHER = 'other';
}
