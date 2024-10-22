<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum JointTypeEnum:string
{
    use EnumTrait;
    case pegged_mortise_and_tenon = 'pegged_mortise_and_tenon';
//    case splice_joint = 'splice_joint';
    case scarf_joint = 'scarf_joint';
//    case finger_joint = 'finger_joint';
    case tenon_joint = 'tenon_joint';
    case gooseneck_joint = 'gooseneck_joint';
}
