@forelse ($feedback as $item)
    <div class="mb-3 p-3 rounded bg-light border">
        @php
            $nilai = $item->rating->rating_id ?? 0;
            $max = 5;
        @endphp
        <div class="d-flex justify-content-center gap-1 mb-2">
            @for ($i = 1; $i <= $max; $i++)
                {!! $i <= $nilai
                    ? '<span style="font-size: 2rem; color: gold;">&#9733;</span>'
                    : '<span style="font-size: 2rem; color: #ccc;">&#9734;</span>' !!}
            @endfor
        </div>
        <div style="text-align: left;">
            <p style="margin-bottom: 0;"><strong>Komentar:</strong></p>
            <p class="mb-0">{{ $item->komentar ?: '-' }}</p>
        </div>
    </div>
@empty
    <p class="text-muted">Belum ada feedback dari pelapor.</p>
@endforelse
