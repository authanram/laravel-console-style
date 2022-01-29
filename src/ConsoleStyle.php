<?php

declare(strict_types=1);

namespace Authanram\LaravelConsoleStyle;

use Illuminate\Support\Stringable;

trait ConsoleStyle
{
    public function style(Stringable|Style|string|null $value = null): Style
    {
        return new Style(is_null($value) ? $value : (string)$value, $this);
    }
}
