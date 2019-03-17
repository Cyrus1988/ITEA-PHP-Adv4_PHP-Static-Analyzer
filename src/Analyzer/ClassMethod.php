<?php

/*
 * This file is part of the "ClassCounter" package.
 *
 * (c) Alexey Kirichenko <Cyrus1988@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cyrus\ClassStat\Analyzer;

use Cyrus\ClassStat\PhpClassInfo;
use Symfony\Component\Finder\Finder;

class ClassMethod
{
    private $className;

    private const PUBLIC = 'public';
    private const ABSTRACT = 'abstract';
    private const FINAL = 'final';
    private const PROTECTED = 'protected';
    private const STATIC = 'static';


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

    public function __construct(string $className)
    {
        $this->className=$className;
    }

    public function getClassMethodCount(\ReflectionClass $reflector): void
    {
        $methods = $reflector->getMethods();

        foreach ($methods as $method) {
            $methodModificator = \implode(' ', \Reflection::getModifierNames($method->getModifiers())) . \PHP_EOL;

            $type = \trim($methodModificator);
            $array = \explode(' ', $type);

            foreach ($array as $type) {
                if (self::PUBLIC === $type) {
                    $this->methods['public']++;

                    if (\in_array(self::STATIC, $array)) {
                        $this->methods['public']++;
                        $this->methods['public-static']++;
                    }
                } elseif (self::PROTECTED === $type) {
                    $this->methods['protected']++;
                    $this->methods['protected-static']++;

                    if (\in_array(self::STATIC, $array)) {
                        $this->methods['protected']++;
                        $this->methods['protected-static']++;
                    }
                } elseif (self::PROTECTED === $type) {
                    $this->methods['private']++;
                }
            }
        }
    }

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

    public function getInfo()
    {
        $finder = Finder::create()
            ->in(__DIR__)
            ->files()
            ->name('/^[A-Z].+\.php$/')
            ;

        $className = '';
        $classType='';

        foreach ($finder as $file) {
            $namespace = PhpClassInfo::getFullClassName($file->getPathname());

            try {
                $reflector = new \ReflectionClass($namespace);
            } catch (\ReflectionException $e) {
                continue;
            }

            if ($this->className == $reflector->getShortName()) {
                $className = $reflector->getShortName();

                if ($reflector->isFinal()) {
                    $classType = self::FINAL;
                } elseif ($reflector->isAbstract()) {
                    $classType = self::ABSTRACT;
                } else {
                    $classType = self::PUBLIC;
                }

                $this->getClassMethodCount($reflector);
                $this->getClassPropertiesCount($reflector);
            }
        }

        $classInfo ="Class: $className is $classType" . \PHP_EOL .
                    'Properties:' . \PHP_EOL .
                        'public:' . $this->properties['public'] . ' (' . $this->properties['public-static'] . ' static)' . \PHP_EOL .
                        'protected:' . $this->properties['protected'] . \PHP_EOL .
                        'private:' . $this->properties['private'] . ' (' . $this->properties['private-static'] . ' static)' . \PHP_EOL .
                    'Methods:' . \PHP_EOL .
                        'public:' . $this->methods['public'] . ' (' . $this->methods['public-static'] . ' static)' . \PHP_EOL .
                        'protected:' . $this->methods['protected'] . ' (' . $this->methods['protected-static'] . ' static)' . \PHP_EOL .
                        'private:' . $this->methods['private'] . \PHP_EOL;

        return $classInfo;
    }
}
