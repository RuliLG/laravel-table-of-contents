<?php

namespace RuliLG\TableOfContents;

class TableOfContentsItem {
    public function __construct(
        private string $id,
        private string $anchor,
        private int $depth,
    )
    {
        // ...
    }

    public function id(): string
    {
        return $this->id;
    }

    public function anchor(): string
    {
        return $this->anchor;
    }

    public function depth(): int
    {
        return $this->depth;
    }
}
