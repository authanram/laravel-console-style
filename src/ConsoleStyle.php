<?php

declare(strict_types=1);

namespace Authanram\LaravelConsoleStyle;

use Illuminate\Support\Stringable;

trait ConsoleStyle
{
    public function style(Stringable|string $value): Style
    {
        return new Style((string)$value, $this);
    }
}
