<?php

namespace Threls\SnomedCTForLaravel\Enums;

enum DatabaseConnection: string
{
    case sqlite = 'SQLite';
    case mysql = 'MySql';
}
