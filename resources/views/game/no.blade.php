



<!--voeg extra punten omdat speler heeft gewonnen-->
<script>
    function addExtraPoints() {
        let points = localStorage.getItem("points") || 0;
        points = Number(points)+22;

        localStorage.setItem("points", `${points}`);
    }
</script>

<section class="section">

    <div class="container-xl height100 containerSupportedContent">


        <div class="container-lg height70">
            <div class="row height100 justify-content-center">
                <div class="col-md-12 height100 sectioninner" style="align-self:flex-end;">


                        <div class="alert alert-success">
                        </div>


                    <div class="row justify-content-center">
                        <div class="col-sm-5">

                            {{--   als er (GEEN gerelateerd node, GEEN smart guess executed) is voer dit uit --}}
                            @if ($relation === null && !Cache::has('SmartGuess_Executed'))
                                <form action="{{ route('Add') }}" method="POST">


                                    @csrf
                                    <h3>add character</h3>

                                    <input type="hidden" value="{{ $node->id }}" name="current_node" />

                                    <div class="form-group">

                                        <label>Question to distinguish character</label>

                                        <input type="text" name="question" class="form-control collumntextSupportedContent" placeholder="question">

                                    </div>

                                    <div class="form-group">

                                        <label>Final answer / Character</label>

                                        <input type="text" name="answer" class="form-control collumntextSupportedContent" placeholder="answer">

                                    </div>

                                    <button type="submit" onclick="addExtraPoints();">Submit</button>
                                </form>

                                {{--   als er (GEEN gerelateerd node, smart guess failed, curent node does not lie within failednode path) is voer dit uit --}}
                            @elseif ($relation === null && Cache::has('SmartGuess_Failed') && Cache::has('CurrentNode_DoesNotLieIn_FailedNodePath'))
                                    <form action="{{ route('Add') }}" method="POST">


                                    @csrf
                                    <h3>add character</h3>
                                    <input type="hidden" value="{{ $node->id }}" name="current_node" />

                                    <div class="form-group">

                                        <label>Question to distinguish character</label>

                                        <input type="text" name="question" class="form-control collumntextSupportedContent" placeholder="question">

                                    </div>

                                    <div class="form-group">

                                        <label>Final answer / Character</label>

                                        <input type="text" name="answer" class="form-control collumntextSupportedContent" placeholder="answer">

                                    </div>

                                        <button type="submit" onclick="addExtraPoints();">Submit</button>
                                    </form>

                            {{--   als er een gerelateerd node is voer dit uit --}}
                            @elseif ($relation !== null)
                                <div class="row justify-content-center">
                                    <div class="col-8 col-sm-7">
                                        <span class="timer">5 seconds left.<br /><br /></span>
                                        <label>

                                            {{-- toon gerelateerde vraag van de node --}}
                                            {{ $relation->question }}

                                            {{-- toon gerelateerde antwoord van de node --}}
                                            {{ $relation->answer }}
                                        </label>
                                    </div>
                                </div>

                                {{--  gaat route yes gerelateerd node te vinden --}}
                                <a class="button" href="#" onclick="addPoints('{{ route('Yes',$relation->id) }}')">Yes</a>

                                {{--  gaat route no gerelateerd node te vinden --}}
                                <a class="button" href="#" onclick="addPoints('{{ route('No',$relation->id) }}')">No</a>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script defer src="{{ asset('js/game.js') }}?v={{time()}}"></script>
</section>




