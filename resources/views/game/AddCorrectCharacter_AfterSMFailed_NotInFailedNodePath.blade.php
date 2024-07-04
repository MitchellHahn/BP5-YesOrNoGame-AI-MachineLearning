
<div class="alert alert-success">
</div>
{{--@else--}}
<div class="row justify-content-center">
    <div class="col-sm-5">
        <!-- Your form to add a new character -->
        <form action="{{ route('Add') }}" method="POST">
            @csrf
            <h3>Add character</h3>
                    {{--  id van verloren character gebruiken voor verplaasing in de boom  --}}
            <input type="hidden" value="{{ $currentNodeId }}" name="current_node" />
            <div class="form-group">
                <label>Question to distinguish character</label>
                <input type="text" name="question" class="form-control" placeholder="Question">
            </div>
            <div class="form-group">
                <label>Final answer / Character</label>
                <input type="text" name="answer" class="form-control" placeholder="Answer">
            </div>
            <button type="submit" onclick="addExtraPoints();">Submit</button>
        </form>
    </div>
</div>

{{--voeg extra punten om speler heeft gewonnen--}}
<script>
    function addExtraPoints() {
        let points = localStorage.getItem("points") || 0;
        points = Number(points) + 22;
        localStorage.setItem("points", points);
    }
</script>
