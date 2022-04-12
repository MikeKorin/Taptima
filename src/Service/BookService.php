<?php


namespace App\Service;


use App\Entity\Books;

class BookService
{
    public function getBookEntity(): object
    {
        return new Books();
    }
}