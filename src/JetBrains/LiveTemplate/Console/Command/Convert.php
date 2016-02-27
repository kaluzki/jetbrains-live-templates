<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Console\Command;

use kaluzki\JetBrains\LiveTemplate\Model\XmlStore;
use kaluzki\JetBrains\LiveTemplate\View\MarkDown;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->setDescription('Convert xml to another format (json|markdown)')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'json|markdown', 'json')
            ->addArgument('file', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'file pattern', ['jblt-*.xml'])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = [];
        foreach ($input->getArgument('file') as $pattern) {
            $files = array_merge($files, glob($pattern));
        }
        $format = $input->getOption('format');

        array_map(function($file) use($output, $format) {
            $output->writeln($file);
            $templateSet = (new XmlStore(simplexml_load_file($file)))->getIterator();

            switch ($format) {
                case 'markdown':
                case 'md':
                    $content = (new MarkDown($templateSet))->render($templateSet);
                    break;
                default:
                    $content = json_encode($templateSet, JSON_PRETTY_PRINT);
            }

            $output->writeln($content);
            $output->writeln('');
        }, array_unique($files));
    }
}