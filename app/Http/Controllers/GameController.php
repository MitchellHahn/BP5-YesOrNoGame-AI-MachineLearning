<?php

namespace App\Http\Controllers;

use App\Models\FailedNode;
use App\Models\History;
use App\Models\Node;
use App\Models\Relation;
use App\Models\Score;
use App\Models\SuccessNode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;


use PHPUnit\Util\Test;
use function Ramsey\Uuid\setNodeProvider;

class GameController extends Controller
{

//start pagina
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Node $node
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Node $node)
    {

        // Reset cache
        $this->reset_teller_cache();

        // toont node 1 omdat het de hoogste is
        if(!$node->id) {
            return redirect("/start/1");
        } else {
            return view('game.start', compact('node'));
        }

    }


    /**
     * Display a listing of the resource.
     */
//speler gekozen node opslaan
    public function set_node_history(Node $node) {


        // zoekt naar parent node
        $relation = Relation::where('node_yes', $node->id)
            ->orWhere('node_no', $node->id)
            ->first();

        $parentId = $relation->parent_node;

//gekozen node opslaan
        History::create([
            'node' => $node->id,
            'name' => $node->name
        ]);


    }

    /**
     * Display a listing of the resource.
     */
    public function handleLoopUpRequest($currentVisitedNode) {
        // Selecteer knopen uit de geschiedenis die meer dan 3 keer voorkomen

        $histories = History::select('node')
            ->groupBy('node')
            ->havingRaw('COUNT(*) > 3')
            ->get();

        // Haal de knoop-ID's die meer dan 3 keer voorkomen
        $FourTimesNodes = $histories->pluck('node')->toArray();
        $results = [];

        foreach ($FourTimesNodes as $FourTimesNode) {
            // Initialiseer een array om bezochte knoop-ID's op te slaan
            $visitedNodeIds = [];

            // Zoek de knoop op basis van de ID
            $node = Node::find($FourTimesNode);

            // Controleer of de knoop bestaat
            if ($node) {
                // Herhaal totdat er geen ouderknoop meer wordt gevonden
                while ($node !== null) {
                    // Zoek naar de knoop in het Relation-model
                    $relation = Relation::where('node_yes', $node->id)
                        ->orWhere('node_no', $node->id)
                        ->first();

                    if ($relation) {
                        // Haal de ouderknoop op
                        $parentId = $relation->parent_node;
                        // Controleer of $parentId een integer is (knoop-ID)
                        if (is_int($parentId)) {
                            // Sla de bezochte knoop-ID op
                            $visitedNodeIds[] = $node->id;

                            // Werk $node bij voor de volgende iteratie
                            $node = Node::find($parentId);
                        } else {
                            // Als $parentId geen integer is, verlaat de loop
                            $node = null;
                        }
                    } else {
                        // Als er geen ouderknoop wordt gevonden, verlaat de loop
                        $node = null;
                    }
                }
            }



// Controleer of de huidige bezochte knoop in de lijst van bezochte knopen zit
            $isVisited = in_array($currentVisitedNode, $visitedNodeIds);
// Sla de bezoekstatus van de knoop op
            $results[$FourTimesNode] = $isVisited ? 'visited' : 'not visited';
        }


// Haal de knopen op die zijn bezocht
        $visitedNodeIds = [];
        foreach ($results as $nodeId => $status) {
            if ($status === 'visited') {
                $visitedNodeIds[] = $nodeId;
            }
        }

// Als visitedNodeIds leeg is, keer vroegtijdig terug
        if (empty($visitedNodeIds)) {
            return null; // or any other appropriate action
        }


        Cache::increment('SmartGuess_Executed');

// Verhoog de cache voor het aantal uitgevoerde SmartGuess

        if(Cache::has('SmartGuess_Executed') && !Cache::has('FindFourTimesNode_InSmartGuess_SuccessNodes_Executed')){

            $FourTimes_And_SmartGuessSuccessNode = $this->FindFourTimesNode_InSmartGuess_SuccessNodes($visitedNodeIds);

            if ($FourTimes_And_SmartGuessSuccessNode !== null){

                $randomKey = array_rand($FourTimes_And_SmartGuessSuccessNode);
                $randomNodeId = $FourTimes_And_SmartGuessSuccessNode[$randomKey];
                $relation = Relation::where('node_yes', $randomNodeId)
                    ->orWhere('node_no', $randomNodeId)
                    ->first();

                if ($relation) {
                    $parentId = $relation->parent_node;
                    if ($parentId) {
                        return $parentId;
                    }
                }

            }

        }


// Ga verder met de rest van de functie als visitedNodeIds niet leeg is
        $randomKey = array_rand($visitedNodeIds);
        $randomNodeId = $visitedNodeIds[$randomKey];


        $relation = Relation::where('node_yes', $randomNodeId)
            ->orWhere('node_no', $randomNodeId)
            ->first();

        if ($relation) {
            $parentId = $relation->parent_node;
            if ($parentId) {
                return $parentId;
            }
        }

        return null; // Return  null als er geen ouder-ID wordt gevonden
    }



    /**
     * Display a listing of the resource.
     */
    function FindFourTimesNode_InSmartGuess_SuccessNodes($visitedNodeIds) {
        // Ophalen van succesknopen uit de database als een array van gehele getallen
        $SmartGuess_SuccessNodes = SuccessNode::pluck('node')->toArray();

        $FourTimes_And_SmartGuessSuccess_Node = [];

        // Debugging output
        echo "Visited Node IDs: ";
        print_r($visitedNodeIds);
        echo "SmartGuess Success Nodes: ";
        print_r($SmartGuess_SuccessNodes);

        // Loop door elke bezochte knoop-ID
        foreach ($visitedNodeIds as $visitedNodeId) {
            // Debugging output voor elke iteratie
            echo "Checking if $visitedNodeId is in success nodes...\n";
            if (in_array($visitedNodeId, $SmartGuess_SuccessNodes)) {
                echo "Match found: $visitedNodeId\n";
                $FourTimes_And_SmartGuessSuccessNode[] = $visitedNodeId;
            }
        }

        // als geen node is gevonden

        if (empty($FourTimes_And_SmartGuessSuccessNode)) {
            $FourTimes_And_SmartGuessSuccessNode = null;
            Cache::increment('FindFourTimesNode_InSmartGuess_SuccessNodes_Failed');
        }

        return $FourTimes_And_SmartGuessSuccessNode;
    }









    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Node $node
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function yes(Node $node)
    {
        // Haal de huidige knoop op
        $currentNodeId = $node->id;

        // Haal de huidige knoop op
        Cache::increment('click_count');

        // Haal het aantal klikken op
        $totalClicks = Cache::get('click_count', 0);

        $relation = Relation::where('parent_node', $currentNodeId)
            ->first();
        // Haal de knoop uit kolom "node_no" in dezelfde rij als de $currentNodeId

        // Voer de functie uit als de speler 2 vragen heeft beantwoord
        if ($totalClicks == 2) {
            $smartGuessInputNodeId = $relation->node_yes;


            $smartGuessInputNode = Node::findOrFail($smartGuessInputNodeId);

            // Roep de SmartGuess-methode aan met de Node-instantie
            return $this->SmartGuess($smartGuessInputNode->id, $totalClicks);

        }

////////////////////////////////// functie SM node Registreren///////////////////////////////////
        $answer = $node->answer;
        if (Cache::has('SmartGuess_Executed') && !Cache::has('SmartGuess_Failed') && Node::where('answer', $answer)->exists()) {
            $parentNode = Node::where('answer', $answer)->first();

            if (Relation::where('parent_node', $node->id)->exists()) {
                $relation = Relation::where('parent_node', $node->id)->first();
                $nodeYes = $relation->node_yes;

                // Controleer of er al een SuccessNode bestaat voor de huidige nodeYes
                if (!SuccessNode::where('node', $nodeYes)->exists()) {
                    // Maak het SuccessNode-record aan
                    SuccessNode::create([
                        'node' => $nodeYes,
                    ]);


                    $latestSuccessNode = SuccessNode::latest()->first();
                    $latestSuccessNode->delete();

                    $test = Node::find($nodeYes);

                    $this->set_node_history($test);

                    // Log informatie
                    Log::info('SuccessNode created for node with ID ' . $test);
                }
            } else {
                // Log dat de voorwaarden niet voldaan zijn
                Log::info('Conditions not met for creating SuccessNode for node with ID ' . $node->id);

                $this->set_node_history($node);

                return $this->Register_SmartGuess_SuccessNote($parentNode);
            }

        }

////////////////////////////////// functie chek als SM node in failed path ligt///////////////////////////////////

        if (Cache::has('SmartGuess_Executed') && Cache::has('SmartGuess_Failed')) {
            $relation = Relation::where('parent_node', $node->id);
            $currentNodeNodeYesRelation = $relation->pluck('node_yes')->toArray();

            $currentNode_IsIn_FailedNodePath = $this->checkIfCurrentNodeLiesInFailedNodePath($currentNodeNodeYesRelation);
        }

////////////////////////////////// functie add character after SM node failed  and playing is SG node path/////////////////////////////////
        if (Cache::has('SmartGuess_Executed') && Cache::has('SmartGuess_Failed') && Cache::has('CurrentNode_LiesWithin_FailedNodePath')) {

            $currentNodeId = $node->id;
            $latestFailNode = FailedNode::latest('created_at')->first();

            $relation = Relation::where('parent_node', $currentNodeId)->first();

                if ($relation == null && $node->answer !== null) {
                    $this->set_node_history($node);
                    return view('game.gameover');
                }

            $related_node_id = $relation->node_yes;

                if ($latestFailNode->node == $related_node_id) {
                    Cache::increment('SmartGuess_Executed&Failed_ButAddNewCharacter');

                    return view('game.AddCorrectCharacter_AfterSMFailed', compact( 'related_node_id'));
                }
        }


////////////////////////////////// functie karakter voor spelling/////////////////////////////////

        if ($node->relation) {
            if ($node->question && Str::startsWith("answer", Str::lower($node->question))) {
                $node->question = "Is this your character?";
            }
            $relation = $node->relation->yes;
            return view('game.yes', compact('node', 'relation'));
        } else {
            $this->set_node_history($node);
            return view('game.gameover');
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Node $node
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function no(Node $node)
    {


        // Leg elke klik vast
        Cache::increment('click_count');

        // Haal het aantal klikken op
        $totalClicks = Cache::get('click_count', 0);

        // Haal de huidige knoop op
        $currentNodeId = $node->id;


        $relation = Relation::where('parent_node', $currentNodeId)
            ->first();
        // Haal de knoop uit kolom "node_no" in dezelfde rij als de $currentNodeId


        //////////////////functie SmartGuess nadat de speler 2 vragen heeft beantwoord//////////////////////
        if ($totalClicks == 2) {
            $smartGuessInputNodeId = $relation->node_no;

            $smartGuessInputNode = Node::findOrFail($smartGuessInputNodeId);
            return $this->SmartGuess($smartGuessInputNode->id, $totalClicks);
        }

        $relation = null;

        //////////////////functie reset  naar SG node//////////////////////

        if (Cache::has('SmartGuess_Executed') && $node->relation === null && !Cache::has('SmartGuess_Failed')) {

            Cache::increment('SmartGuess_Failed');
            // Haal de SmartGuess-cache op voor de invoer van SmartGuess

            // Registreer mislukte smart guess predictie knoop
            $this->Register_SmartGuess_FailNote($node);

            // Reset naar smart guess invoer knoop
            return $this->ResetTo_SmartGuessInputNode($node);

        }

        /////////////////////////functie checkIfCurrentNodeLiesInFailedNodePath////////////////////////
        if (Cache::has('SmartGuess_Executed') && Cache::has('SmartGuess_Failed')) {
            $relation = Relation::where('parent_node', $node->id);
            $currentNodeNodeNoRelation = $relation->pluck('node_no')->toArray();

            $currentNode_IsIn_FailedNodePath = $this->checkIfCurrentNodeLiesInFailedNodePath($currentNodeNodeNoRelation);
        }

        ////////////////////functie AddCorrectCharacter_AfterSMFailed_NotInFailedNodePath///////////////////////
        if (Cache::has('SmartGuess_Executed') && Cache::has('SmartGuess_Failed') && Cache::has('CurrentNode_DoesNotLieIn_FailedNodePath')) {
            $currentNodeId = $node->id;

            $relation = Relation::where('parent_node', $currentNodeId)->first();

            if ($relation == null && $node->answer !== null) {
                Cache::increment('SmartGuess_Executed&Failed_ButAddNewCharacter');

                //                 Assuming $relation and other variables are defined
                return view('game.AddCorrectCharacter_AfterSMFailed_NotInFailedNodePath', compact( 'currentNodeId'));
            }
        }


        /////////////funntie chek failed node path//////////////
        if (Cache::has('SmartGuess_Executed') && Cache::has('SmartGuess_Failed') && Cache::has('CurrentNode_LiesWithin_FailedNodePath')) {
            $currentNodeId = $node->id;
            $latestFailNode = FailedNode::latest('created_at')->first();

            $relation = Relation::where('parent_node', $currentNodeId)->first();

            echo "Is playing in failed node path";

                if ($relation == null && $node->answer !== null) {
                    Cache::increment('SmartGuess_Executed&Failed_ButAddNewCharacter');

                    return view('game.AddCorrectCharacter_AfterSMFailed_NotInFailedNodePath', compact( 'currentNodeId'));
                }

            $related_node_id = $relation->node_no;

                if ($latestFailNode->node == $related_node_id) {
                    Cache::increment('SmartGuess_Executed&Failed_ButAddNewCharacter');

                    return view('game.AddCorrectCharacter_AfterSMFailed', compact( 'related_node_id'));
                }
        }


        /////////////////////functie voorspel karacter ////////////////////////
        if($node->question && Str::startsWith("answer", Str::lower($node->question))) {
            $node->question = "Is this your character?";


        }

        if($node->relation !== null && $node->relation->id !== null ) {
            $relation = $node->relation->no;


        }
        return view('game.no',compact('node', 'relation'));

    }

    /**
     * Display a listing of the resource.
     */
// functie voor om te kijken als huidige node is failed node path is
    public function checkIfCurrentNodeLiesInFailedNodePath($currentVisitedNodeIds)
    {
        // Haal de meest recente gefaalde knoop op
        $latestFailNode = FailedNode::latest('created_at')->first();

        if (!$latestFailNode) {
            return false;
        }

        // Haal de knoop-ID van de meest recente gefaalde knoop op
        $nodeId = $latestFailNode->node;

        // Initialiseer het pad van gefaalde knopen als een array
        $failedNodePath = [];

        // Begin met het traceren van het pad vanaf de gefaalde knoop
        $node = Node::find($nodeId);

        while ($node !== null) {
            // Haal de relatie op voor de huidige knoop
            $relation = Relation::where('node_yes', $node->id)
                ->orWhere('node_no', $node->id)
                ->first();

            if ($relation) {
                // Voeg de huidige knoop toe aan het pad van gefaalde knopen
                $failedNodePath[] = $node->id;
                // Ga naar de ouderknoop
                $parentId = $relation->parent_node;
                $node = Node::find($parentId);
            } else {
                // Als er geen relatie wordt gevonden, stopt de loop
                break;
            }
        }

        // Controleer of een van de huidige bezochte knoop-ID's in het pad van gefaalde knopen zit
        foreach ($currentVisitedNodeIds as $currentVisitedNodeId) {
            if (in_array($currentVisitedNodeId, $failedNodePath)) {

                // Verhoog de cache voor het aantal keren dat de huidige knoop binnen het pad van gefaalde knopen ligt
                Cache::increment('CurrentNode_LiesWithin_FailedNodePath');
                $currentNode_IsIn_FailedNodePath = 'true';
                return $currentNode_IsIn_FailedNodePath;

                // Ontwikkel het pad van gefaalde knopen voor debugging doeleinden

            } else {

                // Verhoog de cache voor het aantal keren dat de huidige knoop niet binnen het pad van gefaalde knopen ligt
                Cache::increment('CurrentNode_DoesNotLieIn_FailedNodePath');

                $currentNode_IsIn_FailedNodePath = 'false';
                return $currentNode_IsIn_FailedNodePath;

            }

        }
        return false;
    }


    /**
     * Display a listing of the resource.
     */
//smart guess functie
    public function SmartGuess($currentNodeId, $totalClicks) {
        Log::info("Entering SmartGuess with node ID: $currentNodeId and total clicks: $totalClicks");

        // Controleert of het totaal aantal klikken gelijk is aan 2 dan voer het smartguess uit
        if ($totalClicks == 2) {

            // Haalt de eerste relatie op waar de parent_node gelijk is aan de huidige knoop-ID
            $relation = Relation::where('parent_node', $currentNodeId)->first();

            // Handelt de opzoekverzoek af en haalt de voorspelde knoop-ID op
            $smartGuessPredictionNodeId = $this->handleLoopUpRequest($currentNodeId);

            // Logt de voorspelde knoop-ID
            Log::info("SmartGuessPredictionNodeId: $smartGuessPredictionNodeId");


            // Controleert of de voorspelde knoop-ID bestaat en niet gelijk is aan de huidige knoop-ID
            if ($smartGuessPredictionNodeId && $smartGuessPredictionNodeId != $currentNodeId) {

                // Redirect naar de SmartGuess route met de voorspelde knoop-ID en totaal aantal klikken
                return redirect()->route('SmartGuess', ['node' => $smartGuessPredictionNodeId, 'totalClicks' => $totalClicks]);
            } else {

                // Logt een waarschuwing om een loop te voorkomen als de voorspelde knoop-ID gelijk is aan de huidige knoop-ID
                Log::warning("Redirect prevented to avoid a loop: SmartGuessPredictionNodeId ($smartGuessPredictionNodeId) is the same as currentNodeId ($currentNodeId)");
            }
        }


        $node = Node::find($currentNodeId);

        // Geeft de knoop en de voorspelde knoop-ID door aan de view
        return view('SmartGuess', ['node' => $node, 'smartGuessPredictionNodeId' => $smartGuessPredictionNodeId]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Node $node
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function ResetTo_SmartGuessInputNode(Node $node) {

// haalt SG input node op
        $SmartGuess_InputNode = Cache::get('SmartGuess_InputNode');

// wordt onder gebruikt
        $SmartGuess_PredictionCharater_Node = $node->id;

// lege path
        $SmartGuess_PredictionCharater_Path = [];

        // zoek naar de node met ID
        $node = Node::find($SmartGuess_PredictionCharater_Node);

        // kijk als de node bestaat
        if ($node) {
            // Loop tot dat er geen parent meer is
            while ($node !== null) {
                // Search for the node in the Relation model
                $relation = Relation::where('node_yes', $node->id)
                    ->orWhere('node_no', $node->id)
                    ->first();

                //als er een relatie is
                if ($relation) {
                    // pak parent node
                    $parentId = $relation->parent_node;
                    // controleer als $parentId een integer is (node ID)
                    if (is_int($parentId)) {
                        // path van node opslaan ID
                        $SmartGuess_PredictionCharater_Path[] = $node->id;

                        // $node aanpassen voor volgende loop
                        $node = Node::find($parentId);
                    } else {
                        // als $parentId geen integer is, loop stoppen
                        $node = null;
                    }
                } else {
                    // als geen parent node is gevonden, loop stoppen
                    $node = null;
                }
            }

            // depath omdraaien naar boven naar beneden
            $SmartGuess_PredictionCharater_Path = array_reverse($SmartGuess_PredictionCharater_Path);

            // zoek de SG input node in path
            $SmartGuess_InputNode = $SmartGuess_PredictionCharater_Path[1];

            // pak id van de SG input node
            $node = Node::find($SmartGuess_InputNode);

            // SG input node returnen
            return view('SmartGuessFailed', ['node' => $node, 'SmartGuess_InputNode' => $SmartGuess_InputNode]);

        }
    }




    /**
     * failed note registreren
     */
    public function Register_SmartGuess_SuccessNote(Node $node) {

        $relation = Relation::where('node_yes', $node->id)
            ->orWhere('node_no', $node->id)
            ->first();

        if ($relation) {
            $parentId = $relation->parent_node;

            // opslaan Success Node
            SuccessNode::create([
                'node' => $node->id,
            ]);

            return view('game.gameover');
        }
    }


    /**
     * failed note registreren
     */

    public function Register_SmartGuess_FailNote(Node $node) {

        $relation = Relation::where('node_yes', $node->id)
            ->orWhere('node_no', $node->id)
            ->first();

        if ($relation) {
            $parentId = $relation->parent_node;

//             failed node opslaann
            FailedNode::create([
                'node' => $node->id,
            ]);

        }


        /**
        * all cache ophalen
         */

        function getCachedKeys()
        {
            $cachePath = storage_path('framework/cache/data');
            $files = File::allFiles($cachePath);
            $keys = [];

            foreach ($files as $file) {
                $fileName = $file->getFilename();
                $keys[] = $fileName;
            }

            return $keys;
        }}



    ///voor het toevoegen van een de juiste character en een vraags als de gebruiker heeft gewonnen.
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @param  \App\Models\Node $node
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(Node $node, Relation $relation, request $request)
    {

        //////node aanmaken en opslaan
        $request->validate([
            'question' => 'required',
            'answer' => 'required',

        ]);

        $data = $request->except(['_token', 'current_node']);



        foreach($data as $key => $value) {
            $newNode = Node::create([
                $key => $value
            ]);

            $newNode->timestamps = false;
            $newNode->save();

            //als de node een antwoord is voert het dit zodat het gebruikt kan worden als het verplaats moet worden
            if($key === "answer") {
                $newrelation = new Relation();
                $newrelation->timestamps = false;
                $newrelation->node_yes = $newNode->id;

                $newrelation->node_no = $request->input("current_node");
                $newrelation->parent_node = Node::orderBy('id', 'desc')->skip(1)->take(1)->get()->first()->id;
                $newrelation->save();

                $oldRelation = Relation::where('node_no', $request->current_node)->orWhere('node_yes', $request->current_node)->first();
                if($oldRelation->node_no === $request->current_node) {
                    $oldRelation->node_yes = $newrelation->parent_node;
                } else {
                    $oldRelation->node_no = $newrelation->parent_node;
                }
                $oldRelation->save();
            }
        }

        return redirect("/start");

    }




    //leader board
    /**
     * deze functie haalt alle gebruikers en administrators op van tabel "users"
     * toont via de "gebruikers" view (blade) alle gebruikers en administrators op van tabel "users"
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function leaderboard()
    {

        // alle scores sorteren
        $scores = Score::orderBy('score', 'DESC')->paginate(1000);

        return view('game.leaderboard',compact('scores'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }



    //score doorgegven
    /**
     * deze functie toont de registratie forumulier (pagina 'registratie') waarin accounts kunnn worden aangemaakt
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function score_invoer()
    {
        // toont de view (blade bestand) "registratie"
        $this->reset_teller_cache();
        return view('game.gameover');
    }



    //cash resetten
    /**
     * Leeg teller cache
     */
    public function reset_teller_cache() {
        Cache::clear();
    }



    //score opslaan
    /**
     * deze functie registreert een toeslag aan een zpper.
     * Maakt een nieuwe rij aan in tabel "toeslagen".
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Score $score
     * @return \Illuminate\Http\RedirectResponse
     */
    public function score_opslaan(Request $request, Score $score)
    {

        // ingevulde score op pakker
        $request->validate([
            'naam' => '',
            'score' => '',

        ]);

        // maakt een nieuwe score
        $score = Score::create($request->all());

        // score opdlaan
        $score->save();

        //score sorteren om op te sturen
        $scores = Score::orderBy('score', 'DESC')->get();

        return view('game.leaderboard', compact('scores'))
            ->with('success', 'score is opgeslagen');
    }

}
