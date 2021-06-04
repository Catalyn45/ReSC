<?php

namespace MyApp\utils;

class Logger {
    private $file_name;

    public function __construct($file_name) {
        $this->file_name = $file_name;
    }

    public function log_info($msg) {
        $now = new \DateTime();
        echo '[' . $now->format('Y-m-d H:i:s') . "][INFO][{$this->file_name}] {$msg}\n";
    }

    public function log_error($msg) {
        $now = new \DateTime();
        echo '[' . $now->format('Y-m-d H:i:s') . "][ERROR][{$this->file_name}] {$msg}\n";
    }
}
