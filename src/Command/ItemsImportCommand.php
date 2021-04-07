<?php


namespace App\Command;


use App\Entity\Card;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ItemsImportCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected static $defaultName = 'app:import:items';

    protected function configure()
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'The JSON file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // Clean database before import
        $items = $this->entityManager->getRepository(Item::class)->findAll();

        foreach ($items as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();


        try {
            $json = (array) json_decode(file_get_contents($input->getArgument('file')));
        } catch (\Exception $e) {
            $output->writeln('<error>File error : ' . $e->getMessage() . '</error>');
            return COmmand::FAILURE;
        }

        foreach ($json as $data)
        {
            try {
                $data = (array) $data;
                $item = new Item();

                $item
                    ->setItemId($data['id'])
                    ->setName($data['name'])
                    ->setImgUrl($data['imgUrl'])
                    ->setLevel((int) $data['level'])
                    ->setType($data['type'])
                    ->setCat($data['cat'])
                ;
                $this->entityManager->persist($item);
            } catch (\Exception $e) {
                $output->writeln('<error>Error on item ' . $data->{'id'} . ' : ' . $e->getMessage() . '</error>');
            }
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}