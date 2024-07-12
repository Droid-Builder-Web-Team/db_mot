<?php

namespace App\Enums;

enum AssetConditions: string
{
   case NEW = 'new';
   case GOOD = 'good';
   case WORN = 'worn';
   case DAMAGED = 'damaged';
   case RETIRED = 'retired';
}