<?php

// escape output to prevent XSS
function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// returns 'is-active' class
function is_active(string $key, string $current): string {
    return $key === $current ? 'is-active' : '';
}

// returns 'is-open' 
function is_group_active(array $keys, string $current): string {
    return in_array($current, $keys, true) ? 'is-open' : '';
}

// builds 1-2 letter initials (for avatars)
function initials(string $name): string {
    $parts = preg_split('/\s+/', trim($name));
    $out = '';
    foreach (array_slice($parts, 0, 2) as $p) {
        if ($p !== '') $out .= mb_strtoupper(mb_substr($p, 0, 1));
    }
    return $out ?: 'A';
}

// shrinks big numbers
function compact_number($n): string {
    $n = (int)$n;
    if ($n >= 1000000) return round($n / 1000000, 1) . 'M';
    if ($n >= 1000)    return round($n / 1000, 1) . 'K';
    return (string)$n;
}

// renders a colored status badge based
function status_badge(string $status): string {
    $map = [
        'active'    => ['ok',      'Active'],
        'published' => ['ok',      'Published'],
        'approved'  => ['ok',      'Approved'],
        'pending'   => ['warn',    'Pending'],
        'draft'     => ['neutral', 'Draft'],
        'rejected'  => ['danger',  'Rejected'],
        'inactive'  => ['neutral', 'Inactive'],
        'banned'    => ['danger',  'Banned'],
    ];
    $s = strtolower($status);
    [$tone, $label] = $map[$s] ?? ['neutral', ucfirst($s)];
    return '<span class="badge badge-' . $tone . '">' . e($label) . '</span>';
}

// returns CSS variable name for a category color
function category_color(string $slug): string {
    $map = [
        'anime'    => 'var(--cat-anime)',
        'gaming'   => 'var(--cat-gaming)',
        'movies'   => 'var(--cat-movies)',
        'tv-shows' => 'var(--cat-tv)',
        'kpop'     => 'var(--cat-kpop)',
        'comics'   => 'var(--cat-comics)',
        'manga'    => 'var(--cat-manga)',
        'cosplay'  => 'var(--cat-cosplay)',
    ];
    return $map[$slug] ?? 'var(--accent)';
}

// formats a date
function nice_date($date): string {
    if (!$date) return '—';
    $ts = is_numeric($date) ? (int)$date : strtotime($date);
    return $ts ? date('M j, Y', $ts) : '—';
}

// returns Font Awesome icon
function content_type_icon(string $type): string {
    $map = [
        'article' => 'fa-newspaper',
        'video'   => 'fa-play',
        'audio'   => 'fa-headphones',
        'image'   => 'fa-image',
    ];
    return $map[$type] ?? 'fa-file';
}

// returns Font Awesome icon class for a media type
function media_type_icon(string $type): string {
    $map = [
        'video' => 'fa-play',
        'audio' => 'fa-headphones',
        'image' => 'fa-image',
    ];
    return $map[$type] ?? 'fa-file';
}