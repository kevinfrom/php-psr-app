<?php
declare(strict_types=1);

namespace App;

interface ApplicationInterface
{
    /**
     * Run the application.
     *
     * @return void
     */
    public function run(): void;
}
