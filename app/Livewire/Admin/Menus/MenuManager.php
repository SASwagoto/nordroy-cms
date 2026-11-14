<?php

namespace App\Livewire\Admin\Menus;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\LinkResolver;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class MenuManager extends Component
{
    public ?int $selectedMenuId = null;
    public string $menuName = '';
    public string $menuLocation = 'primary';
    
    // Multi-layer flat list of items for the active menu
    public array $items = [];
    public ?int $expandedIndex = null;

    // Create New Menu Modal
    public bool $showCreateModal = false;
    public string $newMenuName = '';
    public string $newMenuLocation = 'custom';

    // Quick add selection state
    public array $selectedPages = [];
    public array $selectedServices = [];

    public function mount(): void
    {
        $this->ensureDefaultMenuExists();
        $this->loadSelectedMenu();
    }

    /**
     * Ensure a default Primary Navigation menu exists in database.
     */
    protected function ensureDefaultMenuExists(): void
    {
        if (Menu::count() === 0) {
            DB::transaction(function () {
                $primary = Menu::create([
                    'name'     => 'Primary Navigation',
                    'location' => 'primary',
                ]);

                $order = 0;

                // 1. Home
                MenuItem::create([
                    'menu_id'          => $primary->id,
                    'parent_id'        => null,
                    'title'            => ['en' => 'Home'],
                    'type'             => 'internal',
                    'url'              => '/',
                    'target'           => '_self',
                    'order'            => $order++,
                    'is_active'        => true,
                    'mega_menu_schema' => ['type' => 'internal', 'page' => 'home', 'section' => '', 'target_blank' => false],
                ]);

                // 2. About Us
                $about = MenuItem::create([
                    'menu_id'          => $primary->id,
                    'parent_id'        => null,
                    'title'            => ['en' => 'About Us'],
                    'type'             => 'internal',
                    'url'              => '/about',
                    'target'           => '_self',
                    'order'            => $order++,
                    'is_active'        => true,
                    'mega_menu_schema' => ['type' => 'internal', 'page' => 'about', 'section' => '', 'target_blank' => false],
                ]);

                $subOrder = 0;
                $aboutSubs = [
                    ['title' => 'Corporate Heritage & Profile', 'section' => 'overview'],
                    ['title' => 'Mission, Vision & Core Values', 'section' => 'mission'],
                    ['title' => 'Leadership & Engineering Board', 'section' => 'leadership'],
                    ['title' => 'ISO 9001:2015 & DNV Standards', 'section' => 'certifications'],
                ];
                foreach ($aboutSubs as $sub) {
                    MenuItem::create([
                        'menu_id'          => $primary->id,
                        'parent_id'        => $about->id,
                        'title'            => ['en' => $sub['title']],
                        'type'             => 'internal',
                        'url'              => '/about#' . $sub['section'],
                        'target'           => '_self',
                        'order'            => $subOrder++,
                        'is_active'        => true,
                        'mega_menu_schema' => ['type' => 'internal', 'page' => 'about', 'section' => $sub['section'], 'target_blank' => false],
                    ]);
                }

                // 3. Services
                $services = MenuItem::create([
                    'menu_id'          => $primary->id,
                    'parent_id'        => null,
                    'title'            => ['en' => 'Services'],
                    'type'             => 'internal',
                    'url'              => '/services',
                    'target'           => '_self',
                    'order'            => $order++,
                    'is_active'        => true,
                    'mega_menu_schema' => ['type' => 'internal', 'page' => 'services', 'section' => '', 'target_blank' => false],
                ]);

                $srvOrder = 0;
                $serviceSubs = [
                    ['title' => 'Dynamic Rotor Balancing (100k RPM)', 'section' => 'balancing'],
                    ['title' => 'Turbine Blading & TIG Welding', 'section' => 'overhaul'],
                    ['title' => 'Cartridge (CHRA) Exchange & Rebuild', 'section' => 'cartridge'],
                    ['title' => 'Ultrasonic Chemical Cleaning', 'section' => 'ultrasonic'],
                    ['title' => '24/7 Port Flying Squads to Vessel', 'section' => 'flying-squad'],
                ];
                foreach ($serviceSubs as $sub) {
                    MenuItem::create([
                        'menu_id'          => $primary->id,
                        'parent_id'        => $services->id,
                        'title'            => ['en' => $sub['title']],
                        'type'             => 'internal',
                        'url'              => '/services#' . $sub['section'],
                        'target'           => '_self',
                        'order'            => $srvOrder++,
                        'is_active'        => true,
                        'mega_menu_schema' => ['type' => 'internal', 'page' => 'services', 'section' => $sub['section'], 'target_blank' => false],
                    ]);
                }

                // 4. Business Units
                MenuItem::create([
                    'menu_id'          => $primary->id,
                    'parent_id'        => null,
                    'title'            => ['en' => 'Business Units'],
                    'type'             => 'internal',
                    'url'              => '/#divisions',
                    'target'           => '_self',
                    'order'            => $order++,
                    'is_active'        => true,
                    'mega_menu_schema' => ['type' => 'internal', 'page' => 'home', 'section' => 'partners', 'target_blank' => false],
                ]);

                // 5. Projects & Media
                $projects = MenuItem::create([
                    'menu_id'          => $primary->id,
                    'parent_id'        => null,
                    'title'            => ['en' => 'Projects & Media'],
                    'type'             => 'internal',
                    'url'              => '/projects',
                    'target'           => '_self',
                    'order'            => $order++,
                    'is_active'        => true,
                    'mega_menu_schema' => ['type' => 'internal', 'page' => 'projects', 'section' => '', 'target_blank' => false],
                ]);

                $prjOrder = 0;
                $projectSubs = [
                    ['title' => 'Industrial Projects', 'section' => 'projects'],
                    ['title' => 'Video Gallery (Hover Play)', 'section' => 'videos'],
                    ['title' => 'Photo Gallery & Workshops', 'section' => 'photos'],
                ];
                foreach ($projectSubs as $sub) {
                    MenuItem::create([
                        'menu_id'          => $primary->id,
                        'parent_id'        => $projects->id,
                        'title'            => ['en' => $sub['title']],
                        'type'             => 'internal',
                        'url'              => '/projects#' . $sub['section'],
                        'target'           => '_self',
                        'order'            => $prjOrder++,
                        'is_active'        => true,
                        'mega_menu_schema' => ['type' => 'internal', 'page' => 'projects', 'section' => $sub['section'], 'target_blank' => false],
                    ]);
                }

                // 6. Contact
                MenuItem::create([
                    'menu_id'          => $primary->id,
                    'parent_id'        => null,
                    'title'            => ['en' => 'Contact'],
                    'type'             => 'internal',
                    'url'              => '/contact',
                    'target'           => '_self',
                    'order'            => $order++,
                    'is_active'        => true,
                    'mega_menu_schema' => ['type' => 'internal', 'page' => 'contact', 'section' => '', 'target_blank' => false],
                ]);
            });
        }
    }

    public function loadSelectedMenu(): void
    {
        $menu = null;
        if ($this->selectedMenuId) {
            $menu = Menu::find($this->selectedMenuId);
        }

        if (!$menu) {
            $menu = Menu::where('location', 'primary')->first() ?: Menu::first();
        }

        if ($menu) {
            $this->selectedMenuId = $menu->id;
            $this->menuName = $menu->name;
            $this->menuLocation = $menu->location ?? 'custom';
            $this->buildItemsList($menu->id);
        } else {
            $this->items = [];
        }
    }

    public function selectMenu(int $id): void
    {
        $this->selectedMenuId = $id;
        $this->expandedIndex = null;
        $this->loadSelectedMenu();
    }

    /**
     * Flatten nested menu items into ordered list with depth indicators for intuitive tree editing.
     */
    protected function buildItemsList(int $menuId): void
    {
        $rootItems = MenuItem::where('menu_id', $menuId)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $flat = [];
        foreach ($rootItems as $root) {
            $flat[] = $this->formatItem($root, 0);

            // Level 1 children
            $children = MenuItem::where('parent_id', $root->id)->orderBy('order')->get();
            foreach ($children as $child) {
                $flat[] = $this->formatItem($child, 1);

                // Level 2 grandchildren
                $grandchildren = MenuItem::where('parent_id', $child->id)->orderBy('order')->get();
                foreach ($grandchildren as $gc) {
                    $flat[] = $this->formatItem($gc, 2);
                }
            }
        }

        $this->items = $flat;
    }

    protected function formatItem(MenuItem $item, int $depth): array
    {
        $smartLink = $item->mega_menu_schema;
        if (empty($smartLink) || !is_array($smartLink)) {
            $smartLink = [
                'type'         => 'external',
                'url'          => $item->url ?: '#',
                'target_blank' => ($item->target === '_blank'),
                'label'        => $item->display_title,
            ];
        }

        return [
            'id'        => $item->id,
            'temp_id'   => 'item_' . $item->id,
            'parent_id' => $item->parent_id,
            'depth'     => $depth,
            'title'     => $item->display_title,
            'link'      => $smartLink,
            'is_active' => (bool) $item->is_active,
            'order'     => (int) $item->order,
        ];
    }

    public function toggleItem(int $index): void
    {
        $this->expandedIndex = ($this->expandedIndex === $index) ? null : $index;
    }

    public function addNewItem(): void
    {
        $newId = 'temp_' . uniqid();
        $this->items[] = [
            'id'        => null,
            'temp_id'   => $newId,
            'parent_id' => null,
            'depth'     => 0,
            'title'     => 'New Menu Item',
            'link'      => ['type' => 'internal', 'page' => 'home', 'section' => '', 'target_blank' => false],
            'is_active' => true,
            'order'     => count($this->items),
        ];
        $this->expandedIndex = count($this->items) - 1;
    }

    public function removeItem(int $index): void
    {
        if (isset($this->items[$index])) {
            array_splice($this->items, $index, 1);
            if ($this->expandedIndex === $index) {
                $this->expandedIndex = null;
            } elseif ($this->expandedIndex > $index) {
                $this->expandedIndex--;
            }
        }
    }

    public function moveItem(int $index, string $direction): void
    {
        $targetIndex = $direction === 'up' ? $index - 1 : $index + 1;
        if ($targetIndex >= 0 && $targetIndex < count($this->items)) {
            $temp = $this->items[$index];
            $this->items[$index] = $this->items[$targetIndex];
            $this->items[$targetIndex] = $temp;
            $this->expandedIndex = $targetIndex;
        }
    }

    /**
     * Indent item right (make child of previous item).
     */
    public function indentItem(int $index): void
    {
        if ($index > 0) {
            $prev = $this->items[$index - 1];
            if ($this->items[$index]['depth'] <= $prev['depth']) {
                $this->items[$index]['depth'] = min(2, $this->items[$index]['depth'] + 1);
                $this->items[$index]['parent_id'] = $prev['id'] ?? $prev['temp_id'];
            }
        }
    }

    /**
     * Outdent item left (promote towards root).
     */
    public function outdentItem(int $index): void
    {
        if ($this->items[$index]['depth'] > 0) {
            $this->items[$index]['depth']--;
            if ($this->items[$index]['depth'] === 0) {
                $this->items[$index]['parent_id'] = null;
            } else {
                // Find nearest item above with depth - 1
                for ($j = $index - 1; $j >= 0; $j--) {
                    if ($this->items[$j]['depth'] === ($this->items[$index]['depth'] - 1)) {
                        $this->items[$index]['parent_id'] = $this->items[$j]['id'] ?? $this->items[$j]['temp_id'];
                        break;
                    }
                }
            }
        }
    }

    /**
     * Quick-add selected pages into menu.
     */
    public function quickAddPages(): void
    {
        $pages = LinkResolver::getAvailablePages();
        foreach ($this->selectedPages as $slug) {
            $matched = collect($pages)->firstWhere('slug', $slug);
            if ($matched) {
                $this->items[] = [
                    'id'        => null,
                    'temp_id'   => 'temp_' . uniqid(),
                    'parent_id' => null,
                    'depth'     => 0,
                    'title'     => $matched['title'],
                    'link'      => ['type' => 'internal', 'page' => $slug, 'section' => '', 'target_blank' => false],
                    'is_active' => true,
                    'order'     => count($this->items),
                ];
            }
        }
        $this->selectedPages = [];
        session()->flash('message', 'Selected pages added to menu.');
    }

    /**
     * Quick-add selected dynamic services into menu.
     */
    public function quickAddServices(): void
    {
        $services = LinkResolver::getDynamicServices();
        foreach ($this->selectedServices as $slug) {
            $matched = collect($services)->firstWhere('slug', $slug);
            if ($matched) {
                $this->items[] = [
                    'id'        => null,
                    'temp_id'   => 'temp_' . uniqid(),
                    'parent_id' => null,
                    'depth'     => 0,
                    'title'     => $matched['title'],
                    'link'      => ['type' => 'service', 'service_slug' => $slug, 'target_blank' => false],
                    'is_active' => true,
                    'order'     => count($this->items),
                ];
            }
        }
        $this->selectedServices = [];
        session()->flash('message', 'Selected services added to menu.');
    }

    public function createMenu(): void
    {
        $this->validate([
            'newMenuName'     => 'required|string|max:100',
            'newMenuLocation' => 'required|string|max:50',
        ]);

        $menu = Menu::create([
            'name'     => $this->newMenuName,
            'location' => $this->newMenuLocation,
        ]);

        $this->newMenuName = '';
        $this->showCreateModal = false;
        $this->selectMenu($menu->id);

        session()->flash('message', "Menu '{$menu->name}' created successfully.");
    }

    public function deleteCurrentMenu(): void
    {
        if ($this->selectedMenuId) {
            $menu = Menu::find($this->selectedMenuId);
            if ($menu) {
                $name = $menu->name;
                $menu->items()->delete();
                $menu->delete();

                $this->selectedMenuId = null;
                $this->loadSelectedMenu();
                session()->flash('message', "Menu '{$name}' deleted.");
            }
        }
    }

    /**
     * Save the entire multi-layer menu hierarchy to database.
     */
    public function saveMenu(): void
    {
        if (!$this->selectedMenuId) {
            return;
        }

        $menu = Menu::findOrFail($this->selectedMenuId);
        $menu->update([
            'name'     => $this->menuName,
            'location' => $this->menuLocation,
        ]);

        DB::transaction(function () use ($menu) {
            // Mapping from temp_id/existing_id to newly saved database IDs
            $idMap = [];
            $savedIds = [];

            // First pass: save root items (depth 0)
            foreach ($this->items as $order => $itemData) {
                if ($itemData['depth'] === 0) {
                    $saved = $this->persistItem($menu->id, null, $itemData, $order);
                    $savedIds[] = $saved->id;
                    $idMap[$itemData['id'] ?? $itemData['temp_id']] = $saved->id;
                }
            }

            // Second pass: save level 1 children
            foreach ($this->items as $order => $itemData) {
                if ($itemData['depth'] === 1) {
                    $parentKey = $itemData['parent_id'] ?? null;
                    $actualParentId = $idMap[$parentKey] ?? null;
                    $saved = $this->persistItem($menu->id, $actualParentId, $itemData, $order);
                    $savedIds[] = $saved->id;
                    $idMap[$itemData['id'] ?? $itemData['temp_id']] = $saved->id;
                }
            }

            // Third pass: save level 2 grandchildren
            foreach ($this->items as $order => $itemData) {
                if ($itemData['depth'] === 2) {
                    $parentKey = $itemData['parent_id'] ?? null;
                    $actualParentId = $idMap[$parentKey] ?? null;
                    $saved = $this->persistItem($menu->id, $actualParentId, $itemData, $order);
                    $savedIds[] = $saved->id;
                }
            }

            // Delete items that were removed
            MenuItem::where('menu_id', $menu->id)->whereNotIn('id', $savedIds)->delete();
        });

        $this->loadSelectedMenu();
        session()->flash('message', "Navigation menu '{$menu->name}' saved & published successfully!");
    }

    protected function persistItem(int $menuId, ?int $parentId, array $data, int $order): MenuItem
    {
        $resolved = LinkResolver::resolve($data['link'] ?? []);

        $attributes = [
            'menu_id'          => $menuId,
            'parent_id'        => $parentId,
            'title'            => ['en' => $data['title'] ?: 'Untitled'],
            'type'             => $data['link']['type'] ?? 'internal',
            'url'              => $resolved['url'],
            'target'           => $resolved['target'],
            'order'            => $order,
            'is_active'        => $data['is_active'] ?? true,
            'mega_menu_schema' => $data['link'] ?? [],
        ];

        if (!empty($data['id'])) {
            $existing = MenuItem::where('id', $data['id'])->where('menu_id', $menuId)->first();
            if ($existing) {
                $existing->update($attributes);
                return $existing;
            }
        }

        return MenuItem::create($attributes);
    }

    public function render()
    {
        return view('livewire.admin.menus.menu-manager', [
            'availableMenus'    => Menu::withCount('items')->get(),
            'availablePages'    => LinkResolver::getAvailablePages(),
            'availableServices' => LinkResolver::getDynamicServices(),
        ])->title('Navigation Menu Builder | Nordroy CMS');
    }
}
