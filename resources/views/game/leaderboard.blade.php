<style>
    ul {
        list-style: none;
        padding: 0;
    }
    ul > li {
        padding: 10px;
    }
</style>

<h3>Leaderboard</h3>
<ul id="leaderboard"></ul>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="container-xl containerSupportedContent" >
    <table class="table table-bordered">
        <tr class="tablehead tableheadSupportedContent">

            <th class="tableheadfont tableheadfontSupportedContent">Naam</th>

            <th class="tableheadfont tableheadfontSupportedContent">Score</th>

        </tr>
{{--        for elke score --}}
        @foreach ($scores as $score)

            <tr class="tablerow">
                <td class="tablerowcell tablerowcellSupportedContent">
                    {{-- naam van score--}}
                    {{ $score->naam	 }}
                    <div class=" tablerowcellSupportedContent">

                    </div>

                </td>
                                                {{--   core van score--}}
                <td class="tablerowcell tablerowcellSupportedContent">{{ $score->score }}</td>

                <td class="tablerowcell">

                </td>
            </tr>
        @endforeach

        <script src="{{ asset('js/game.js') }}?v={{ time() }}"></script>
<script>
    // getLeaderboard();
</script>
