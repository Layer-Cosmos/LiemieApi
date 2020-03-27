<?php


namespace App\Entity;


use App\Core\Entity\Entity;
use JsonSerializable;

class PatientEntity extends Entity implements JsonSerializable
{
    private $id;
    private $nom;
    private $prenom;
    private $age;

    /**
     * PatientEntity constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return
            [
                'id'   => $this->getId(),
                'prenom'   => $this->getPrenom(),
                'nom' => $this->getNom(),
                'age' => $this->getAge()
            ];
    }
}