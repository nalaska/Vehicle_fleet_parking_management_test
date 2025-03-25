<?php
namespace Fulll\App\Command;

final readonly class CreateFleetCommand
{
    public function __construct(
        public string $userId
    ) {}
}
