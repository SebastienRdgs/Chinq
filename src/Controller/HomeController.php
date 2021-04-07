<?php


namespace App\Controller;


use App\Entity\Cards;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(): Response
    {
        $cards = $this->em->getRepository(Cards::class)->findAll();

        return $this->render('home/index.html.twig', [
            'cards' => $cards,
        ]);
    }
}