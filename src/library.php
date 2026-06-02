<?php

namespace Library;

class Library
{
    private array $books;
    private array $members;

    public function __construct()
    {
        $this->books = [];
        $this->members = [];
    }

    public function addBook(Book $book): void
    {
        $this->books[$book->getIsbn()] = $book;
    }

    public function removeBook(string $isbn): bool
    {
        if (!isset($this->books[$isbn])) {
            return false;
        }

        $book = $this->books[$isbn];

        if ($book->isBorrowed()) {
            return false; // Cannot remove borrowed book
        }

        unset($this->books[$isbn]);
        return true;
    }

    public function getBook(string $isbn): ?Book
    {
        return $this->books[$isbn] ?? null;
    }

    public function getAllBooks(): array
    {
        return array_values($this->books);
    }

    public function addMember(Member $member): void
    {
        $this->members[$member->getId()] = $member;
    }

    public function getMember(string $id): ?Member
    {
        return $this->members[$id] ?? null;
    }

    public function getAllMembers(): array
    {
        return array_values($this->members);
    }

    public function borrowBook(string $memberId, string $isbn): bool
    {
        $member = $this->getMember($memberId);
        $book = $this->getBook($isbn);

        if (!$member || !$book) {
            return false;
        }

        return $member->borrowBook($book);
    }

    public function returnBook(string $memberId, string $isbn): bool
    {
        $member = $this->getMember($memberId);
        $book = $this->getBook($isbn);

        if (!$member || !$book) {
            return false;
        }

        return $member->returnBook($book);
    }

    public function getAvailableBooks(): array
    {
        return array_filter($this->books, function (Book $book) {
            return !$book->isBorrowed();
        });
    }

    public function getBorrowedBooks(): array
    {
        return array_filter($this->books, function (Book $book) {
            return $book->isBorrowed();
        });
    }
}
