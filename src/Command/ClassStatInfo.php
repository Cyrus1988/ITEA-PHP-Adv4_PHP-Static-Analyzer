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
use Greeflas\StaticAnalyzer\Methods;
use Greeflas\StaticAnalyzer\Properties;
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
        $methodClass = new Methods();
        $propertyClass = new Properties();

        $result = $analyzer->getInfo($methodClass, $propertyClass);


        $output->writeln(
            "Class: $className is " . $result . \PHP_EOL .
            'Properties:' . \PHP_EOL .
            'public:' . $propertyClass->getPublicPropetry() . ' (' . $propertyClass->getPublicStaticPropetry() . ' static)' . \PHP_EOL .
            'protected:' . $propertyClass->getProtectedPropetry() . \PHP_EOL .
            'private:' . $propertyClass->getPrivatePropetry() . ' (' . $propertyClass->getPrivateStaticPropetry() . ' static)' . \PHP_EOL .
            'Methods:' . \PHP_EOL .
            'public:' . $methodClass->getPublicMethod() . ' (' . $methodClass->getPublicStaticMethod() . 'static)' . \PHP_EOL .
            'protected:' . $methodClass->getProtectedMethod() . ' (' . $methodClass->getProtectedStaticMethod() . ' static)' . \PHP_EOL .
            'private:' . $methodClass->getPrivateMethod() . \PHP_EOL
        );
    }
}
