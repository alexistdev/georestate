<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

trait UUIDRandomGenerator
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */


    /**
     * Generate a new UUID
     */
    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    public function newUniqueIdbyUlid(): string
    {
        return (string) Ulid::generate();
    }
}
