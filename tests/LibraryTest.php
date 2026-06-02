<?php

use PHPUnit\Framework\TestCase;
use Library\Library;
use Library\Book;
use Library\Member;

class LibraryTest extends TestCase
{
    private Library $library;
    
    protected function setUp(): void
    {
        $this->library = new Library();
    }

    public function testAddAndGetBook()
    {
        $book = new Book("Test Book", "Test Author", "123");
        $this->library->addBook($book);
        
        $retrieved = $this->library->getBook("123");
        $this->assertNotNull($retrieved);
        $this->assertEquals("Test Book", $retrieved->getTitle());
    }

    public function testGetAllBooks()
    {
        $book1 = new Book("Book 1", "Author 1", "111");
        $book2 = new Book("Book 2", "Author 2", "222");
        
        $this->library->addBook($book1);
        $this->library->addBook($book2);
        
        $books = $this->library->getAllBooks();
        $this->assertCount(2, $books);
    }

    public function testRemoveBook()
    {
        $book = new Book("Test Book", "Test Author", "123");
        $this->library->addBook($book);
        
        $this->assertTrue($this->library->removeBook("123"));
        $this->assertNull($this->library->getBook("123"));
    }

    public function testCannotRemoveBorrowedBook()
    {
        $book = new Book("Test Book", "Test Author", "123");
        $member = new Member("M1", "Jean", "jean@test.com");
        
        $this->library->addBook($book);
        $this->library->addMember($member);
        
        $this->library->borrowBook("M1", "123");
        
        $this->assertFalse($this->library->removeBook("123"));
        $this->assertNotNull($this->library->getBook("123"));
    }

    public function testAddAndGetMember()
    {
        $member = new Member("M1", "Alice", "alice@test.com");
        $this->library->addMember($member);
        
        $retrieved = $this->library->getMember("M1");
        $this->assertNotNull($retrieved);
        $this->assertEquals("Alice", $retrieved->getName());
    }

    public function testBorrowBookFlow()
    {
        $book = new Book("PHP Guide", "John Doe", "PHP123");
        $member = new Member("M1", "Alice", "alice@test.com");
        
        $this->library->addBook($book);
        $this->library->addMember($member);
        
        $this->assertTrue($this->library->borrowBook("M1", "PHP123"));
        $this->assertTrue($book->isBorrowed());
        $this->assertEquals(1, $member->getBorrowedCount());
    }

    public function testReturnBookFlow()
    {
        $book = new Book("PHP Guide", "John Doe", "PHP123");
        $member = new Member("M1", "Alice", "alice@test.com");
        
        $this->library->addBook($book);
        $this->library->addMember($member);
        
        $this->library->borrowBook("M1", "PHP123");
        $this->assertTrue($this->library->returnBook("M1", "PHP123"));
        $this->assertFalse($book->isBorrowed());
        $this->assertEquals(0, $member->getBorrowedCount());
    }

    public function testGetAvailableBooks()
    {
        $book1 = new Book("Book 1", "Author 1", "111");
        $book2 = new Book("Book 2", "Author 2", "222");
        $member = new Member("M1", "Alice", "alice@test.com");
        
        $this->library->addBook($book1);
        $this->library->addBook($book2);
        $this->library->addMember($member);
        
        $this->library->borrowBook("M1", "111");
        
        $available = $this->library->getAvailableBooks();
        $this->assertCount(1, $available);
        
        $borrowed = $this->library->getBorrowedBooks();
        $this->assertCount(1, $borrowed);
    }
}