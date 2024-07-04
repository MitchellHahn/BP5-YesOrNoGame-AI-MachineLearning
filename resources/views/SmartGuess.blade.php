<?php //@extends('layouts.app')?>
{{--wordt gebruikt voor smart guess--}}
<h4>Game</h4>
<br>
start

{{-- controleert als er een smart Guess input node bestaat --}}
@if(isset($smartGuessPredictionNodeId))

    {{--toon de id van smart Guess input node   --}}
    <div>Smart Guess Prediction Node ID: {{ $smartGuessPredictionNodeId }}</div>
@endif

{{-- toon vraag van de smart Guess input node --}}
<div>{{ $node->question }}</div>

{{-- toon antwoord van de smart Guess input node --}}
<div>{{ $node->answer }}</div>

{{-- voert de functie van route "yes" --}}
<a class="button" href="{{ route('Yes', ['node' => $node->id]) }}">Yes</a>

{{-- voert de functie van route "no" --}}
<a class="button" href="{{ route('No', ['node' => $node->id]) }}">No</a>
