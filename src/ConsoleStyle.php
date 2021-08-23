<?php

declare(strict_types=1);

namespace Authanram\LaravelConsoleStyle;

trait ConsoleStyle
{
    public function style(string $value): Style
    {
        return new Style($value, $this);
    }
}
