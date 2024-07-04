<?php //@extends('layouts.app')?>
{{--homee/start--}}
<h4>Game</h4>
<br>
start


{{-- toon vraag van node --}}
    <div>{{ $node->question }}</div>

{{-- toon antwoord node --}}
    <div>{{ $node->asnwer }}</div>


{{-- voert de functie van route "yes" --}}
    <a class="button" href="{{ route('Yes',$node->id) }}">Yes</a>

{{-- voert de functie van route "no" --}}
    <a class="button" href="{{ route('No',$node->id) }}">No</a>




