<?php

namespace App\Services;

class CodeBreakerService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function generate(): array
    {
        $secretCode = $this->generateSecretCode();

        return [
            'attempts_left' => 15,
            'hints' => $this->generateHints($secretCode),
            'result' => 'Start Guessing',
            'guess_history' => [],
            'secret_code' => $secretCode,
        ];
    }

    private function generateSecretCode(): string
    {
        $code = '';

        while (strlen($code) < 3) {
            $digit = (string) random_int(0, 9);

            if (!str_contains($code, $digit)) {
                $code .= $digit;
            }
        }

        return $code;
    }

    private function generateHints(string $code): array
    {
        $first = (int) $code[0];
        $second = (int) $code[1];
        $third = (int) $code[2];

        $hints = [];

        // Greater / Smaller
        $hints[] = ((int) $code > 500)
            ? 'Number is greater than 500'
            : 'Number is smaller than 500';

        // First digit
        $hints[] = ($first % 2 === 0)
            ? 'First digit is even'
            : 'First digit is odd';

        // Last digit
        $hints[] = ($third < 5)
            ? 'Last digit is smaller than 5'
            : 'Last digit is 5 or greater';

        // Odd count
        $oddCount = collect([$first, $second, $third])
            ->filter(fn ($digit) => $digit % 2 !== 0)
            ->count();

        $hints[] = "{$oddCount} odd digits present";

        return $hints;
    }
}
