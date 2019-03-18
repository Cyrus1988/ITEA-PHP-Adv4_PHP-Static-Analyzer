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

use Greeflas\StaticAnalyzer\PhpClassInfo;
use Symfony\Component\Finder\Finder;

class ClassMethod
{
    public $methods = [
        'public' => 0,
        'public-static' => 0,
        'protected' => 0,
        'protected-static' => 0,
        'private' => 0,
    ];

    public $properties = [
        'public' => 0,
        'public-static' => 0,
        'protected' => 0,
        'private' => 0,
        'private-static' => 0,
    ];

    private const TYPE_PUBLIC = 'public';
    private const TYPE_ABSTRACT = 'abstract';
    private const TYPE_FINAL = 'final';
    private const TYPE_PROTECTED = 'protected';
    private const TYPE_STATIC = 'static';
    private const TYPE_PRIVATE = 'private';
    private $fullClassName;

    public function __construct(string $fullClassName)
    {
        $this->fullClassName=$fullClassName;
    }

    /**
     * collect information about  class method
     *
     * @param \ReflectionClass $reflector
     */
    public function getClassMethodCount(\ReflectionClass $reflector): void
    {
        $methods = $reflector->getMethods();

        foreach ($methods as $method) {
            $methodModificator = \implode(' ', \Reflection::getModifierNames($method->getModifiers())) . \PHP_EOL;

            $type = \trim($methodModificator);
            $array = \explode(' ', $type);

            foreach ($array as $type) {
                if (self::TYPE_PUBLIC === $type) {
                    $this->methods['public']++;

                    if (\in_array(self::TYPE_STATIC, $array)) {
                        $this->methods['public-static']++;
                    }
                } elseif (self::TYPE_PROTECTED === $type) {
                    $this->methods['protected']++;

                    if (\in_array(self::TYPE_STATIC, $array)) {
                        $this->methods['protected-static']++;
                    }
                } elseif (self::TYPE_PRIVATE === $type) {
                    $this->methods['private']++;
                }
            }
        }
    }

    /**
     * collect information about class properties
     *
     * @param \ReflectionClass $reflector
     */
    public function getClassPropertiesCount(\ReflectionClass $reflector): void
    {
        $properties = $reflector->getProperties();

        foreach ($properties as $prop) {
            if ($prop->isPublic()) {
                $this->properties['public']++;

                if ($prop->isStatic()) {
                    $this->properties['public-static']++;
                }
            } elseif ($prop->isProtected()) {
                $this->properties['protected']++;
            } elseif ($prop->isPrivate()) {
                $this->properties['private']++;

                if ($prop->isStatic()) {
                    $this->properties['private-static']++;
                }
            }
        }
    }

    /**
     * collects information about the class, access modifiers and properties
     *
     * @return string
     */
    public function getInfo(): string
    {
        $finder = Finder::create()
            ->in(__DIR__)
            ->files()
            ->name('/^[A-Z].+\.php$/')
            ;

        $classType='';

        foreach ($finder as $file) {
            $namespace = PhpClassInfo::getFullClassName($file->getPathname());
            try {
                $reflector = new \ReflectionClass($namespace);
            } catch (\ReflectionException $e) {
                continue;
            }
            if ($this->fullClassName == $reflector->getShortName()) {
                if ($reflector->isFinal()) {
                    $classType = self::TYPE_FINAL;
                } elseif ($reflector->isAbstract()) {
                    $classType = self::TYPE_ABSTRACT;
                } else {
                    $classType = self::TYPE_PUBLIC;
                }

                $this->getClassMethodCount($reflector);
                $this->getClassPropertiesCount($reflector);
            }
        }

        return $classType;
    }
}
