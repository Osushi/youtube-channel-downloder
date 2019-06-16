<?php

declare(strict_types=1);

namespace Logger\Shared;

class Client
{
    /**
     * @param string $message
     * @param array $params
     * @return void
     */
    public function stdout(
        string $message,
        array $params = []
    ): void {
        $text = $this->time() . $message;
        if (count($params)) {
            $text = $text . json_encode($params);
        }
        echo $text . "\n";
    }

    /**
     * @return string
     */
    private function time(): string
    {
        return '[' . date("Y-m-d H:i:s") . '] ';
    }
}
