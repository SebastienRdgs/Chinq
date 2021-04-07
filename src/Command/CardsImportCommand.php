<?php


namespace App\Command;


use App\Entity\Card;
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

        $items = $this->entityManager->getRepository(Card::class)->findAll();

        foreach ($items as $card) {
            $this->entityManager->remove($card);
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
                $card = new Card();

                $card
                    ->setItemId($data['id'])
                    ->setName($data['name'])
                    ->setType($data['type'])
                ;

                if (isset($data['color'])) {
                    $card->setColor($data['color']);
                }

                if (isset($data['profession'])) {
                    $card->setProfession($data['profession']);
                }

                if (isset($data['monster'])) {
                    $card->setMonster($data['monster']);
                }

                $this->entityManager->persist($card);
            } catch (\Exception $e) {
                $output->writeln('<error>Error on card ' . $data->{'id'} . ' : ' . $e->getMessage() . '</error>');
            }
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}