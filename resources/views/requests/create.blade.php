@extends('layout.with-main-and-sidebar')

@section('title')
    <title>{{ __('request.add-request') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('requests.index') }}" class="breadcrumb__link">
            {{ __('request.requests') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.new-adj') }}
    </li>
@endsection

@section('page', 'page__request--create')

@section('main')
    @if ($user->can_request ?? $user->group->can_request)
        <section
            class="panelV2"
            x-data="{
                cat: {{ (int) $category_id }},
                cats: JSON.parse(atob('{{ base64_encode(json_encode($categories)) }}')),
            }"
        >
            <h2 class="panel__heading">{{ __('request.add-request') }}</h2>
            <div class="panel__body">
                <form class="form" method="POST" action="{{ route('requests.store') }}">
                    @csrf
                    <p class="form__group">
                        <input
                            id="title"
                            class="form__text"
                            name="name"
                            required
                            type="text"
                            value="{{ $title ?: old('name') }}"
                        />
                        <label class="form__label form__label--floating" for="title">
                            {{ __('request.title') }}
                        </label>
                    </p>
                    <p class="form__group">
                        <select
                            name="category_id"
                            id="category_id"
                            class="form__select"
                            required
                            x-model="cat"
                            x-on:change="cats[cat].type = cats[$event.target.value].type;"
                        >
                            <option hidden selected disabled value=""></option>
                            @foreach ($categories as $id => $category)
                                <option
                                    class="form__option"
                                    value="{{ $id }}"
                                    @selected((old('category_id') ?: $category_id) == $id)
                                >
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form__label form__label--floating" for="category_id">
                            {{ __('request.category') }}
                        </label>
                    </p>
                    <p class="form__group">
                        <select id="type_id" class="form__select" name="type_id" required>
                            <option hidden disabled selected value=""></option>
                            @foreach ($types as $type)
                                <option
                                    value="{{ $type->id }}"
                                    @selected(old('type_id') == $type->id)
                                >
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form__label form__label--floating" for="type_id">
                            {{ __('request.type') }}
                        </label>
                    </p>
                    <p class="form__group">
                        <select
                            id="resolution_id"
                            class="form__select"
                            name="resolution_id"
                            required
                        >
                            <option hidden disabled selected value=""></option>
                            @foreach ($resolutions as $resolution)
                                <option
                                    value="{{ $resolution->id }}"
                                    @selected(old('resolution_id') == $resolution->id)
                                >
                                    {{ $resolution->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form__label form__label--floating" for="resolution_id">
                            {{ __('request.resolution') }}
                        </label>
                    </p>
                    <div
                        class="form__group--horizontal"
                        x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv' || cats[cat].type === 'game'"
                    >
                        <p
                            class="form__group"
                            x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                        >
                            <input type="hidden" name="tmdb" value="0" />
                            <input
                                id="autotmdb"
                                class="form__text"
                                inputmode="numeric"
                                name="tmdb"
                                pattern="[0-9]*"
                                required
                                type="text"
                                x-bind:value="cats[cat].type === 'movie' || cats[cat].type === 'tv' ? '{{ $tmdb ?: old('tmdb') }}' : '0'"
                                x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                            />
                            <label class="form__label form__label--floating" for="autotmdb">
                                TMDB ID
                            </label>
                            <span class="form__hint">Numeric digits only.</span>
                        </p>
                        <p
                            class="form__group"
                            x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                        >
                            <input type="hidden" name="imdb" value="0" />
                            <input
                                id="autoimdb"
                                class="form__text"
                                inputmode="numeric"
                                name="imdb"
                                pattern="[0-9]*"
                                required
                                type="text"
                                x-bind:value="cats[cat].type === 'movie' || cats[cat].type === 'tv' ? '{{ $imdb ?: old('imdb') }}' : '0'"
                                x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                            />
                            <label class="form__label form__label--floating" for="autoimdb">
                                IMDB ID
                            </label>
                            <span class="form__hint">Numeric digits only.</span>
                        </p>
                        <p class="form__group" x-show="cats[cat].type === 'tv'">
                            <input type="hidden" name="tvdb" value="0" />
                            <input
                                id="autotvdb"
                                class="form__text"
                                inputmode="numeric"
                                name="tvdb"
                                pattern="[0-9]*"
                                placeholder=" "
                                type="text"
                                x-bind:value="cats[cat].type === 'tv' ? '{{ $tvdb ?: old('tvdb') }}' : '0'"
                                x-bind:required="cats[cat].type === 'tv'"
                            />
                            <label class="form__label form__label--floating" for="autotvdb">
                                TVDB ID
                            </label>
                            <span class="form__hint">Numeric digits only.</span>
                        </p>
                        <p
                            class="form__group"
                            x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                        >
                            <input type="hidden" name="mal" value="0" />
                            <input
                                id="automal"
                                class="form__text"
                                inputmode="numeric"
                                name="mal"
                                pattern="[0-9]*"
                                placeholder=" "
                                type="text"
                                x-bind:value="cats[cat].type === 'movie' || cats[cat].type === 'tv' ? '{{ $mal ?: old('mal') }}' : '0'"
                                x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                            />
                            <label class="form__label form__label--floating" for="automal">
                                MAL ID ({{ __('torrent.required-anime') }})
                            </label>
                            <span class="form__hint">
                                Numeric digits only. Required for anime. Use 0 otherwise.
                            </span>
                        </p>
                        <p class="form__group" x-show="cats[cat].type === 'game'">
                            <input
                                id="igdb"
                                class="form__text"
                                inputmode="numeric"
                                name="igdb"
                                pattern="[0-9]*"
                                placeholder
                                type="text"
                                x-bind:value="cats[cat].type === 'game' ? '{{ $igdb ?: old('igdb') }}' : '0'"
                                x-bind:required="cats[cat].type === 'game'"
                            />
                            <label class="form__label form__label--floating" for="igdb">
                                IGDB ID ({{ __('request.required') }} For Games)
                            </label>
                        </p>
                    </div>
                    @livewire('bbcode-input', [
                        'name' => 'description',
                        'label' => __('request.description'),
                        'required' => true
                    ])
                    <p class="form__group">
                        <input
                            id="bounty"
                            class="form__text"
                            name="bounty"
                            type="text"
                            pattern="[0-9]*?[1-9][0-9]{2,}"
                            value="100"
                            required
                        />
                        <label class="form__label form__label--floating" for="bounty">
                            {{ __('request.reward') }} ({{ __('request.reward-desc') }})
                        </label>
                    </p>
                    <p class="form__group">
                        <input type="hidden" name="anon" value="0" />
                        <input
                            type="checkbox"
                            class="form__checkbox"
                            id="anon"
                            name="anon"
                            value="1"
                            @checked(old('anon'))
                        />
                        <label class="form__label" for="anon">{{ __('common.anonymous') }}?</label>
                    </p>
                    <p class="form__group">
                        <button class="form__button form__button--filled">
                            {{ __('common.submit') }}
                        </button>
                    </p>
                </form>
            </div>
        </section>
    @else
        <section class="panelV2">
            <h2 class="panel__heading">
                <i class="{{ config('other.font-awesome') }} fa-times text-danger"></i>
                {{ __('request.no-privileges') }}!
            </h2>
            <p class="panel__body">{{ __('request.no-privileges-desc') }}!</p>
        </section>
    @endif
@endsection

@if ($user->can_request ?? $user->group->can_request)
    @section('sidebar')
        <section class="panelV2">
            <h2 class="panel__heading">{{ __('common.info') }}</h2>
            <div class="panel__body">
                {{ __('request.no-imdb-id') }}
            </div>
        </section>
    @endsection
@endif
