<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Livewire;

use Livewire\Livewire;
use Zakarialabib\BComponents\Tests\TestCase;

final class LivewireSmokeTest extends TestCase
{
    public function test_livewire_dropdown_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\DropdownComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_modal_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\ModalComponent::class)
            ->assertStatus(200);
    }
}

