<?php
declare(strict_types=1);

namespace App\Container\Exceptions;

use Exception;
use Psr\Container\ContainerExceptionInterface;

final class ContainerException extends Exception implements ContainerExceptionInterface
{
}
