<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task extends Basic
{
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $task_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $keyword;

    /**
     * @ORM\ManyToOne(targetEntity=System::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $system;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location_name;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $result = [];


    public function getTaskId(): ?string
    {
        return $this->task_id;
    }

    public function setTaskId(string $task_id): self
    {
        $this->task_id = $task_id;

        return $this;
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(?string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getSystem(): ?System
    {
        return $this->system;
    }

    public function setSystem(?System $system): self
    {
        $this->system = $system;

        return $this;
    }

    public function getLocationName(): ?string
    {
        return $this->location_name;
    }

    public function setLocationName(?string $location_name): self
    {
        $this->location_name = $location_name;

        return $this;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function setResult(?array $result): self
    {
        $this->result = $result;

        return $this;
    }
}
