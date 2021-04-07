<?php


namespace App\Controller;


use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(string $item): Response
    {
        $item = $this->em->getRepository(Item::class)->findOneBy(['id'=>  (int) $item]);

        return $this->render('item/show.html.twig', [
            'item' => $item,
        ]);
    }
}