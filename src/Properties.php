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

class Properties
{
    private $publicPropetry = 0;
    private $publicStaticPropetry = 0;
    private $protectedPropetry = 0;
    private $privatePropetry = 0;
    private $privateStaticPropetry = 0;

    public function setPublicPropetry()
    {
        $this->publicPropetry++;
    }

    public function setPublicStaticPropetry()
    {
        $this->publicStaticPropetry++;
    }

    public function setProtectedPropetry()
    {
        $this->protectedPropetry++;
    }


    public function setPrivatePropetry()
    {
        $this->privatePropetry++;
    }

    public function setPrivateStaticPropetry()
    {
        $this->privateStaticPropetry++;
    }

    public function getPublicPropetry()
    {
        return $this->publicPropetry;
    }

    public function getPublicStaticPropetry()
    {
        return $this->publicStaticPropetry;
    }

    public function getProtectedPropetry()
    {
        return $this->protectedPropetry;
    }

    public function getPrivatePropetry()
    {
        return $this->privatePropetry;
    }

    public function getPrivateStaticPropetry()
    {
        return $this->privateStaticPropetry;
    }
}
