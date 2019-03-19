<?php

/*
 * This file is part of the "ClassCounter" package.
 *
 * (c) Alexey Kirichenko <Cyrus1988@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Analyzer;

use Greeflas\StaticAnalyzer\Methods;
use Greeflas\StaticAnalyzer\Properties;

class ClassMethod
{
    private const TYPE_PUBLIC = 'public';
    private const TYPE_ABSTRACT = 'abstract';
    private const TYPE_FINAL = 'final';
    private const TYPE_PROTECTED = 'protected';
    private const TYPE_STATIC = 'static';
    private const TYPE_PRIVATE = 'private';
    private $fullClassName;

    public function __construct(string $fullClassName)
    {
        $this->fullClassName= new \ReflectionClass($fullClassName);
    }

    /**
     * collect information about  class method
     *
     * @param \ReflectionClass $reflector
     * @param Methods $methodClass
     */
    private function getClassMethodCount(\ReflectionClass $reflector, Methods $methodClass): void
    {
        $methods = $reflector->getMethods();

        foreach ($methods as $method) {
            $methodModificator = \implode(' ', \Reflection::getModifierNames($method->getModifiers())) . \PHP_EOL;

            $type = \trim($methodModificator);
            $array = \explode(' ', $type);

            foreach ($array as $type) {
                if (self::TYPE_PUBLIC === $type) {
                    $methodClass->setPublicMethod();

                    if (\in_array(self::TYPE_STATIC, $array)) {
                        $methodClass->setPublicStaticMethod();
                    }
                } elseif (self::TYPE_PROTECTED === $type) {
                    $methodClass->setProtectedMethod();

                    if (\in_array(self::TYPE_STATIC, $array)) {
                        $methodClass->setProtectedStaticMethod();
                    }
                } elseif (self::TYPE_PRIVATE === $type) {
                    $methodClass->setPrivateMethod();
                }
            }
        }
    }



    /**
     * collect information about class properties
     *
     * @param \ReflectionClass $reflector
     * @param Properties $propertyClass
     */
    private function getClassPropertiesCount(\ReflectionClass $reflector, Properties $propertyClass): void
    {
        $properties = $reflector->getProperties();

        foreach ($properties as $prop) {
            if ($prop->isPublic()) {
                $propertyClass->setPublicPropetry();

                if ($prop->isStatic()) {
                    $propertyClass->setPublicStaticPropetry();
                }
            } elseif ($prop->isProtected()) {
                $propertyClass->setProtectedPropetry();
            } elseif ($prop->isPrivate()) {
                $propertyClass->setPrivatePropetry();

                if ($prop->isStatic()) {
                    $propertyClass->setPrivateStaticPropetry();
                }
            }
        }
    }

    /**
     * collects information about the class, access modifiers and properties
     *
     * @param Methods $methodClass
     * @param Properties $propertyClass
     *
     * @return string
     */
    public function getInfo(Methods $methodClass, Properties $propertyClass): string
    {
        if ($this->fullClassName->isFinal()) {
            $classType = self::TYPE_FINAL;
        } elseif ($this->fullClassName->isAbstract()) {
            $classType = self::TYPE_ABSTRACT;
        } else {
            $classType = self::TYPE_PUBLIC;
        }

        $this->getClassMethodCount($this->fullClassName, $methodClass);
        $this->getClassPropertiesCount($this->fullClassName, $propertyClass);

        return $classType;
    }
}
