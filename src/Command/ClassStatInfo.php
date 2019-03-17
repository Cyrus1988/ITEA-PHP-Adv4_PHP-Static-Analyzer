<?php

/*
 * This file is part of the "ClassCounter" package.
 *
 * (c) Alexey Kirichenko <Cyrus1988@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cyrus\ClassStat\Command;

use Cyrus\ClassStat\Analyzer\ClassMethod;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClassStatInfo extends Command
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('class-stat')
            ->setDescription('Show statistic about class')
            ->addArgument(
                'className',
                InputArgument::REQUIRED,
                'Name of class'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $className = $input->getArgument('className');

        $analyzer = new ClassMethod($className);
        $result = $analyzer->getInfo();

        $output->writeln($result);
    }
}
