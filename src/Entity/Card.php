<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="card")
 */
class Card
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $itemId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $color;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $profession;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $monster;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     */
    public function setItemId(int $itemId): Card
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): Card
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): Card
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): Card
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfession(): ?string
    {
        return $this->profession;
    }

    /**
     * @param string $profession
     */
    public function setProfession(string $profession): Card
    {
        $this->profession = $profession;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMonster(): ?string
    {
        return $this->monster;
    }

    /**
     * @param string|null $monster
     */
    public function setMonster(?string $monster): Card
    {
        $this->monster = $monster;
        return $this;
    }
}