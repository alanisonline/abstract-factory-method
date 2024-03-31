<?php
declare(strict_types=1);

namespace Manufacturers;

// CREATOR
abstract class Manufacturer
{
    abstract public function newHypercar(): HypercarInterface;

    abstract public function newGT3(): GT3Interface;
}

// CONCRETE CREATORS
class PorscheFactory extends Manufacturer
{
    public function newHypercar(): HypercarInterface
    {
        return new PorscheHypercar();
    }

    public function newGT3(): GT3Interface
    {
        return new PorscheGT3();
    }
}

class AstonMartinFactory extends Manufacturer
{
    public function newHypercar(): HypercarInterface
    {
        return new AstonMartinHypercar();
    }
    
    public function newGT3(): GT3Interface
    {
        return new AstonMartinGT3();
    }
}

// PRODUCT INTERFACE
interface HypercarInterface
{
    public function isHybrid(): bool;
}

interface GT3Interface
{
    public function assignAmateurDriverName(string $name): void;
}

// CONCRETE PRODUCTS
class AstonMartinHypercar implements HypercarInterface
{
    public function isHybrid(): bool
    {
        return false;
    }
}

class AstonMartinGT3 implements GT3Interface
{
    public function __construct(private ?string $amateurDriverName = null)
    {
        
    }

    public function assignAmateurDriverName(string $name): void
    {   
        $this->amateurDriverName = $name;
    }
}

class PorscheHypercar implements HypercarInterface
{
    public function isHybrid(): bool
    {
        return true;
    }
}

class PorscheGT3 implements GT3Interface
{
    public function __construct(private ?string $amateurDriverName = null)
    {
        
    }

    public function assignAmateurDriverName(string $name): void
    {   
        $this->amateurDriverName = $name;
    }
}


$participants = [];

function addGT3Participant(Manufacturer $factory, array $participants): ?array
{
    array_push($participants, $factory->newGT3());
    return $participants;
}

function addHypercarParticipant(Manufacturer $factory, array $participants): ?array
{
    array_push($participants, $factory->newHypercar());
    return $participants;
}

function generateParticipants(): array
{
    $astonMartinFactory = new AstonMartinFactory();
    $porscheFactory = new PorscheFactory();

    $participants = [];

    while (count($participants) < 3)
    {
        $participants = addHypercarParticipant($astonMartinFactory, $participants);
    }

    while (count($participants) < 6)
    {
        $participants = addHypercarParticipant($porscheFactory, $participants);
    }
    
    while (count($participants) < 9)
    {
        $participants = addGT3Participant($astonMartinFactory, $participants);
    }

    while (count($participants) < 12)
    {
        $participants = addGT3Participant($porscheFactory, $participants);
    }

    return $participants;
}

var_dump(
    generateParticipants()
);
