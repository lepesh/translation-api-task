<?php
declare(strict_types=1);

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait IdentityTrait
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    protected int $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
