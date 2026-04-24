@php
    /** @var \Alxarafe\Component\Container\TabGroup $container */
    /** @var array $record */
    $tabs    = $container->getFields();
    $groupId = $container->getField();
    $single  = count($tabs) === 1;
@endphp

@if($single)
    {{-- Single tab: render children directly without nav --}}
    @foreach($tabs[0]->getFields() as $child)
        @renderComponent($child, ['record' => $record ?? []])
    @endforeach
@else
    {{-- Multiple tabs: full Bootstrap nav-tabs --}}
    <ul class="nav nav-tabs mb-4" id="{{ $groupId }}-nav" role="tablist">
        @foreach($tabs as $i => $tab)
            <li class="nav-item" role="presentation">
                @if($tab->getUrl())
                    {{-- URL tab: renders as a plain link --}}
                    <a class="nav-link"
                       href="{{ $tab->getUrl() }}"
                       id="{{ $groupId }}-{{ $tab->getTabId() }}-btn">
                        @if($tab->getIcon())
                            <i class="{{ $tab->getIcon() }} me-1"></i>
                        @endif
                        {{ $tab->getLabel() }}
                        @if($tab->getBadgeCount() !== null)
                            <span class="{{ $tab->getBadgeClass() }}">{{ $tab->getBadgeCount() }}</span>
                        @endif
                    </a>
                @else
                    {{-- Inline tab: Bootstrap toggle button --}}
                    <button class="nav-link {{ $i === 0 ? 'active' : '' }}"
                            id="{{ $groupId }}-{{ $tab->getTabId() }}-btn"
                            data-bs-toggle="tab"
                            data-bs-target="#{{ $groupId }}-{{ $tab->getTabId() }}"
                            type="button" role="tab">
                        @if($tab->getIcon())
                            <i class="{{ $tab->getIcon() }} me-1"></i>
                        @endif
                        {{ $tab->getLabel() }}
                        @if($tab->getBadgeCount() !== null)
                            <span class="{{ $tab->getBadgeClass() }}">{{ $tab->getBadgeCount() }}</span>
                        @endif
                    </button>
                @endif
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="{{ $groupId }}-content">
        @foreach($tabs as $i => $tab)
            @if(!$tab->getUrl())
                <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}"
                     id="{{ $groupId }}-{{ $tab->getTabId() }}" role="tabpanel">
                    @renderComponent($tab, ['record' => $record])
                </div>
            @endif
        @endforeach
    </div>
@endif
