<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 03/11/2016
 * Time: 16:06
 */

namespace Administration\FakerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PopulateCommand
 * @package Administration\FakerBundle\Command
 */
class PopulateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Populates configured entities with random data')
            ->setHelp(<<<HELP
The <info>faker:populate</info> command populates configured entities with random data.
  <info>php app/console faker:populate</info>
HELP
            )
            ->setName('faker:populate');
    }

    /**
     * {@inheritDoc}
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $populator = $this->getContainer()->get('faker.populator');
        $insertedPks = $populator->execute();
        $output->writeln('');
        if (0 === count($insertedPks)) {
            $output->writeln('<error>No entities populated.</error>');
        } else {
            foreach ($insertedPks as $class => $pks) {
                $reflClass = new \ReflectionClass($class);
                $shortClassName = $reflClass->getShortName();
                $output->writeln(sprintf('Inserted <info>%s</info> new <info>%s</info> objects', count($pks), $shortClassName));
            }
        }
    }
}