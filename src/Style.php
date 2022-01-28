<?php

declare(strict_types=1);

namespace Authanram\LaravelConsoleStyle;

class Style
{
    private array $append = [];
    private array $prepend = [];
    private bool $bold = false;
    private bool $stripTags;
    private int $break = 0;
    private int $indent = 0;
    private int $newline = 0;
    private int $paddingX = 0;
    private int $paddingY = 0;
    private string $bg = 'default';
    private string $fg = 'default';

    public function __construct(private string $value, private $command)
    {
    }

    public function bold(): static
    {
        $this->bold = true;

        return $this;
    }

    public function break(int $count = 1): static
    {
        $this->break = $count;

        return $this;
    }

    public function bg(string $color, int $paddingX = 0, int $paddingY = 0): static
    {
        $this->bg = $color;

        $this->paddingX = $paddingX;

        $this->paddingY = $paddingY;

        return $this;
    }

    public function fg(string $color): static
    {
        $this->fg = $color;

        return $this;
    }

    public function newline(int $count = 1): static
    {
        $this->newline = $count;

        return $this;
    }

    public function indent(int $times = 1): static
    {
        $this->indent = $times;

        return $this;
    }

    public function error(): static
    {
        $this->bg = 'red';
        $this->fg = 'white';

        return $this;
    }

    public function cyan(): static
    {
        $this->fg = 'cyan';

        return $this;
    }

    public function red(): static
    {
        $this->fg = 'red';

        return $this;
    }

    public function green(): static
    {
        $this->fg = 'green';

        return $this;
    }

    public function gray(): static
    {
        $this->fg = 'gray';

        return $this;
    }

    public function white(): static
    {
        $this->fg = 'white';

        return $this;
    }

    public function yellow(): static
    {
        $this->fg = 'yellow';

        return $this;
    }

    public function label(): static
    {
        $this->fg = 'green';

        $this->indent = 1;

        $this->value .= ':';

        return $this;
    }

    public function title(): static
    {
        $this->bold = true;

        $this->fg = 'white';

        $this->indent = 1;

        $this->newline = 1;

        return $this;
    }

    public function paragraph(): static
    {
        $this->value = ' <fg=gray>▕</> '.$this->value;

        return $this;
    }

    public function prepend(self|string|null $value): static
    {
        if (is_null($value) === false || (is_string($value) && trim($value) === '')) {
            $this->prepend[] = (string)$value;
        }

        return $this;
    }

    public function append(self|string|null $value): static
    {
        if (is_null($value) === false || (is_string($value) && trim($value) === '')) {
            $this->append[] = (string)$value;
        }

        return $this;
    }

    public function note(?string $value): static
    {
        if (is_null($value) === false) {
            $this->append('<fg=gray>'.$value.'</>');
        }

        return $this;
    }

    public function stripTags(): static
    {
        $this->stripTags = true;

        return $this;
    }

    public function exit(int $exitCode = 0): int
    {
        $this->command->newline($this->break);

        $this->command->line($this->toString());

        $this->command->newline($this->newline);

        return $exitCode;
    }

    public function failure(): int
    {
        return $this->exit(1);
    }

    public function success(): int
    {
        return $this->exit();
    }

    public function toString(): string
    {
        $style = [];
        $style[] = $this->bold ? 'options=bold' : '';
        $style[] = $this->bg ? "bg=$this->bg" : '';
        $style[] = $this->fg ? "fg=$this->fg" : '';
        $style = array_filter($style);

        $paddingX = str_repeat(' ', $this->paddingX);

        $this->value = $paddingX.$this->value.$paddingX;

        $paddingY = str_repeat("\n", $this->paddingY);

        $this->value = $paddingY.$this->value.$paddingY;

        $this->value = '<'.implode(';', $style).'>'.$this->value.'</>';

        if (empty($this->prepend) === false) {
            $this->value = implode(' ', $this->prepend).' '.$this->value;
        }

        $this->value = str_repeat(' ', $this->indent).$this->value;

        if (empty($this->append) === false) {
            $this->value .= ' '.implode(' ', $this->append);
        }

        return $this->stripTags ? strip_tags(trim($this->value)) : $this->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
