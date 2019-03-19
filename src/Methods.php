<?php

/*
 * This file is part of the "ClassCounter" package.
 *
 * (c) Alexey Kirichenko <Cyrus1988@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer;

class Methods
{
    private $publicMethod = 0;
    private $publicStaticMethod = 0;
    private $protectedMethod = 0;
    private $protectedStaticMethod = 0;
    private $privateMethod = 0;

    public function setPublicMethod()
    {
        $this->publicMethod++;
    }

    public function setPublicStaticMethod()
    {
        $this->publicStaticMethod++;
    }

    public function setProtectedMethod()
    {
        $this->protectedMethod++;
    }

    public function setProtectedStaticMethod()
    {
        $this->protectedStaticMethod++;
    }

    public function setPrivateMethod()
    {
        $this->privateMethod++;
    }

    public function getPublicMethod()
    {
        return $this->publicMethod;
    }

    public function getPublicStaticMethod()
    {
        return $this->publicStaticMethod;
    }

    public function getProtectedMethod()
    {
        return $this->protectedMethod;
    }

    public function getProtectedStaticMethod()
    {
        return $this->protectedStaticMethod;
    }

    public function getPrivateMethod()
    {
        return $this->privateMethod;
    }
}
