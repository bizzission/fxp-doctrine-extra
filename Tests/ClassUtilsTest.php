<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DoctrineExtra\Tests\Util
{
    use Fxp\Component\DoctrineExtra\Util\ClassUtils;
    use PHPUnit\Framework\TestCase;

    /**
     * Class related functionality for objects that might or not be proxy objects at the moment.
     *
     * @author François Pluchino <francois.pluchino@gmail.com>
     */
    class ClassUtilsTest extends TestCase
    {
        public static function dataGetClass()
        {
            return [
                [\stdClass::class, \stdClass::class],
                [ClassUtils::class, ClassUtils::class],
                ['MyProject\Proxies\__CG__\stdClass', \stdClass::class],
                ['MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass', \stdClass::class],
                ['MyProject\Proxies\__CG__\Fxp\Component\DoctrineExtra\Tests\Util\ChildObject', ChildObject::class],
            ];
        }

        /**
         * @dataProvider dataGetClass
         *
         * @param string $className
         * @param string $expectedClassName
         */
        public function testGetRealClass($className, $expectedClassName)
        {
            self::assertEquals($expectedClassName, ClassUtils::getRealClass($className));
        }

        /**
         * @dataProvider dataGetClass
         *
         * @param string $className
         * @param string $expectedClassName
         */
        public function testGetClass($className, $expectedClassName)
        {
            $object = new $className();
            self::assertEquals($expectedClassName, ClassUtils::getClass($object));
        }
    }

    class ChildObject extends \stdClass
    {
    }
}

namespace MyProject\Proxies\__CG__
{
    class stdClass extends \stdClass
    {
    }
}

namespace MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__
{
    class stdClass extends \stdClass
    {
    }
}

namespace MyProject\Proxies\__CG__\Fxp\Component\DoctrineExtra\Tests\Util
{
    class ChildObject extends \stdClass
    {
    }
}
