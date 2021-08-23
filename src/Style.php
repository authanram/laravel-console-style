<?php

declare(strict_types=1);

namespace Authanram\LaravelConsoleStyle;

class Style
{
    private array $__append = [];
    private bool $__bold = false;
    private bool $__output = false;
    private int $__break = 0;
    private int $__indent = 0;
    private int $__newline = 0;
    private string $__bg = 'default';
    private string $__fg = 'default';

    public function __construct(private string $value, private $command) {}

    public function bold(): self
    {
        $this->__bold = true;

        return $this;
    }

    public function break(int $count = 1): self
    {
        $this->__break = $count;

        return $this;
    }

    public function bg(string $color): self
    {
        $this->__bg = $color;

        return $this;
    }

    public function fg(string $color): self
    {
        $this->__fg = $color;

        return $this;
    }

    public function newline(int $count = 1): self
    {
        $this->__newline = $count;

        return $this;
    }

    public function indent(int $times = 1): self
    {
        $this->__indent = $times;

        return $this;
    }

    public function error(): self
    {
        $this->__bg = 'red';
        $this->__fg = 'white';

        return $this;
    }

    public function cyan(): self
    {
        $this->__fg = 'cyan';

        return $this;
    }

    public function red(): self
    {
        $this->__fg = 'red';

        return $this;
    }

    public function green(): self
    {
        $this->__fg = 'green';

        return $this;
    }

    public function white(): self
    {
        $this->__fg = 'white';

        return $this;
    }

    public function yellow(): self
    {
        $this->__fg = 'yellow';

        return $this;
    }

    public function label(): self
    {
        $this->__fg = 'green';

        $this->__indent = 1;

        $this->value .= ':';

        return $this;
    }

    public function title(): self
    {
        $this->__bold = true;

        $this->__fg = 'white';

        $this->__indent = 1;

        $this->__newline = 1;

        return $this;
    }

    public function paragraph(): self
    {
        $this->value = ' <fg=gray>▕</> '.$this->value;

        return $this;
    }

    public function append(string $value): self
    {
        $this->__append[] = $value;

        return $this;
    }

    public function getOutput(): string
    {
        $this->__output = true;

        $style = [];
        $style[] = $this->__bold ? 'options=bold' : '';
        $style[] = $this->__bg ? "bg=$this->__bg" : '';
        $style[] = $this->__fg ? "fg=$this->__fg" : '';
        $style = array_filter($style);

        $this->value = '<'.implode(';', $style).'>'.$this->value.'</>';

        $this->value = str_repeat(' ', $this->__indent).$this->value;

        if (empty($this->__append) === false) {
            $this->value .= ' '. implode(' ', $this->__append);
        }

        return $this->value;
    }

    public function output(): void
    {
        $this->command->newline($this->__break);

        $this->command->line($this->getOutput());

        $this->command->newline($this->__newline);
    }

    public function return(int $value = 0): int
    {
        $this->output();

        return $value;
    }

    public function __destruct()
    {
        if ($this->__output) {
            return;
        }

        $this->output();
    }
}
