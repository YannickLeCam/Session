<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private array $role = [];

    /**
     * @var Collection<int, session>
     */
    #[ORM\OneToMany(targetEntity: session::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $sessions;

    /**
     * @var Collection<int, ModuleProgram>
     */
    #[ORM\ManyToMany(targetEntity: ModuleProgram::class, inversedBy: 'users')]
    private Collection $ModulePrograms;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->ModulePrograms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setUser($this);
        }

        return $this;
    }

    public function removeSession(session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getUser() === $this) {
                $session->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ModuleProgram>
     */
    public function getModulePrograms(): Collection
    {
        return $this->ModulePrograms;
    }

    public function addModuleProgram(ModuleProgram $moduleProgram): static
    {
        if (!$this->ModulePrograms->contains($moduleProgram)) {
            $this->ModulePrograms->add($moduleProgram);
        }

        return $this;
    }

    public function removeModuleProgram(ModuleProgram $moduleProgram): static
    {
        $this->ModulePrograms->removeElement($moduleProgram);

        return $this;
    }
}
