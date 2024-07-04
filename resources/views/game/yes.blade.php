

    <section class="section">

        <div class="container-xl height100 containerSupportedContent">


            <div class="container-lg height70">
                <div class="row height100 justify-content-center">
                    <div class="col-md-12 height100 sectioninner" style="align-self:flex-end;">


                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif


                        <div class="row justify-content-center">
                            <div class="col-sm-5">

yes
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

                                {{-- toon id van de node --}}
                                <input type="hidden" value="{{ $node->id }}" name="current_node" />

                                {{--  gaat route yes gerelateerd node te vinden --}}
                                <a class="button" href="#" onclick="addPoints('{{ route('Yes',$relation->id) }}')">Yes</a>

                                {{--  gaat route no gerelateerd node te vinden --}}
                                <a class="button" href="#" onclick="addPoints('{{ route('No',$relation->id) }}')">No</a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script defer src="{{ asset('js/game.js') }}?v={{time()}}"></script>
    </section>


{{--@endsection--}}


