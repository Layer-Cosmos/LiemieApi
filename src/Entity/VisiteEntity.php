<?php


namespace App\Entity;


use App\Core\Entity\Entity;
use JsonSerializable;

class VisiteEntity extends Entity implements JsonSerializable
{
    private $id;
    private $id_patient;
    private $date;
    private $duree;

    /**
     * VisiteEntity constructor.
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
    public function getIdPatient()
    {
        return $this->id_patient;
    }

    /**
     * @param mixed $id_patient
     */
    public function setIdPatient($id_patient): void
    {
        $this->id_patient = $id_patient;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param mixed $duree
     */
    public function setDuree($duree): void
    {
        $this->duree = $duree;
    }



    public function jsonSerialize()
    {
        return
            [
                'id'   => $this->getId(),
                'id_patient'   => $this->getIdPatient(),
                'date' => $this->getDate(),
                'duree' => $this->getDuree()
            ];
    }
}