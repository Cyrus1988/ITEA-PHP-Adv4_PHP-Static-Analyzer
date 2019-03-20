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

class ClassMembersInfo
{
    private $publicMethod = 0;
    private $publicStaticMethod = 0;
    private $protectedMethod = 0;
    private $privateMethod = 0;
    private $privateStaticMethod = 0;

    public function incrementPublicMethod()
    {
        $this->publicMethod++;
    }

    public function incrementPublicStaticMethod()
    {
        $this->publicStaticMethod++;
    }

    public function incrementProtectedMethod()
    {
        $this->protectedMethod++;
    }


    public function incrementPrivateMethod()
    {
        $this->privateMethod++;
    }

    public function incrementPrivateStaticMethod()
    {
        $this->privateStaticMethod++;
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

    public function getPrivateMethod()
    {
        return $this->privateMethod;
    }

    public function getPrivateStaticMethod()
    {
        return $this->privateStaticMethod;
    }
}
