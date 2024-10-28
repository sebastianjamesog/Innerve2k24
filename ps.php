<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Football Tournament Guidelines</title>
    <link href="https://fonts.googleapis.com/css2?family=Aloevera&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Aloevera', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000; /* Set background color to black to blend with the gradient */
        }

        #gradient {
            height: 100vh;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1; /* Ensures the gradient stays in the background */
            transition: background 1s ease;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            position: relative; /* This ensures the content is on top of the gradient */
            z-index: 1;
        }

        h1 {
            text-align: center;
            font-size: 3em;
            margin-bottom: 20px;
            color: #fff;
        }

        .guidelines {
            background-color: rgba(255, 255, 255, 0.9); /* Slight transparency for readability over gradient */
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
        <h1>E-Football Tournament Guidelines</h1>
        <div class="guidelines">
            <h2>General Guidelines</h2>
            <p><strong>Registration Fee:</strong> ₹50 (Online & On-spot registration available)</p>
            <p><strong>Registration Time:</strong> Spot registration ends at 9:30AM</p>
            <p><strong>Format:</strong> 1 vs 1</p>
            <p><strong>Event Date & Time:</strong> 25th October 2024, 10:00AM</p>
            <p><strong>Team:</strong> Users can use any type of players (including featured, epics, and highlights).</p>
            <p><strong>Match Duration:</strong> 
                <ul>
                    <li>Knockouts: 8 minutes</li>
                    <li>Semi-finals & Final: 10 minutes (Extra time & penalties if required)</li>
                </ul>
            </p>
            <p><strong>Substitutions:</strong> Max 3 substitutions, in up to 3 intervals</p>
            <p><strong>Player Condition:</strong> Randomized before the match</p>
            <p><strong>Draws:</strong> Knockout draws will go to penalties</p>
            <p><strong>Game Settings:</strong> Smart Assist must be turned off</p>
            <p><strong>Internet:</strong> Players are responsible for their own connection. Lag/disconnection will result in a match restart</p>
            <p><strong>Disconnection:</strong> Match restarted with remaining time and aggregate score from the previous match</p>
            <p><strong>Refunds:</strong> No refunds</p>
            <p><strong>Disqualification:</strong> Any rule violation leads to disqualification</p>
            <p><strong>Final Decision:</strong> All decisions by the event coordinators are final</p>

            <a href="register.php" class="register-btn">Register Now</a>
        </div>

        <div class="contact-section">
            <h3>Contact Information</h3>
            <p><strong>STAFF Coordinators:</strong></p>
            <p>Angel George: 9400422936</p>
            <p>Judit C John: 8075257396</p>
            <p><strong>Student Coordinators:</strong></p>
            <p>Shine Shibu: 7560956869</p>
            <p>Akshay C Biju: 7510123795</p>
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
