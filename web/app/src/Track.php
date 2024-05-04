<?php

namespace App;

class Track
{
    private string $author;
    private string $name;

    public function __construct(string $author, string $name)
    {
        $this->author = $author;
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->author . ' - ' . $this->name;
    }
}