<?php

namespace Library;

class Book
{
    private string $title;
    private string $author;
    private string $isbn;
    private bool $isBorrowed;
    private ?Member $borrowedBy;

    public function __construct(string $title, string $author, string $isbn)
    {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->isBorrowed = false;
        $this->borrowedBy = null;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function isBorrowed(): bool
    {
        return $this->isBorrowed;
    }

    public function getBorrowedBy(): ?Member
    {
        return $this->borrowedBy;
    }

    public function borrow(Member $member): bool
    {
        if ($this->isBorrowed) {
            return false;
        }

        $this->isBorrowed = true;
        $this->borrowedBy = $member;
        return true;
    }

    public function return(): bool
    {
        if (!$this->isBorrowed) {
            return false;
        }

        $this->isBorrowed = false;
        $this->borrowedBy = null;
        return true;
    }
}
