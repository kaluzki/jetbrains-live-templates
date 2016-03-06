<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Console\Command;

use kaluzki\JetBrains\LiveTemplate\Controller;
use kaluzki\Routing\Router;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing;

/**
 */
class Api extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('jblt:api')
            ->setDescription('RESTful API')
            ->addOption('scope', 's', InputOption::VALUE_REQUIRED, 'scope', 'jblt-*.xml')
            ->addArgument('method', InputArgument::OPTIONAL, 'Request method (GET|PUT|POST|DELETE)', 'GET')
            ->addArgument('resource', InputArgument::OPTIONAL, 'Service end point', '/')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lines = call_user_func(
            new Router(new Controller\Api(glob($input->getOption('scope')))),
            $input->getArgument('method'),
            $input->getArgument('resource')
        );

        foreach (is_array($lines) || $lines instanceof \Traversable ? $lines : [$lines] as $line) {
            $output->writeln($line);
        }
    }
}