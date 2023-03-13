<?php

namespace Threls\SnomedCTForLaravel\Enums;

enum DescriptionType: int
{
    case FULLY_SPECIFIED_NAME = 900000000000003001;
    case SYNONYM = 900000000000013009;
    case DEFINITION = 900000000000550004;
}
