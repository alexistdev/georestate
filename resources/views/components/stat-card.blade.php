{{--
    Kartu statistik dashboard (admin & agen).
    Pemakaian: <x-stat-card label="Listing Tayang" :nilai="12" ikon="ri-home-4-line" warna="success" :link="..." catatan="..." />
    warna: primary | success | warning | danger | info | secondary
--}}
@props(['label', 'nilai', 'ikon', 'warna' => 'primary', 'link' => null, 'catatan' => null])

@once
    @push('customCSS')
        <style>
            .stat-card {
                --stat-rgb: var(--vz-primary-rgb);
                --stat-fg: #3f6ad8;
                position: relative;
                height: 100%;
                margin-bottom: 0;
                border: 0;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 1px 2px rgba(16, 24, 40, .04), 0 4px 16px rgba(16, 24, 40, .06);
                transition: transform .2s ease, box-shadow .2s ease;
            }
            .stat-card::before {
                content: "";
                position: absolute;
                inset: 0 0 auto 0;
                height: 3px;
                background: rgb(var(--stat-rgb));
            }
            .stat-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 2px 4px rgba(16, 24, 40, .06), 0 12px 28px rgba(16, 24, 40, .10);
            }
            .stat-card .card-body { display: flex; align-items: flex-start; gap: 16px; padding: 20px; }
            .stat-card__label {
                font-size: 12px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase;
                color: var(--vz-gray-600, #878a99); margin-bottom: 10px;
            }
            .stat-card__nilai { font-size: 28px; font-weight: 600; line-height: 1; margin-bottom: 10px; color: var(--vz-heading-color, #212529); }
            .stat-card__link { font-size: 13px; font-weight: 500; color: var(--stat-fg); text-decoration: none; }
            .stat-card__link:hover { text-decoration: underline; color: var(--stat-fg); }
            .stat-card__catatan { font-size: 12px; color: var(--vz-gray-600, #878a99); }
            .stat-card__ikon {
                flex-shrink: 0; margin-left: auto;
                width: 48px; height: 48px; border-radius: 12px;
                display: flex; align-items: center; justify-content: center;
                font-size: 24px;
                background: rgba(var(--stat-rgb), .14);
                color: var(--stat-fg);
            }
            .stat-card--primary   { --stat-rgb: var(--vz-primary-rgb);   --stat-fg: #3f6ad8; }
            .stat-card--success   { --stat-rgb: var(--vz-success-rgb);   --stat-fg: #0b8a4a; }
            .stat-card--warning   { --stat-rgb: var(--vz-warning-rgb);   --stat-fg: #a8780f; }
            .stat-card--danger    { --stat-rgb: var(--vz-danger-rgb);    --stat-fg: #cf3b3b; }
            .stat-card--info      { --stat-rgb: var(--vz-info-rgb);      --stat-fg: #1f8db0; }
            .stat-card--secondary { --stat-rgb: var(--vz-secondary-rgb); --stat-fg: #6b44c9; }
        </style>
    @endpush
@endonce

<div {{ $attributes->merge(['class' => 'card stat-card stat-card--'.$warna]) }}>
    <div class="card-body">
        <div class="flex-grow-1 overflow-hidden">
            <div class="stat-card__label">{{ $label }}</div>
            <div class="stat-card__nilai">{{ is_numeric($nilai) ? number_format($nilai, 0, ',', '.') : $nilai }}</div>
            @if($link)
                <a href="{{ $link }}" class="stat-card__link">Lihat detail <i class="ri-arrow-right-line align-middle"></i></a>
            @endif
            @if($catatan)
                <div class="stat-card__catatan mt-1">{{ $catatan }}</div>
            @endif
        </div>
        <div class="stat-card__ikon" aria-hidden="true">
            <i class="{{ $ikon }}"></i>
        </div>
    </div>
</div>
