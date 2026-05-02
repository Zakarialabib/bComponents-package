<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Livewire;

use Livewire\Livewire;
use Zakarialabib\BComponents\Tests\TestCase;

final class LivewireSmokeTest extends TestCase
{
    public function test_livewire_autocomplete_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\AutocompleteComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_date_picker_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\DatePickerComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_dropdown_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\DropdownComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_file_upload_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\FileUploadComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_modal_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\ModalComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_multi_select_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\MultiSelectComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_rich_text_editor_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\RichTextEditorComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_table_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\TableComponent::class)
            ->assertStatus(200);
    }

    public function test_livewire_tabs_renders(): void
    {
        Livewire::test(\Zakarialabib\BComponents\Livewire\TabsComponent::class)
            ->assertStatus(200);
    }
}
