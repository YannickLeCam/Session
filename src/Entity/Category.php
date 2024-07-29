<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, ModuleProgram>
     */
    #[ORM\OneToMany(targetEntity: ModuleProgram::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $modulePrograms;

    public function __construct()
    {
        $this->modulePrograms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ModuleProgram>
     */
    public function getModulePrograms(): Collection
    {
        return $this->modulePrograms;
    }

    public function addModuleProgram(ModuleProgram $moduleProgram): static
    {
        if (!$this->modulePrograms->contains($moduleProgram)) {
            $this->modulePrograms->add($moduleProgram);
            $moduleProgram->setCategory($this);
        }

        return $this;
    }

    public function removeModuleProgram(ModuleProgram $moduleProgram): static
    {
        if ($this->modulePrograms->removeElement($moduleProgram)) {
            // set the owning side to null (unless already changed)
            if ($moduleProgram->getCategory() === $this) {
                $moduleProgram->setCategory(null);
            }
        }

        return $this;
    }
}
