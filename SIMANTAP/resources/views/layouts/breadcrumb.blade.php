<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">{{ $title ?? 'Dashboard' }}</h4>

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            @foreach ($breadcrumbs ?? [] as $breadcrumb)
                @if (!$loop->last)
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb['label'] }}</li>
                @endif
            @endforeach
        </ol>
    </div>
</div>