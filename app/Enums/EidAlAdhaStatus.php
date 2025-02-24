<?php

namespace App\Enums;

enum EidAlAdhaStatus: string
{
    case BENEFIT = 'benefit';

    case BENEFACTOR = 'benefactor';

    case SACRIFICED = 'sacrificed';

    case MEAT = 'meat';

    case DONT_BENEFIT = 'dont_benefit';
}
