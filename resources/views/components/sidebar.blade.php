<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">AdminKit</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Main Menu
            </li>

            <x-partials.nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="align-middle" data-feather="sliders"></i>
                <span class="align-middle">Dashboard</span>
            </x-partials.nav-link>

            <x-partials.nav-link :href="route('project.index')" :active="request()->routeIs('project.*')">
                <i class="align-middle" data-feather="sliders"></i>
                <span class="align-middle">Projects</span>
            </x-partials.nav-link>

            <x-partials.nav-link :href="route('vendor.index')" :active="request()->routeIs('vendor.*')">
                <i class="align-middle" data-feather="sliders"></i>
                <span class="align-middle">Vendors</span>
            </x-partials.nav-link>

            <x-partials.nav-link :href="route('client.index')" :active="request()->routeIs('client.*')">
                <i class="align-middle" data-feather="sliders"></i>
                <span class="align-middle">Clients</span>
            </x-partials.nav-link>
        </ul>
    </div>
</nav>
