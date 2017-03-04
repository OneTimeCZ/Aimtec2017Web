$(document).ready(function () {

    // VARIABLES
    var weapon = 1;                     // starting weapon ID
    var weaponLimits = [20, 10, 10];    // amounts of each weapon at the start of the game
                                        // changes during the game
    var placedWeapons = [];
    var roundDuration = 10;             // in seconds
    var roundStartTime;                 // milliseconds
    var roundActive = false;
    var bombDelayInterval = 1200;       // how long before bomb explodes in milliseconds
    var fireDelayInterval = 4000;       // how long before fire burns out in milliseconds
    var boxDelayInterval = 10000;    // how long before box dies in milliseconds
    var clockText = $("p.countdown");   // variable for keeping link to text
                                        // inside the clock on the right side of game screen
    var clock = $("img.clock");         // variable for keeping link to the clock
    var secondsSinceStart = 0;          // int seconds, used for easier clock printing
    var runner;                         // variable to store link to the runner's avatar
    var fakeMovementHistory = [         // used for testing "REALTIME" runner representation
        [2.1,2.3,100],
        [1.7,2.6,200],
        [1.4,3.0,300],
        [1.8,2.3,400],
        [2.2,1.9,500],
        [2.3,1.6,600],
        [2.4,1.0,700],
        [3.0,1.5,800],
        [2.3,1.6,900],
        [2.4,2.0,1000]
    ];

    // preset number inside the clock before round starts and show pre-game screen
    clockText.html(roundDuration);
    $("#preGameModal").modal();

    // after both players press ready
    // game is launched immediately
    $("#startGame").click(function () {
        // display ammo in the weapons sidebar
        $("li[data-id='1'] .ammo").html(weaponLimits[0] + " left");
        $("li[data-id='2'] .ammo").html(weaponLimits[1] + " left");
        $("li[data-id='3'] .ammo").html(weaponLimits[2] + " left");

        // set up time variables
        roundActive = true;
        roundStartTime = Date.now();
        secondsSinceStart = 0;

        // start up clock animation
        clock.addClass("shaky");

        // change number in the clock every second
        // and after the game ends, stop countdown
        var clockUpdater = setInterval(updateClock, 1000);
        setTimeout(function () {
            roundActive = false;
            clearInterval(clockUpdater);
            clearGrid();

            // remove sidebars and position the grid accordingly
            $(".weapons").hide();
            $(".info").hide();
            $(".grid").addClass("col-xs-offset-3");
            $(".title").html("Runner's turn");

            $.ajax({
                url: '/game/map',
                method: 'POST',
                data: {
                    'weapons': placedWeapons
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".grid.col-xs-6").append("<div id='runner'>runner</div>");
            runner = $("#runner");
            //console.log(runner);
            setTimeout(drawRunner(fakeMovementHistory), 2000);
        }, roundDuration * 1000);
    });

    // choose a weapon by clicking on the weapons sidebar item
    // or by pressing the keys associated to the weapons
    // 1 - bomb     2 - flame       3 - box
    $("li.weapon").click(function () {
        selectWeapon($(this).attr("data-id"));
    });

    $(document).keypress(function (e) {
        //49 = 1     50 = 2      51 = 3
        if (e.which === 49 || e.which === 50 || e.which === 51) {
            selectWeapon(e.which - 48);
        }
    });

    // clicking on the grid square places currently selected weapon
    $(".grid-square").click(placeWeapon);

    // takes care of visualizing, which weapon is currently chosen
    // and assigning newly chose weapon to its variable
    function selectWeapon(id) {
        if (id != weapon) {
            $("li[data-id='"+id+"']").addClass("selected");
            $("li[data-id='"+weapon+"']").removeClass("selected");
            weapon = id;
        }
    }

    // takes care of weapon placement, reducing available ammo
    // and preparing all weapons placed to be sent to the runner
    function placeWeapon() {
        if (roundActive && weaponLimits[weapon - 1] > 0) {
            var x = $(this).attr("data-x");
            var y = $(this).attr("data-y");

            // display weapon for its preset time frame
            if (weapon === 1) {
                var bombLocation = $(this);
                bombLocation.removeClass("hover");
                bombLocation.addClass("bomb-location");
                setTimeout(function () {
                    bombLocation.removeClass("bomb-location");
                    bombLocation.addClass("exploded");
                }, bombDelayInterval - 100);
                setTimeout(function () {
                    bombLocation.removeClass("exploded");
                    bombLocation.addClass("hover");
                }, bombDelayInterval);
            } else if (weapon === 2) {
                var fireLocation = $(this);
                fireLocation.addClass("fire-location");
                fireLocation.removeClass("hover");
                setTimeout(function () {
                    fireLocation.removeClass("fire-location");
                    fireLocation.addClass("hover");
                }, fireDelayInterval);
            } else if (weapon === 3) {
                var boxLocation = $(this);
                boxLocation.addClass("box-location");
                boxLocation.removeClass("hover");
                setTimeout(function () {
                    boxLocation.removeClass("box-location");
                    boxLocation.addClass("hover");
                }, boxDelayInterval);
            }
            weaponLimits[weapon - 1]--;
            $(".weapon[data-id='" + weapon + "'] .ammo").html(weaponLimits[weapon - 1] + " left");
            placedWeapons.push({type: weapon, x: x, y: y, time: (Date.now() - roundStartTime)});
        }
    }

    // called after game ends, prepares grid for runner's try replay
    function clearGrid() {
        $(".grid").removeClass("hoverable");
        $(".bomb-location").each(function () {
            $(this).removeClass("bomb-location");
        });

        $(".fire-location").each(function () {
            $(this).removeClass("fire-location");
        });

        $(".box-location").each(function () {
            $(this).removeClass("box-location");
        });

        clock.removeClass("shaky");
    }

    // updates clock every second, and when the game ends,
    // sends all weapons placed to the runner
    function updateClock() {
        secondsSinceStart += 1;

        clockText.html(roundDuration - secondsSinceStart);
    }

    // Calculate runners position in the last preceding second and draw it for hunters to see
    function drawRunner(data) {
        var points = data;
        var loop = setInterval(function() {
            if (points.length > 0) {
                var point = points.shift();
                setRunnerPosition(point[0], point[1]);
            }
        }, 100);
    }

    // Move runners avatar in the grid
    function setRunnerPosition(x, y) {
        console.log("moving");
        runner.css({top: y* 90, left: x * 90});
    }
});
