<?php

use PHPUnit\Framework\TestCase;
use Library\Member;
use Library\Book;

class MemberTest extends TestCase
{
    public function testMemberCreation()
    {
        $member = new Member("M1", "Alice Dupont", "alice@test.com");
        
        $this->assertEquals("M1", $member->getId());
        $this->assertEquals("Alice Dupont", $member->getName());
        $this->assertEquals("alice@test.com", $member->getEmail());
        $this->assertEquals(0, $member->getBorrowedCount());
    }

    public function testMemberCanBorrowUpToMaxBooks()
    {
        $member = new Member("M1", "Alice", "alice@test.com", 2);
        
        $book1 = new Book("Book 1", "Author 1", "111");
        $book2 = new Book("Book 2", "Author 2", "222");
        
        $this->assertTrue($member->canBorrow());
        $member->borrowBook($book1);
        $this->assertTrue($member->canBorrow());
        $member->borrowBook($book2);
        $this->assertFalse($member->canBorrow());
        $this->assertEquals(2, $member->getBorrowedCount());
    }

    public function testMemberCannotBorrowMoreThanMax()
    {
        $member = new Member("M1", "Alice", "alice@test.com", 1);
        
        $book1 = new Book("Book 1", "Author 1", "111");
        $book2 = new Book("Book 2", "Author 2", "222");
        
        $this->assertTrue($member->borrowBook($book1));
        $this->assertFalse($member->borrowBook($book2));
        $this->assertEquals(1, $member->getBorrowedCount());
    }

    public function testMemberCanReturnBook()
    {
        $member = new Member("M1", "Alice", "alice@test.com");
        $book = new Book("Book 1", "Author 1", "111");
        
        $member->borrowBook($book);
        $this->assertEquals(1, $member->getBorrowedCount());
        
        $this->assertTrue($member->returnBook($book));
        $this->assertEquals(0, $member->getBorrowedCount());
    }

    public function testMemberCannotReturnBookNotBorrowed()
    {
        $member = new Member("M1", "Alice", "alice@test.com");
        $book = new Book("Book 1", "Author 1", "111");
        
        $this->assertFalse($member->returnBook($book));
    }
}