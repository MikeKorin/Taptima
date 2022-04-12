<?php


namespace App\Service;


use App\Entity\Authors;

class AuthorService
{
    public function getAuthorEntity(): object
    {
        return new Authors();
    }
}