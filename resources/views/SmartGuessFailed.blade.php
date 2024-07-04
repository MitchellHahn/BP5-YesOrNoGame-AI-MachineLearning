<?php //@extends('layouts.app')?>
{{--wordt gebruikt voor smartguess reset--}}
<h4>Game</h4>
<br>
start

{{-- controleert als er een smart Guess input node bestaat --}}
@if(isset($SmartGuess_InputNode))
                    {{--toon de id van smart Guess input node   --}}
    <div>Smart Guess Failed! Jumped back to Smart Guess Input Node ID: {{ $SmartGuess_InputNode }}</div>
@endif

{{-- toon vraag van de smart Guess input node --}}
<div>{{ $node->question }}</div>


{{-- toon antwoord van de smart Guess input node --}}
<div>{{ $node->answer }}</div>

{{-- voert de functie van route "yes" --}}
<a class="button" href="{{ route('Yes', ['node' => $node->id]) }}">Yes</a>

{{-- voert de functie van route "no" --}}
<a class="button" href="{{ route('No', ['node' => $node->id]) }}">No</a>
