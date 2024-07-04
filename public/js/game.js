const timer = document.getElementsByClassName("timer")[0];
let countdownTimer = null;
let points = 10;
let questionsAsked = 0;

// De belangrijkste functie, dit is de timer van het spel
// Checken als timer bestaat, en dan uitvoeren van punten systeem
if(timer) {
    let countdown = 30;
    const getPoints = localStorage.getItem("points") || 0;

    // Als de speler meer dan 70 punten heeft, timer terugbrengen naar 10 secondes
    if(Number(getPoints) > 70) {
        countdown = countdown - countdown / 100 * Number(getPoints);
        if(countdown < 3) {
            countdown = 10;
        }
    }

    timer.innerHTML = `${countdown} seconds left.<br /><br />`;

    countdownTimer = setInterval(() => {
        countdown--;

        timer.innerHTML = `${countdown} seconds left.<br /><br />`;

        if(countdown <= 0) {
            gameOver();

            clearInterval((countdownTimer));
            countdownTimer = null;
        }
    }, 1000);
}


function addPoints (url) {
    const currentPoints = localStorage.getItem('points');
    if(currentPoints) {
        localStorage.setItem('points', `${Number(parseInt(currentPoints) + points)}`);
    } else {
        localStorage.setItem('points', `${Number(points)}`);
    }
    window.location.href = url;
}

function savePoints() {
    let leaderboard = localStorage.getItem("leaderboard");
    const currentPoints = localStorage.getItem('points') || 0;
    let username = document.getElementById("name");
    let leaderboardData = [];

    if(!username) {
        username = `User${Math.floor(Math.random() * 10000)}`
    } else {
        username = username.valueOf().value;
    }
    if(leaderboard) leaderboardData = [...JSON.parse(leaderboard)];

    leaderboardData.push({
        username,
        points: currentPoints
    });

    localStorage.setItem("leaderboard", JSON.stringify(leaderboardData));
    window.location.href = "http://localhost/bp5test1nieuwstebeste/public/start/1";
}
function gameOver() {
    console.log(window.location.href);
    alert('You didn\'t answer the question in time and lost all your points.');
    points = 0;
    localStorage.setItem("points", '0');
    window.location.href = 'http://localhost/bp5test1nieuwstebeste/public/start/1';
}

function getLeaderboard() {
    const storage = localStorage.getItem("leaderboard");

    if(storage) {
        const leaderboard = JSON.parse(storage);
        const board = document.getElementById("leaderboard");

        if(leaderboard.length > 0) {
            leaderboard.sort((a, b) => (b.points - a.points));
            for(const item of leaderboard) {
                const li = document.createElement("li");
                li.innerText = `${item.username} - ${item.points}`;
                board.append(li);
            }
        }
    }
}
