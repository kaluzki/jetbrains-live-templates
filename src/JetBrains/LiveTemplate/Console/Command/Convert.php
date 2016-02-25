<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Console\Command;

use kaluzki\JetBrains\LiveTemplate\Model\XmlStore;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 */
class Convert extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('jblt:convert')
            ->setDescription('Convert xml to another format (json|md)')
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

        array_map(function($file) use($output) {
            $output->writeln($file);
            $store = new XmlStore(simplexml_load_file($file));
            $output->writeln(json_encode($store->getIterator()));
            $output->writeln('');
        }, array_unique($files));
    }
}