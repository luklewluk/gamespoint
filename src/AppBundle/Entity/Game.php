<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="original_release_date", type="string", length=255, nullable=true)
     */
    private $originalReleaseDate;

    /**
     * @var string
     *
     * @ORM\Column(name="small_image", type="string", length=255, nullable=true)
     */
    private $smallImage;

    /**
     * @var Platform[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Platform", inversedBy="games")
     * @ORM\JoinTable(name="games_platforms")
     */
    private $platforms;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set originalReleaseDate
     *
     * @param string $originalReleaseDate
     *
     * @return Game
     */
    public function setOriginalReleaseDate($originalReleaseDate)
    {
        $this->originalReleaseDate = $originalReleaseDate;

        return $this;
    }

    /**
     * Get originalReleaseDate
     *
     * @return string
     */
    public function getOriginalReleaseDate()
    {
        return $this->originalReleaseDate;
    }

    /**
     * Set smallImage
     *
     * @param string $smallImage
     *
     * @return Game
     */
    public function setSmallImage($smallImage)
    {
        $this->smallImage = $smallImage;

        return $this;
    }

    /**
     * Get smallImage
     *
     * @return string
     */
    public function getSmallImage()
    {
        return $this->smallImage;
    }

    /**
     * Set platforms
     *
     * @param array $platforms
     *
     * @return Game
     */
    public function setPlatforms($platforms)
    {
        $this->platforms = $platforms;

        return $this;
    }

    /**
     * Get platforms
     *
     * @return Platform[]
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }
}

