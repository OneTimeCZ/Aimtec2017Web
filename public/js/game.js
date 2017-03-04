$(document).ready(function () {
    var weapon = 1;
    var weaponLimits = [9999, 9999, 9999];
    var placedWeapons = []; //JSON in future
    var roundDuration = 3600; //in seconds
    var roundStartTime;
    var roundActive = false;
    var bombDelayInterval = 1200;
    var fireDelayInterval = 4000;
    var cactusDelayInterval = 10000;
    var clock = $("li.clock");
    var secondsSinceStart = 0;
    clock.html("(0 seconds / " + roundDuration + ")");
    $("#preGameModal").modal();
    $("#startGame").click(function () {
        $("li[data-id='1'] .ammo").html(weaponLimits[0] + " left");
        $("li[data-id='2'] .ammo").html(weaponLimits[1] + " left");
        $("li[data-id='3'] .ammo").html(weaponLimits[2] + " left");
        roundActive = true;
        roundStartTime = Date.now();
        secondsSinceStart = 0;
        var clockUpdater = setInterval(updateClock, 1000);
        setTimeout(function () {
            roundActive = false;
            clearGrid();
        }, roundDuration * 1000);
    });

    $("li.weapon").click(function () {
        selectWeapon($(this).attr("data-id"));
    });

    $(document).keypress(function (e) {
        if (e.which === 49 || e.which === 50 || e.which === 51) {
            selectWeapon(e.which - 48);
        }
    });

    $(".grid-square").click(placeWeapon);

    function selectWeapon(id) {
        if (id != weapon) {
            $("li[data-id='"+id+"']").addClass("selected");
            $("li[data-id='"+weapon+"']").removeClass("selected");
            weapon = id;
        }
    }

    function placeWeapon() {
        if (roundActive && weaponLimits[weapon - 1] > 0) {
            var x = $(this).attr("data-x");
            var y = $(this).attr("data-y");

            if (weapon === 1) {
                var bombLocation = $(this);
                bombLocation.removeClass("hover");
                bombLocation.addClass("bomb-location");
                setInterval(function () {
                    bombLocation.removeClass("bomb-location");
                    bombLocation.addClass("hover");
                }, bombDelayInterval);
            } else if (weapon === 2) {
                var fireLocation = $(this);
                fireLocation.addClass("fire-location");
                fireLocation.removeClass("hover");
                setInterval(function () {
                    fireLocation.removeClass("fire-location");
                    fireLocation.addClass("hover");
                }, fireDelayInterval);
            } else if (weapon === 3) {
                var cactusLocation = $(this);
                cactusLocation.addClass("cactus-location");
                cactusLocation.removeClass("hover");
                setInterval(function () {
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
    }

    function updateClock() {
        secondsSinceStart += 1;

        if (secondsSinceStart >= roundDuration) {
            $(".weapons").hide();
            $(".info").hide();
            $(".grid").addClass("col-xs-offset-3");
            $(".title").html("Runner's turn");
            clearInterval(clockUpdater);
            console.log(placedWeapons);
            return;
        }

        clock.html("(" + secondsSinceStart + " seconds / " + roundDuration + ")");
    }
});