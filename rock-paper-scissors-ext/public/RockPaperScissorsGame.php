<?php

require_once '../app/Models/Player.php';
require_once '../app/Models/GameElement.php';

class RockPaperScissorsGame
{
    protected array $gameElements;
    protected array $computerUsers;
    protected array $computerBots;
    protected const ROUNDS = 3;
    protected const POINTS_TO_WIN = 2;

    public function __construct(array $computerUsers, array $computerBots, array $gameElements)
    {
        $this->gameElements = $gameElements;
        $this->computerUsers = $computerUsers;
        $this->computerBots = $computerBots;
    }

    public function start(): void
    {
        foreach ($this->computerUsers as $user) {
            foreach ($this->computerBots as $bot) {
                $this->playRounds($user, $bot);
                $this->determineWinner($user, $bot);
            }
        }
        $this->printResults();
    }

    public function playRounds(Player $user, Player $bot): void
    {
        for ($round = 0; $round < self::ROUNDS; $round++) {
            echo "Round: $round with {$bot->getName()}" . PHP_EOL;
            $this->setUserChoice($user);
            $this->setBotChoice($bot);

            $userElement = $this->gameElements[$user->getChoice()];
            $computerElement = $this->gameElements[$bot->getChoice()];

            echo "{$user->getName()} chooses {$userElement->getName()}" . PHP_EOL;
            echo "{$bot->getName()} chooses {$computerElement->getName()}" . PHP_EOL;

            if ($userElement->beats($computerElement)) {
                echo "{$user->getName()} wins!" . PHP_EOL;
                $user->increasePoints();
            } elseif ($computerElement->beats($userElement)) {
                echo "{$bot->getName()} wins!" . PHP_EOL;
                $bot->increasePoints();
            } else {
                echo "It's a draw!" . PHP_EOL;
            }
            echo PHP_EOL;
        }
    }

    private function setUserChoice(Player $user)
    {
        $gameElementsCount = count($this->gameElements);
        $range = range(1, $gameElementsCount);
        $choice = 0;
        while (!in_array($choice, $range)) {
            $this->printGameElements();
            $choice = readline("{$user->getName()}, enter choice (1-$gameElementsCount): ");
        }
        $user->setChoice($choice);
    }

    public function setBotChoice(Player $bot)
    {
        $bot->setChoice(rand(1, count($this->gameElements)));
    }

    public function printGameElements()
    {
        foreach ($this->gameElements as $key => $element) {
            echo $key . ':' . $element->getName() . '|';
        }
        echo PHP_EOL;
    }

    public function determineWinner(Player $user, Player $bot): void
    {
        $user->getPoints() >= self::POINTS_TO_WIN ? $user->increaseWins() : null;
        $bot->getPoints() >= self::POINTS_TO_WIN ? $bot->increaseWins() : null;
        $user->resetPoints();
        $bot->resetPoints();
    }

    private function printResults(): void
    {
        foreach ($this->computerBots as $bot) {
            echo "{$bot->getName()} has {$bot->getWins()} win(s)." . PHP_EOL;
        }
        foreach ($this->computerUsers as $user) {
            echo "{$user->getName()} has {$user->getWins()} win(s)." . PHP_EOL;
        }
    }
}

//Ability to add more computer users.
$computerUsers = [
    new Player('Captain Copy Paste'),
];

//Ability to add more computer bots.
$computerBots = [
    new Player('Facepalm (Bot)'),
    new Player('Master of Dynamite (Bot)'),
    new Player('Papercraft Ninja (Bot)'),
];

//Ability to add more game elements.
$gameElements = [
    1 => new GameElement('Dynamite', $beats = ['Scissors', 'Lizard', 'Spock', 'Rock', 'Paper']),
    2 => new GameElement('Rock', $beats = ['Scissors', 'Lizard']),
    3 => new GameElement('Paper', $beats = ['Rock', 'Spock']),
    4 => new GameElement('Spock', $beats = ['Rock', 'Scissors']),
    5 => new GameElement('Scissors', $beats = ['Paper', 'Lizard']),
    6 => new GameElement('Lizard', $beats = ['Paper', 'Spock'])
];

$game = (new RockPaperScissorsGame($computerUsers, $computerBots, $gameElements))->start();
