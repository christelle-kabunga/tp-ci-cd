<?php

namespace Library;

class Member
{
    private string $id;
    private string $name;
    private string $email;
    private array $borrowedBooks;
    private int $maxBooks;

    public function __construct(string $id, string $name, string $email, int $maxBooks = 3)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->borrowedBooks = [];
        $this->maxBooks = $maxBooks;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBorrowedBooks(): array
    {
        return $this->borrowedBooks;
    }

    public function canBorrow(): bool
    {
        return count($this->borrowedBooks) < $this->maxBooks;
    }

    public function borrowBook(Book $book): bool
    {
        if (!$this->canBorrow()) {
            return false;
        }

        if ($book->isBorrowed()) {
            return false;
        }

        if ($book->borrow($this)) {
            $this->borrowedBooks[] = $book;
            return true;
        }

        return false;
    }

    public function returnBook(Book $book): bool
    {
        $key = array_search($book, $this->borrowedBooks, true);
        
        if ($key === false) {
            return false;
        }

        if ($book->return()) {
            unset($this->borrowedBooks[$key]);
            $this->borrowedBooks = array_values($this->borrowedBooks);
            return true;
        }

        return false;
    }

    public function getBorrowedCount(): int
    {
        return count($this->borrowedBooks);
    }
}