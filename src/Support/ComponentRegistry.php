<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support;

final class ComponentRegistry
{
    public function aliases(): array
    {
        return [
            'accordion' => \Zakarialabib\BComponents\Components\AccordionComponent::class,
            'alert' => \Zakarialabib\BComponents\Components\AlertComponent::class,
            'badge' => \Zakarialabib\BComponents\Components\BadgeComponent::class,
            'breadcrumb' => \Zakarialabib\BComponents\Components\BreadcrumbComponent::class,
            'button' => \Zakarialabib\BComponents\Components\ButtonComponent::class,
            'card' => \Zakarialabib\BComponents\Components\CardComponent::class,
            'checkbox' => \Zakarialabib\BComponents\Components\CheckboxComponent::class,
            'container' => \Zakarialabib\BComponents\Components\ContainerComponent::class,
            'divider' => \Zakarialabib\BComponents\Components\DividerComponent::class,
            'drawer' => \Zakarialabib\BComponents\Components\DrawerComponent::class,
            'flex' => \Zakarialabib\BComponents\Components\FlexComponent::class,
            'footer' => \Zakarialabib\BComponents\Components\FooterComponent::class,
            'form-group' => \Zakarialabib\BComponents\Components\FormGroupComponent::class,
            'grid' => \Zakarialabib\BComponents\Components\GridComponent::class,
            'header' => \Zakarialabib\BComponents\Components\HeaderComponent::class,
            'input' => \Zakarialabib\BComponents\Components\InputComponent::class,
            'loading' => \Zakarialabib\BComponents\Components\LoadingComponent::class,
            'modal' => \Zakarialabib\BComponents\Components\ModalComponent::class,
            'radio' => \Zakarialabib\BComponents\Components\RadioComponent::class,
            'select' => \Zakarialabib\BComponents\Components\SelectComponent::class,
            'spacer' => \Zakarialabib\BComponents\Components\SpacerComponent::class,
            'table' => \Zakarialabib\BComponents\Components\TableComponent::class,
            'table.header' => \Zakarialabib\BComponents\Components\Table\TableHeaderComponent::class,
            'table.body' => \Zakarialabib\BComponents\Components\Table\TableBodyComponent::class,
            'table.row' => \Zakarialabib\BComponents\Components\Table\TableRowComponent::class,
            'table.cell' => \Zakarialabib\BComponents\Components\Table\TableCellComponent::class,
            'textarea' => \Zakarialabib\BComponents\Components\TextareaComponent::class,
            'toast' => \Zakarialabib\BComponents\Components\ToastComponent::class,
            'toggle' => \Zakarialabib\BComponents\Components\ToggleComponent::class,
        ];
    }

    public function enabled(string $alias): bool
    {
        $enabled = config('bcomponents.components.enabled', []);
        if (!is_array($enabled) || $enabled === []) {
            return true;
        }

        return (bool) ($enabled[$alias] ?? true);
    }
}

