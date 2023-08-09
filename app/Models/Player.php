<?php

class Player
{
    protected string $name;
    protected int $points = 0;
    protected int $wins = 0;
    protected int $choice = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function increasePoints(): void
    {
        $this->points++;
    }

    public function resetPoints(): void
    {
        $this->points = 0;
    }

    public function getWins(): int
    {
        return $this->wins;
    }

    public function increaseWins(): void
    {
        $this->wins++;
    }

    public function getChoice(): int
    {
        return $this->choice;
    }

    public function setChoice(int $choice): void
    {
        $this->choice = $choice;
    }
}