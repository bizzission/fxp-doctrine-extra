<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DoctrineExtra\Exception;

/**
 * Base UnexpectedRepositoryException for the doctrine extra.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class UnexpectedRepositoryException extends InvalidArgumentException
{
    /**
     * Create the exception.
     *
     * @param string $class           The object class managed by doctrine
     * @param string $repositoryClass The required repository class
     *
     * @return UnexpectedRepositoryException
     */
    public static function create(string $class, string $repositoryClass): UnexpectedRepositoryException
    {
        $msg = sprintf('The doctrine repository of the "%s" class is not an instance of the "%s"', $class, $repositoryClass);

        return new self($msg);
    }
}
