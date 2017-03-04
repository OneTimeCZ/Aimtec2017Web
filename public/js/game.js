$(document).ready(function () {

    // VARIABLES
    var weapon = 1;                     // starting weapon ID
    var weaponLimits = [20, 10, 10];    // amounts of each weapon at the start of the game
                                        // changes during the game
    var placedWeapons = [];
    var roundDuration = 30;             // in seconds
    var roundStartTime;                 // milliseconds
    var roundActive = false;
    var bombDelayInterval = 1200;       // how long before bomb explodes in milliseconds
    var fireDelayInterval = 4000;       // how long before fire burns out in milliseconds
    var cactusDelayInterval = 10000;    // how long before cactus dies in milliseconds
    var clockText = $("p.countdown");   // variable for keeping link to text
                                        // inside the clock on the right side of game screen
    var clock = $("img.clock");         // variable for keeping link to the clock
    var secondsSinceStart = 0;          // int seconds, used for easier clock printing

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
            clearGrid();
        }, roundDuration * 1000);
    });

    // choose a weapon by clicking on the weapons sidebar item
    // or by pressing the keys associated to the weapons
    // 1 - bomb     2 - flame       3 - cactus
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
                var cactusLocation = $(this);
                cactusLocation.addClass("cactus-location");
                cactusLocation.removeClass("hover");
                setTimeout(function () {
                    cactusLocation.removeClass("cactus-location");
                    cactusLocation.addClass("hover");
                }, cactusDelayInterval);
            }
            weaponLimits[weapon - 1]--;
            $(".weapon[data-id='" + weapon + "'] .ammo").html(weaponLimits[weapon - 1] + " left");
            console.log("placing a weapon");
            console.log(x + " " + y);
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

        $(".cactus-location").each(function () {
            $(this).removeClass("cactus-location");
        });

        clock.removeClass("shaky");
    }

    // updates clock every second, and when the game ends,
    // sends all weapons placed to the runner
    function updateClock() {
        secondsSinceStart += 1;

        if (secondsSinceStart >= roundDuration) {
            // remove sidebars and position the grid accordingly
            $(".weapons").hide();
            $(".info").hide();
            $(".grid").addClass("col-xs-offset-3");
            $(".title").html("Runner's turn");

            // stop the countdown
            clearInterval(clockUpdater);
            console.log(placedWeapons);
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
            return;
        }

        clockText.html(roundDuration - secondsSinceStart);
    }
});
