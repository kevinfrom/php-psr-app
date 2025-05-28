<?php
declare(strict_types=1);

namespace App\Container\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

final class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}
