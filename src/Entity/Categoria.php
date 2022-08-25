<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria
 *
 * @ORM\Table(name="categoria")
 * @ORM\Entity
 */
class Categoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="text", length=65535, nullable=false)
     */
    private $foto;

    /**
     * @ORM\OneToMany(targetEntity="Tapa", mappedBy="categoria")
     */
    private $tapas;

    public function __construct()
    {
        $this->tapas = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * @return Collection<int, Tapa>
     */
    public function getTapas(): Collection
    {
        return $this->tapas;
    }

    public function addTapa(Tapa $tapa): self
    {
        if (!$this->tapas->contains($tapa)) {
            $this->tapas->add($tapa);
            $tapa->setCategoria($this);
        }

        return $this;
    }

    public function removeTapa(Tapa $tapa): self
    {
        if ($this->tapas->removeElement($tapa)) {
            // set the owning side to null (unless already changed)
            if ($tapa->getCategoria() === $this) {
                $tapa->setCategoria(null);
            }
        }

        return $this;
    }


}
