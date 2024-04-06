<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;

class SetCreatedAt
{
    public function prePersist(User $user): void
    {
        if ($user->getCreatedAt() === null) {
            $user->setCreatedAt(new \DateTime());
        }
    }
}
