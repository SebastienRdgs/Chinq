<?php


namespace App\Controller;


use App\Entity\Card;
use App\Entity\Item;
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
        $items = $this->em->getRepository(Item::class)->findAll();

        return $this->render('home/index.html.twig', [
            'items' => $items,
        ]);
    }
}