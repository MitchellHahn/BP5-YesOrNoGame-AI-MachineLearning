<?php //@extends('layouts.app')?>
{{--@extends('layouts.user.functietoevoegen.layout')--}}
<h4>Game</h4>
<br>
start

{{-- Check if the smartGuessPredictionNodeId is set --}}
@if(isset($smartGuessPredictionNodeId))
    <div>Smart Guess Prediction Node ID: {{ $smartGuessPredictionNodeId }}</div>
@endif

{{-- Assuming $node is defined and accessible --}}
<div>{{ $node->question }}</div>
<div>{{ $node->answer }}</div>

<a class="button" href="{{ route('Yes', ['node' => $node->id]) }}">Yes</a>
<a class="button" href="{{ route('No', ['node' => $node->id]) }}">No</a>
