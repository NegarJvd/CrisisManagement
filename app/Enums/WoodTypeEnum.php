<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum WoodTypeEnum:string
{
    use EnumTrait;
    case hard_wood = 'hard_wood';
    case soft_wood = 'soft_wood';
    case manufacture = 'manufacture';
}
