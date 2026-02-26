@php
    /** @var \Alxarafe\Component\Container\TabGroup $container */
    /** @var array $record */
    $tabs    = $container->getTabs();
    $groupId = $container->getGroupId();
    $single  = count($tabs) === 1;
@endphp

@if($single)
    {{-- Single tab: render children directly without nav --}}
    @foreach($tabs[0]->getChildren() as $child)
        {!! \Alxarafe\Component\Container\AbstractContainer::renderChild($child, $record) !!}
    @endforeach
@else
    {{-- Multiple tabs: full Bootstrap nav-tabs --}}
    <ul class="nav nav-tabs mb-4" id="{{ $groupId }}-nav" role="tablist">
        @foreach($tabs as $i => $tab)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $i === 0 ? 'active' : '' }}"
                        id="{{ $groupId }}-{{ $tab->getTabId() }}-btn"
                        data-bs-toggle="tab"
                        data-bs-target="#{{ $groupId }}-{{ $tab->getTabId() }}"
                        type="button" role="tab">
                    @if($tab->getIcon())
                        <i class="{{ $tab->getIcon() }} me-1"></i>
                    @endif
                    {{ $tab->getLabel() }}
                </button>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="{{ $groupId }}-content">
        @foreach($tabs as $i => $tab)
            <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}"
                 id="{{ $groupId }}-{{ $tab->getTabId() }}" role="tabpanel">
                {!! $tab->render(['record' => $record]) !!}
            </div>
        @endforeach
    </div>
@endif
