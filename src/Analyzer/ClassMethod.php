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

use Greeflas\StaticAnalyzer\ClassMembersInfo;
use Greeflas\StaticAnalyzer\Properties;

class ClassMethod
{
    private const TYPE_PUBLIC = 'public';
    private const TYPE_ABSTRACT = 'abstract';
    private const TYPE_FINAL = 'final';
    private const TYPE_PROTECTED = 'protected';
    private const TYPE_STATIC = 'static';
    private const TYPE_PRIVATE = 'private';
    private const TYPE_DEFAULT = 'default';
    private $fullClassName;

    public function __construct(string $fullClassName)
    {
        $this->fullClassName= new \ReflectionClass($fullClassName);
    }

    /**
     * collect information about  class method
     *
     * @param \ReflectionClass $reflector
     * @param ClassMembersInfo $methodClass
     */
    private function getClassMethodCount(\ReflectionClass $reflector, ClassMembersInfo $methodClass): void
    {
        $methods = $reflector->getMethods();

        foreach ($methods as $method) {
            $methodModificator = \implode(' ', \Reflection::getModifierNames($method->getModifiers())) . \PHP_EOL;

            $type = \trim($methodModificator);
            $array = \explode(' ', $type);

            foreach ($array as $type) {
                if (self::TYPE_PUBLIC === $type) {
                    $methodClass->incrementPublicMethod();

                    if (\in_array(self::TYPE_STATIC, $array)) {
                        $methodClass->incrementPublicStaticMethod();
                    }
                } elseif (self::TYPE_PROTECTED === $type) {
                    $methodClass->incrementProtectedMethod();

                } elseif (self::TYPE_PRIVATE === $type) {
                    $methodClass->incrementPrivateMethod();

                    if (\in_array(self::TYPE_STATIC, $array)) {
                        $methodClass->incrementPrivateStaticMethod();
                    }
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
                $propertyClass->incrementPublicPropetry();

                if ($prop->isStatic()) {
                    $propertyClass->incrementPublicStaticPropetry();
                }
            } elseif ($prop->isProtected()) {
                $propertyClass->incrementProtectedPropetry();

                if ($prop->isStatic()) {
                    $propertyClass->incrementProtectedStaticPropetry();
                }
            } elseif ($prop->isPrivate()) {
                $propertyClass->incrementPrivatePropetry();
            }
        }
    }

    /**
     * collects information about the class, access modifiers and properties
     *
     * @param ClassMembersInfo $methodClass
     * @param Properties $propertyClass
     *
     * @return string
     */
    public function getInfo(ClassMembersInfo $methodClass, Properties $propertyClass): string
    {
        if ($this->fullClassName->isFinal()) {
            $classType = self::TYPE_FINAL;
        } elseif ($this->fullClassName->isAbstract()) {
            $classType = self::TYPE_ABSTRACT;
        } else {
            $classType = self::TYPE_DEFAULT;
        }

        $this->getClassMethodCount($this->fullClassName, $methodClass);
        $this->getClassPropertiesCount($this->fullClassName, $propertyClass);

        return $classType;
    }
}
