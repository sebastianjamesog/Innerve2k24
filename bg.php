<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BGMI Tournament Guidelines</title>
    <link href="https://fonts.googleapis.com/css2?family=Aloevera&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Aloevera', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
        }

        #gradient {
            height: 100vh;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
            transition: background 1s ease;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        h1 {
            text-align: center;
            font-size: 3em;
            margin-bottom: 20px;
            color: #fff;
        }

        .guidelines {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .guidelines h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
        }

        .guidelines p {
            font-size: 1.1em;
            line-height: 1.6;
            margin: 5px 0;
        }

        .register-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #28a745;
            color: white;
            text-align: center;
            font-size: 1.2em;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .important-red {
        color: red;
        }
        .register-btn:hover {
            background-color: #218838;
        }

        .contact-section {
            margin-top: 20px;
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
        }

        .contact-section h3 {
            margin-bottom: 10px;
            font-size: 1.5em;
        }

        .contact-section p {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5em;
            }

            .guidelines p {
                font-size: 1em;
            }

            .register-btn {
                width: 180px;
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>

    <div id="gradient"></div>

    <div class="container">
        <h1>BGMI Tournament Guidelines</h1>
        <div class="guidelines">
            <h2>General Guidelines</h2>
            <p>● The tournament will be held online, or students attending the college for other events during the time can participate on-site.</p>
            <p>● Emulators are not allowed in any gamemode organized. The players will be disqualified if found using any kind of emulator.</p>
            <p>● Any game modifying tools except ‘GFX tool’ is not allowed.</p>
            <p>● Players can play on android/ios phones only.</p>
            <p>● Only in-game voice chat should be used during the game</p>
            <p>● Any use of unfair means such as aimbot, trigger bot, ESP will be disqualified.</p>
            <p>● If a team/player fail to join the room on time, they/their squad will be given 0 points</p>
            <p>● Waiting time is at most 10 minutes between games.</p>
            <p>● If a player exit the game without a valid reason,the team  will be disqualified</p>
            <p>● The exploitation of bugs that hinders fair play will result in disqualification.</p>
            <p>● For the tiebreaker of the points, total team kills will be considered </p>
            <p>● For the further tiebreaker, number of chicken dinners will be considered.</p>
            <p>● Organizers would not be held responsible for connectivity issues on the participant's side.</p>
            <p>● Organizers reserve the right to accept or reject any entry without stating a reason thereof.</p>
            <p>● Participants must be ready at least 15 minutes prior to the start off any match. Late entries will not be allowed.</p>
            <p>● Each player must register with their in-game IDs/names.</p>
            <p>● Solo participants are not allowed.</p>
            <p>● The entry fee will not be refunded under any circumstances.</p>
            <a href="bgreg.php" class="register-btn">Register Now</a>
        </div>

        <div class="contact-section">
            <h3>Contact Information</h3>
            <p><strong>STAFF COORDINATORS:</strong></p>
            <p>Soumya Haridas: 8606838427</p>
            <p>Anjaly Motilal: 9745324960</p>
            <p><strong>STUDENT COORDINATORS:</strong></p>
            <p>Gayos M Aji: 6282958519</p>
            <p>Devanand AV: 7907309677</p>
        </div>
    </div>

    <script>
      var colors = new Array(
        [62, 35, 255],
        [60, 255, 60],
        [255, 35, 98],
        [45, 175, 230],
        [255, 0, 255],
        [255, 128, 0]
      );

      var step = 0;
      var colorIndices = [0, 1, 2, 3];
      var gradientSpeed = 0.002;

      function updateGradient() {
        if ($ === undefined) return;

        var c0_0 = colors[colorIndices[0]];
        var c0_1 = colors[colorIndices[1]];
        var c1_0 = colors[colorIndices[2]];
        var c1_1 = colors[colorIndices[3]];

        var istep = 1 - step;
        var r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
        var g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
        var b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
        var color1 = "rgb(" + r1 + "," + g1 + "," + b1 + ")";

        var r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
        var g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
        var b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
        var color2 = "rgb(" + r2 + "," + g2 + "," + b2 + ")";

        $('#gradient')
          .css({
            background:
              "-webkit-gradient(linear, left top, right top, from(" +
              color1 +
              "), to(" +
              color2 +
              "))",
          })
          .css({
            background:
              "-moz-linear-gradient(left, " + color1 + " 0%, " + color2 + " 100%)",
          });

        step += gradientSpeed;
        if (step >= 1) {
          step %= 1;
          colorIndices[0] = colorIndices[1];
          colorIndices[2] = colorIndices[3];

          colorIndices[1] =
            (colorIndices[1] + Math.floor(1 + Math.random() * (colors.length - 1))) %
            colors.length;
          colorIndices[3] =
            (colorIndices[3] + Math.floor(1 + Math.random() * (colors.length - 1))) %
            colors.length;
        }
      }

      setInterval(updateGradient, 10);
    </script>
</body>
</html>
