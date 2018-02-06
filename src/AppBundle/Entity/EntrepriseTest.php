<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntrepriseTest
 *
 * @ORM\Table(name="entreprise_test")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntrepriseTestRepository")
 */
class EntrepriseTest
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
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=30, unique=true)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string")
     */
    private $commentaire;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return EntrepriseTest
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return EntrepriseTest
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set Commentaire
     *
     * @param string $commentaire
     *
     * @return EntrepriseTest
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get Commentaires
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}

