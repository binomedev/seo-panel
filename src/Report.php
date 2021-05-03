<?php


namespace Binomedev\SeoPanel;

class Report
{
    const SEVERITY_SUGGESTION = 'suggestion';
    const SEVERITY_LOW = 'low';
    const SEVERITY_MEDIUM = 'medium';
    const SEVERITY_HIGH = 'high';
    const SEVERITY_CRITICAL = 'critical';
    protected static array $allowedSeverities = [
        self::SEVERITY_SUGGESTION,
        self::SEVERITY_LOW,
        self::SEVERITY_MEDIUM,
        self::SEVERITY_HIGH,
        self::SEVERITY_CRITICAL,
    ];

    protected string $name;
    protected bool $status;
    protected ?string $message;
    protected ?string $help;
    protected array $meta = [];
    protected string $severity = 'low';

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

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public static function failed(string $name): static
    {
        return new static($name, status: false);
    }

    public static function passed(string $name): static
    {
        return new static($name, status: true);
    }

    public function severity(string $type = null): string | static
    {
        if (is_null($type)) {
            return $this->severity;
        }

        $this->checkIfSeverityAllowed($type);

        $this->severity = $type;

        return $this;
    }

    protected function checkIfSeverityAllowed($type)
    {
        $allowedTypes = static::$allowedSeverities;
        if (in_array($type, $allowedTypes)) {
            return;
        }

        $list = implode(', ', $allowedTypes);

        throw new \Exception('Severity type is not supported. It must be one of the following: ' . $list);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hasFailed(): bool
    {
        return ! $this->status;
    }

    public function hasPassed(): bool
    {
        return $this->status;
    }

    public function status(bool $passed): static
    {
        $this->status = $passed;

        return $this;
    }

    public function message(string $message = null): string | static
    {
        if (is_null($message)) {
            return $this->message;
        }

        $this->message = $message;

        return $this;
    }

    public function help(string $help = null): string | static
    {
        if (is_null($help)) {
            return $this->help;
        }

        $this->help = $help;

        return $this;
    }

    public function add(string $key, $value)
    {
        return $this->meta[$key] = $value;
    }

    public function meta(array $meta = null): array | static
    {
        if (is_null($meta)) {
            return $this->meta;
        }

        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }
}
