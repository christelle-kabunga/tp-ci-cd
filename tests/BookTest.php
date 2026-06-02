<?php

use PHPUnit\Framework\TestCase;
use Library\Book;
use Library\Member;

class BookTest extends TestCase
{
    public function testBookCreation()
    {
        $book = new Book("Le Petit Prince", "Saint-Exupéry", "978-1234567890");
        
        $this->assertEquals("Le Petit Prince", $book->getTitle());
        $this->assertEquals("Saint-Exupéry", $book->getAuthor());
        $this->assertEquals("978-1234567890", $book->getIsbn());
        $this->assertFalse($book->isBorrowed());
    }

    public function testBorrowBook()
    {
        $book = new Book("Test Book", "Test Author", "123");
        $member = new Member("M1", "Jean", "jean@test.com");
        
        $this->assertTrue($book->borrow($member));
        $this->assertTrue($book->isBorrowed());
        $this->assertEquals($member, $book->getBorrowedBy());
    }

    public function testCannotBorrowAlreadyBorrowedBook()
    {
        $book = new Book("Test Book", "Test Author", "123");
        $member1 = new Member("M1", "Jean", "jean@test.com");
        $member2 = new Member("M2", "Paul", "paul@test.com");
        
        $book->borrow($member1);
        $this->assertFalse($book->borrow($member2));
    }

    public function testReturnBook()
    {
        $book = new Book("Test Book", "Test Author", "123");
        $member = new Member("M1", "Jean", "jean@test.com");
        
        $book->borrow($member);
        $this->assertTrue($book->return());
        $this->assertFalse($book->isBorrowed());
        $this->assertNull($book->getBorrowedBy());
    }

    public function testCannotReturnBookThatIsNotBorrowed()
    {
        $book = new Book("Test Book", "Test Author", "123");
        $this->assertFalse($book->return());
    }
}