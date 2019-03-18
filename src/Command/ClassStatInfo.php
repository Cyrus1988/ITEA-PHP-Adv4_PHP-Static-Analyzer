<?php

/*
 * This file is part of the "ClassCounter" package.
 *
 * (c) Alexey Kirichenko <Cyrus1988@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Command;

use Greeflas\StaticAnalyzer\Analyzer\ClassMethod;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClassStatInfo, get filename and show info about file\Class
 */
class ClassStatInfo extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('class-stat')
            ->setDescription('Show statistic about class')
            ->addArgument(
                'fullClassName',
                InputArgument::REQUIRED,
                'Name of class'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $className = $input->getArgument('fullClassName');

        $analyzer = new ClassMethod($className);
        $result = $analyzer->getInfo();

        $output->writeln(
            "Class: $className is $result" . \PHP_EOL .
            'Properties:' . \PHP_EOL .
            'public:' . $analyzer->properties['public'] . ' (' . $analyzer->properties['public-static'] . ' static)' . \PHP_EOL .
            'protected:' . $analyzer->properties['protected'] . \PHP_EOL .
            'private:' . $analyzer->properties['private'] . ' (' . $analyzer->properties['private-static'] . ' static)' . \PHP_EOL .
            'Methods:' . \PHP_EOL .
            'public:' . $analyzer->methods['public'] . ' (' . $analyzer->methods['public-static'] . ' static)' . \PHP_EOL .
            'protected:' . $analyzer->methods['protected'] . ' (' . $analyzer->methods['protected-static'] . ' static)' . \PHP_EOL .
            'private:' . $analyzer->methods['private'] . \PHP_EOL
        );
    }
}
