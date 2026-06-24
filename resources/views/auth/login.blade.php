<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="keywords"
        content="gen z travels, gen z, gen z travel agency, gen z tours, gen z vacations, gen z travel services, gen z flight bookings, gen z hotel reservations, gen z tour packages, gen z travel insurance">
    <meta name="description" content="Gen Z Travels is a travel agency that offers a wide range of travel services, including flight bookings, hotel reservations, tour packages, and travel insurance. We are committed to providing our customers with the best travel experience possible."> --}}

    <title>{{ $title ?? config('app.name', 'Gen Z Travels') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('theme/v1/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            /* Prevent scrollbars */
        }

        /* Keyframes for the background gradient animation */
        @keyframes oceanRipple {
            0% {
                background-position: 0% 50%;
            }

            25% {
                background-position: 100% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            75% {
                background-position: 0% 100%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animated-gradient {
            background: linear-gradient(-45deg, #001f3f, #4169E1, #008080, #20B2AA);
            background-size: 400% 400%;
            animation: oceanRipple 35s ease infinite;
        }

        /* Style for the canvas to sit in the background */
        #bg-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
    </style>
</head>

<body class="animated-gradient min-h-screen flex items-center justify-center p-4 relative">

    <canvas id="bg-canvas"></canvas>

    <div id="login-form"
        class="relative z-10 w-full max-w-md bg-black/20 backdrop-blur-xl rounded-2xl shadow-2xl overflow-hidden border border-white/20">
        <div class="p-8 md:p-12">
            <div class="text-center mb-8">
                {{-- <h1 class="text-4xl font-bold text-white tracking-tight">Gen Z Travels</h1> --}}
                <a href="http://genztravels.net/" target="_blank" rel="noopener noreferrer">
                    <img src="{{ asset('theme/v1/images/logo.png') }}" alt="Gen Z Travels Logo"
                        class="mx-auto h-16 w-auto mb-5" style="filter: brightness(100)">
                </a>
                <p class="text-white/80 mt-2">Welcome back! Please sign in to your account.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="login_identifier" class="block text-sm font-medium text-white/90 mb-2">Email or
                            Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-white/50" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="text" id="login_identifier" name="login_identifier" required
                                class="w-full bg-black/30 text-white placeholder-white/60 border border-white/30 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                                placeholder="Your username or email">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-white/90 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-white/50" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" required
                                class="w-full bg-black/30 text-white placeholder-white/60 border border-white/30 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                {{-- <div class="text-right mt-4">
                    <a href="#" class="text-sm text-blue-400 hover:text-blue-300 transition duration-300">Forgot
                        password?</a>
                </div> --}}

                <div class="mt-8">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-blue-500 transform hover:scale-105 transition duration-300">
                        Sign In
                    </button>
                </div>
            </form>

             <div class="mt-8 pt-6">
                <p class="text-xs text-white/60 mb-3 font-semibold uppercase tracking-wide">This is an internal portal</p>
                <a href="https://genztravels.net/" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center justify-center w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 border border-blue-400/50">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M11 3a1 1 0 100 2h3.586L9.293 9.293a1 1 0 001.414 1.414L16 6.414V10a1 1 0 102 0V4a1 1 0 00-1-1h-6z"></path>
                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
                    </svg>
                    Visit Our Official Website
                </a>
            </div>

            {{-- <div class="mt-8 text-center">
                <p class="text-sm text-white/80">
                    Don't have an account?
                    <a href="#" class="font-medium text-blue-400 hover:text-blue-300 transition duration-300">Sign
                        up</a>
                </p>
            </div> --}}
        </div>
    </div>

    <script>
        const canvas = document.getElementById('bg-canvas');
        const ctx = canvas.getContext('2d');
        let width, height, frame = 0;

        // --- NEW: Get the form element and its dimensions ---
        const loginForm = document.getElementById('login-form');
        let formRect;

        const mouse = {
            x: window.innerWidth / 2,
            y: window.innerHeight / 2
        };

        const dolphin = {
            x: window.innerWidth / 2,
            y: window.innerHeight / 2,
            angle: 0,
            speed: 0.07,
            jumpAmplitude: 20,
            jumpFrequency: 0.04
        };

        // --- NEW: Function to update the form's dimensions ---
        function updateFormRect() {
            formRect = loginForm.getBoundingClientRect();
        }


        function resizeCanvas() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
            updateFormRect(); // Update form dimensions on resize
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas(); // Initial call

        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        function drawDolphin() {
            ctx.save();

            const jumpOffset = Math.sin(frame * dolphin.jumpFrequency) * dolphin.jumpAmplitude;
            ctx.translate(dolphin.x, dolphin.y + jumpOffset);

            ctx.rotate(dolphin.angle);
            ctx.scale(0.8, 0.8);

            const bodyColor = 'rgba(200, 220, 255, 0.6)';
            const strokeColor = 'rgba(255, 255, 255, 0.8)';
            ctx.fillStyle = bodyColor;
            ctx.strokeStyle = strokeColor;
            ctx.lineWidth = 2;

            const bodyFlex = Math.sin(frame * 0.1) * 6;

            // Dolphin Body
            ctx.beginPath();
            ctx.moveTo(-50, 0);
            ctx.bezierCurveTo(-20, -40 + bodyFlex, 30, -45 + bodyFlex, 60, -10);
            ctx.bezierCurveTo(70, 0, 70, 5, 60, 15);
            ctx.bezierCurveTo(30, 35 - bodyFlex, -20, 25 - bodyFlex, -50, 0);
            ctx.closePath();
            ctx.fill();
            ctx.stroke();

            // Dorsal Fin
            ctx.beginPath();
            ctx.moveTo(0, -38 + bodyFlex);
            ctx.quadraticCurveTo(15, -55 + bodyFlex, 25, -40 + bodyFlex);
            ctx.closePath();
            ctx.fill();

            // Flipper
            ctx.beginPath();
            ctx.moveTo(20, 18 - bodyFlex * 0.5);
            ctx.quadraticCurveTo(35, 25 - bodyFlex * 0.5, 40, 15 - bodyFlex * 0.5);
            ctx.fill();

            const tailFlex = Math.sin(frame * 0.2) * 15;
            ctx.beginPath();
            ctx.moveTo(-50, 0);
            ctx.quadraticCurveTo(-70, -20 + tailFlex, -65, 0);
            ctx.quadraticCurveTo(-70, 20 + tailFlex, -50, 0);
            ctx.closePath();
            ctx.fill();
            ctx.stroke();

            // Eye
            ctx.beginPath();
            ctx.arc(55, -8, 2, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(0, 0, 0, 0.8)';
            ctx.fill();

            ctx.restore();
        }


        function animate() {
            frame++;
            ctx.clearRect(0, 0, width, height);

            const dx = mouse.x - dolphin.x;
            const dy = mouse.y - dolphin.y;
            const targetAngle = Math.atan2(dy, dx);

            // --- NEW: Collision Avoidance Logic ---
            const avoidancePadding = 60; // How far the dolphin stays from the form

            // Predict the dolphin's next position
            let nextX = dolphin.x + dx * dolphin.speed;
            let nextY = dolphin.y + dy * dolphin.speed;

            // Check if the next position is inside the form's bounding box
            const isColliding = (
                formRect &&
                nextX > formRect.left - avoidancePadding &&
                nextX < formRect.right + avoidancePadding &&
                nextY > formRect.top - avoidancePadding &&
                nextY < formRect.bottom + avoidancePadding
            );

            if (isColliding) {
                // Find the closest edge of the form to the dolphin
                const distToLeft = Math.abs(dolphin.x - (formRect.left - avoidancePadding));
                const distToRight = Math.abs(dolphin.x - (formRect.right + avoidancePadding));
                const distToTop = Math.abs(dolphin.y - (formRect.top - avoidancePadding));
                const distToBottom = Math.abs(dolphin.y - (formRect.bottom + avoidancePadding));

                const minHorizontalDist = Math.min(distToLeft, distToRight);
                const minVerticalDist = Math.min(distToTop, distToBottom);

                // If the dolphin is closer to a vertical edge, slide vertically
                if (minHorizontalDist < minVerticalDist) {
                    dolphin.y += dy * dolphin.speed; // Allow Y movement
                }
                // If the dolphin is closer to a horizontal edge, slide horizontally
                else {
                    dolphin.x += dx * dolphin.speed; // Allow X movement
                }
            } else {
                // If not colliding, move normally
                dolphin.x = nextX;
                dolphin.y = nextY;
            }


            let angleDiff = targetAngle - dolphin.angle;
            while (angleDiff < -Math.PI) angleDiff += 2 * Math.PI;
            while (angleDiff > Math.PI) angleDiff -= 2 * Math.PI;
            dolphin.angle += angleDiff * 0.1;

            drawDolphin();

            requestAnimationFrame(animate);
        }

        animate();
    </script>

</body>

</html>
