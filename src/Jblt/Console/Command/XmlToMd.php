<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\Jblt\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 */
class XmlToMd extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('jblt:tomd')
            ->setDescription('Convert xml to md format')
            ->addArgument('FILE', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'file pattern', ['jblt-*.xml'])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = [];
        foreach ($input->getArgument('FILE') as $pattern) {
            $files = array_merge($files, glob($pattern));
        }

        $output->writeln(json_encode(array_unique($files)));
    }
}