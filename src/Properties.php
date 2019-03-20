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
    private $protectedStaticPropetry = 0;
    private $privatePropetry = 0;

    public function incrementPublicPropetry()
    {
        $this->publicPropetry++;
    }

    public function incrementPublicStaticPropetry()
    {
        $this->publicStaticPropetry++;
    }

    public function incrementProtectedPropetry()
    {
        $this->protectedPropetry++;
    }

    public function incrementProtectedStaticPropetry()
    {
        $this->protectedStaticPropetry++;
    }

    public function incrementPrivatePropetry()
    {
        $this->privatePropetry++;
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

    public function getProtectedStaticPropetry()
    {
        return $this->protectedStaticPropetry;
    }

    public function getPrivatePropetry()
    {
        return $this->privatePropetry;
    }

}
