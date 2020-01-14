<?php

declare(strict_types=1);

namespace Extrameile\EmSysNote\Domain\Model;

class SysNote
{
    public const SYS_NOTE_TYPE_DEFAULT = 0;
    public const SYS_NOTE_TYPE_INSTRUCTION = 1;
    public const SYS_NOTE_TYPE_TODO = 4;
    public const SYS_NOTE_TYPE_TEMPLATE = 2;
    public const SYS_NOTE_TYPE_NOTE = 3;
}
