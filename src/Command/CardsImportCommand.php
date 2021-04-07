<?php


namespace App\Command;


use App\Entity\Cards;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CardsImportCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected static $defaultName = 'app:import:cards';

    protected function configure()
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'The JSON file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $items = $this->entityManager->getRepository(Cards::class)->findAll();

        foreach ($items as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();


        try {
            $json = json_decode(file_get_contents($input->getArgument('file')));
        } catch (\Exception $e) {
            $output->writeln('<error>File error : ' . $e->getMessage() . '</error>');
            return COmmand::FAILURE;
        }

        foreach ($json->{'indexDB'} as $data)
        {
            try {

                $data = (array) $data;
                $item = new Cards();

                $item
                    ->setItemId($data['id'])
                    ->setName($data['name'])
                    ->setType($data['type'])
                ;

                if (isset($data['color'])) {
                    $item->setColor($data['color']);
                }

                if (isset($data['profession'])) {
                    $item->setProfession($data['profession']);
                }

                if (isset($data['monster'])) {
                    $item->setMonster($data['monster']);
                }

                $this->entityManager->persist($item);
            } catch (\Exception $e) {
                $output->writeln('<error>Error on item ' . $data->{'id'} . ' : ' . $e->getMessage() . '</error>');
            }
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}