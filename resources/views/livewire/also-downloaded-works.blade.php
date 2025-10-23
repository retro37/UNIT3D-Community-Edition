<section class="panelV2">
    <header class="panel__header">
        <h2 class="panel__heading">Also downloaded</h2>
        <div class="panel__actions" x-data="posterRow">
            <div class="panel__action">
                <button class="form__standard-icon-button" x-bind="scrollLeft">
                    <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                </button>
            </div>
            <div class="panel__action">
                <button class="form__standard-icon-button" x-bind="scrollRight">
                    <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                </button>
            </div>
        </div>
    </header>
    <div
        class="panel__body collection-posters"
        x-ref="posters"
        style="max-height: 330px !important"
    >
        @foreach ($alsoDownloadedWorks as $alsoDownloadedWork)
            <figure class="trending-poster">
                @switch(true)
                    @case($alsoDownloadedWork instanceof \App\Models\TmdbMovie)
                        <x-movie.poster :movie="$alsoDownloadedWork" :$categoryId />

                        @break
                    @case($alsoDownloadedWork instanceof \App\Models\TmdbTv)
                        <x-tv.poster :tv="$alsoDownloadedWork" :$categoryId />

                        @break
                    @case($alsoDownloadedWork instanceof \App\Models\IgdbGame)
                        <x-game.poster :game="$alsoDownloadedWork" :$categoryId />

                        @break
                @endswitch
                <figcaption class="trending-poster__download-count" title="Times downloaded">
                    {{ $alsoDownloadedWork->total }}
                </figcaption>
            </figure>
        @endforeach
    </div>
</section>
