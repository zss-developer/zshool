<!-- BEGIN DEFAULT SIDEBAR -->
<div class="ks-column ks-sidebar ks-info">
    <div class="ks-wrapper">
        <ul class="nav nav-pills nav-stacked">
            @foreach($storage_sections as $item)
                <li class="nav-item {{ Request::segment(2) == $item->code ? 'open':'' }}">
                    <a class="nav-link" href="{{ route('storage.index', $item->code) }}">
                        <span class="ks-icon la la-book"></span>
                        <span>{{ $item->name }}</span>
                    </a>
                </li>
            @endforeach

        </ul>

        <div class="ks-sidebar-extras-block pt-2">
            <div class="ks-sidebar-copyright mt-0">Разработка и поддержка — ЗСШ №1<br>© {{ date('Y') }}</div>
        </div>
    </div>
</div>
<!-- END DEFAULT SIDEBAR -->