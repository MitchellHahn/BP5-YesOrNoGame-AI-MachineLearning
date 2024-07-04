{{--verloren venster--}}
<section>
    <form method="post">
        <script defer src="http://localhost/bp5test1nieuwstebeste/public/js/game.js"></script>
        <h3>Game over</h3>
        You have <span id="points">0</span> points.<br />
        Enter your name:<br />
        <input type="number" id="scoreInput" name="score" />
        <input type="text" name="naam" id="name" /><br />
        {{ csrf_field() }}
        <button name="submit">Save game</button>

            {{--reset punten--}}
        <script defer>
            function reset() {
                // localStorage.removeItem('points');
            }
            const totalPoints = localStorage.getItem('points') || 0;
            const pointSpan = document.getElementById("points");
            const scoreInput = document.getElementById("scoreInput");

            if(scoreInput) {
                scoreInput.value = totalPoints;
            }

            if(pointSpan) {
                pointSpan.innerText = totalPoints;
                console.log('totalPoints', totalPoints);
            }
        </script>
    </form>
</section>
