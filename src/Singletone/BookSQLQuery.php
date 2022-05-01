<?php


namespace App\Singletone;


use App\Repository\BooksRepository;


class BookSQLQuery
{
    private static BookSQLQuery $bookSqlQuery;

    private function __construct()
    {

    }

    public static function getClassInstance(): BookSQLQuery
    {
        return BookSQLQuery::$bookSqlQuery = new BookSQLQuery();
    }
    
    public function selectBookById(): string
    {
        return 'you are breathtaking!';
    }
}