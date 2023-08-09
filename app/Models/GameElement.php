<?php
class GameElement
{
    protected string $name;
    protected array $beats;

    public function __construct(string $name, array $beats)
    {
        $this->name = $name;
        $this->beats = $beats;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function beats(GameElement $opponentElement): bool
    {
        return in_array($opponentElement->getName(), $this->beats);
    }
}