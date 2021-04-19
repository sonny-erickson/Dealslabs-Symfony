<?php

namespace DealsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Deal
 *
 * @ORM\Table(name="deal")
 * @ORM\Entity(repositoryClass="DealsBundle\Repository\DealRepository")
 */
class Deal
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
     * @ORM\Column(name="titre", type="string", length=155)
     */
    private $titre;

    /**
     * @var float
     *
     * @ORM\Column(name="prixOrigine", type="float")
     */
    private $prixOrigine;

    /**
     * @var float
     *
     * @ORM\Column(name="prixPromo", type="float")
     */
    private $prixPromo;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="livraison", type="float")
     */
    private $livraison;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetime")
     */
    private $datePublication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateExpiration", type="datetime")
     */
    private $dateExpiration;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255)
     */
    private $localisation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isNational", type="boolean")
     */
    private $isNational;

    /**
     * @var int
     *
     * @ORM\Column(name="counter", type="integer", nullable=true)
     */
    private $counter;

    /**
     * @var string
     * @ORM\Column(name="image", type="string")
     * @Assert\NotBlank(message="add img jpg")
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var Categorie
     * @ORM\ManyToOne (targetEntity="Categorie", inversedBy="deals")
     * @ORM\JoinColumn(nullable=false, name="categorie_id", referencedColumnName="id")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne (targetEntity="User", inversedBy="deals")
     * @ORM\JoinColumn(nullable=false, name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="DealVote", mappedBy="deal",cascade="remove")
     */
    private $votes;

    /**
     * Deal constructor
     */
    public function __construct(){
        return $this->datePublication= new \DateTime('now');
    }

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
     * Set titre
     *
     * @param string $titre
     *
     * @return Deal
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set prixOrigine
     *
     * @param float $prixOrigine
     *
     * @return Deal
     */
    public function setPrixOrigine($prixOrigine)
    {
        $this->prixOrigine = $prixOrigine;

        return $this;
    }

    /**
     * Get prixOrigine
     *
     * @return float
     */
    public function getPrixOrigine()
    {
        return $this->prixOrigine;
    }

    /**
     * Set prixPromo
     *
     * @param float $prixPromo
     *
     * @return Deal
     */
    public function setPrixPromo($prixPromo)
    {
        $this->prixPromo = $prixPromo;

        return $this;
    }

    /**
     * Get prixPromo
     *
     * @return float
     */
    public function getPrixPromo()
    {
        return $this->prixPromo;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Deal
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set livraison
     *
     * @param float $livraison
     *
     * @return Deal
     */
    public function setLivraison($livraison)
    {
        $this->livraison = $livraison;

        return $this;
    }

    /**
     * Get livraison
     *
     * @return float
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Deal
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set dateExpiration
     *
     * @param \DateTime $dateExpiration
     *
     * @return Deal
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    /**
     * Get dateExpiration
     *
     * @return \DateTime
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return Deal
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set categorie
     *
     * @param \DealsBundle\Entity\Categorie|object $categorie
     * @return Deal
     */
    public function setCategorie(\DealsBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \DealsBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set user
     *
     * @param User|object $user
     *
     * @return Deal
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->votes;
    }

// Creation de cette fonction car il y differents votes a  ajouter sinon il y a une erreur (converting String)
    //à check
    /**
     * @return mixed
     */
    public function getSumVotes()
    {
        $sum = 0;
        /** @var DealVote $dealVote */
        foreach ($this->votes as $dealVote){
            $sum += $dealVote->getCounter();
        }
        return $sum;
    }

    public function addVote(){

    }

    /**
     * @param mixed $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }

    /**
     * Get user
     *
     * @return \DealsBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Deal
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set dateDebut
     *
     * @param string $dateDebut
     *
     * @return Deal
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return string
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }


    /**
     * Set image
     *
     * @param string $image
     *
     * @return Deal
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return boolean
     */
    public function isNational()
    {
        return $this->isNational;
    }

    /**
     * @param bool $isNational
     */
    public function setIsNational($isNational)
    {
        $this->isNational = $isNational;
    }

    /**
     * @return int
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param int $counter
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }

}
