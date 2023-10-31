<?php
class Player
{
    private string $name;
    public int $point = 0;
    public int $numDice = 0;

    private array $lastScore = [];

    public function __construct($name, $_numDice)
    {
        $this->name = $name;
        $this->numDice = $_numDice;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    public function addPoint(): void
    {
        $this->point += 1;
        $this->removeDice();
    }

    public function addDice(): void
    {
        $this->numDice += 1;
    }

    public function removeDice(): void
    {
        $this->numDice -= 1;
    }

    /**
     * @return int
     */
    public function getNumDice(): int
    {
        return $this->numDice;
    }



    /**
     * @return array
     */
    public function getLastScore(): array
    {
        return $this->lastScore;
    }



    public function roll(): array
    {
        $result = [];
        for ($i = 0; $i < $this->numDice; $i++) {
            $result[] = $this->rollDice();
        }
        $this->lastScore = $result;
        return $result;
    }

    function rollDice(): int
    {
        return rand(1, 6);
    }
}
