@props([
    'projectId' => null
])

<nav class="nav nav-pills nav-fill">
    <x-partials.tab-link :href="route('project.show.dashboard', ['project' => $projectId])" :active="request()->routeIs('project.show.dashboard', ['project' => $projectId])">
        <span class="align-middle">Project Dashboard</span>
    </x-partials.tab-link>
    <x-partials.tab-link :href="route('project.show.cashflow.index', ['project' => $projectId])" :active="request()->routeIs('project.show.cashflow.*', ['project' => $projectId])">
        <span class="align-middle">Cashflow</span>
    </x-partials.tab-link>
    <x-partials.tab-link href="#" :active="false">
        <span class="align-middle">Tot</span>
    </x-partials.tab-link>
  </nav>
