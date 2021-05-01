<?php


namespace Binomedev\SeoPanel;


class Report
{
    protected string $name;
    protected bool $status;
    protected ?string $message;
    protected ?string $help;

    /**
     * Report constructor.
     * @param string $name
     * @param bool $status
     */
    public function __construct(string $name, bool $status = false)
    {
        $this->name = $name;
        $this->status = $status;
        $this->help = '';
        $this->message = '';
    }

    public function name()
    {
        return $this->name;
    }

    public function hasFailed(): bool
    {
        return !$this->status;
    }

    public function hasPassed(): bool
    {
        return $this->status;
    }

    public function status(bool $passed): Report
    {
        $this->status = $passed;

        return $this;
    }

    public function message(string $message = null): string|Report
    {
        if (is_null($message)) {
            return $this->message;
        }

        $this->message = $message;
        return $this;
    }

    public function help(string $help = null): string|Report
    {
        if (is_null($help)) {
            return $this->help;
        }

        $this->help = $help;

        return $this;
    }
}
