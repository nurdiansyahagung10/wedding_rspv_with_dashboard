@foreach ($wishes as $wish)
<li class="flex gap-4 py-5">
    <span aria-hidden="true" class="shrink-0 w-10 h-10 rounded-full bg-gold/10 text-goldDark font-serif text-lg flex items-center justify-center">{{ mb_strtoupper(mb_substr($wish->name, 0, 1)) }}</span>
    <div class="min-w-0">
        <p class="font-serif text-base leading-relaxed text-ink whitespace-pre-line break-words">{{ \Illuminate\Support\Str::limit($wish->wishes, 600) }}</p>
        <p class="text-xs font-semibold tracking-wide text-goldDark mt-2">{{ $wish->name }}</p>
    </div>
</li>
@endforeach
