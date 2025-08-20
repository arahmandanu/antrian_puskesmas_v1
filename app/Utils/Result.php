<?php

namespace App\Utils;

/**
 * @template T
 */
class Result
{
    /**
     * @var bool
     */
    private bool $success;

    /**
     * @var string|null
     */
    private ?string $message;

    /**
     * @var T|null
     */
    private $data;

    /**
     * Private constructor agar selalu pakai factory
     * @param bool $success
     * @param string|null $message
     * @param T|null $data
     */
    private function __construct(bool $success, ?string $message = null, $data = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @template U
     * @param U $data
     * @param string|null $message
     * @return Result<U>
     */
    public static function take($error = false, $data, ?string $message = null): self
    {
        if ($error) {
            return self::failure($message, $data);
        } else {
            return self::success($data, $message);
        }
    }

    /**
     * @template U
     * @param U $data
     * @param string|null $message
     * @return Result<U>
     */
    public static function success($data, ?string $message = null): self
    {
        return new self(true, $message, $data);
    }

    /**
     * @param string $message
     * @param T|null $data
     * @return Result<T>
     */
    public static function failure(string $message, $data = null): self
    {
        return new self(false, $message, $data);
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function isFailure(): bool
    {
        return !$this->success;
    }

    /**
     * @return T|null
     */
    public function getData()
    {
        return $this->data;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function toArray(): array
    {
        return [
            'error' => self::isFailure(),
            'success' => $this->success,
            'message' => $this->message,
            'data'    => $this->data,
        ];
    }
}
