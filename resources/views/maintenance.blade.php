<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Back Soon | {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f4f1e8;
            --ink: #1f2d22;
            --muted: #5b6b5e;
            --accent: #3f7d4e;
            --leaf: rgba(63, 125, 78, 0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body { height: 100%; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            overflow: hidden;
            position: relative;
        }

        /* Soft organic shapes in the background */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50% 40% 55% 45%;
            background: var(--leaf);
            z-index: 0;
            animation: drift 18s ease-in-out infinite alternate;
        }

        body::before {
            width: 60vmax;
            height: 60vmax;
            top: -25vmax;
            right: -20vmax;
        }

        body::after {
            width: 45vmax;
            height: 45vmax;
            bottom: -20vmax;
            left: -15vmax;
            animation-delay: -9s;
        }

        @keyframes drift {
            to { transform: rotate(25deg) scale(1.08); }
        }

        main {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 36rem;
            animation: rise 0.9s ease-out both;
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(16px); }
        }

        .logo {
            width: 160px;
            max-width: 50vw;
            height: auto;
            margin-bottom: 2.5rem;
        }

        .eyebrow {
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        h1 {
            font-family: 'Fraunces', Georgia, serif;
            font-weight: 600;
            font-size: clamp(2.75rem, 9vw, 5rem);
            line-height: 1.05;
            letter-spacing: -0.02em;
            margin-bottom: 1.5rem;
        }

        .divider {
            width: 3rem;
            height: 3px;
            border-radius: 2px;
            background: var(--accent);
            margin: 0 auto 1.5rem;
        }

        p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: var(--muted);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; }
        }
    </style>
</head>
<body>
    <main>
        <img class="logo" src="{{ asset('images/toad-gully-growers.svg') }}" alt="{{ config('app.name') }}">
        <div class="eyebrow">Down for maintenance</div>
        <h1>Back Soon</h1>
        <div class="divider"></div>
        <p>We're tending to a few things behind the scenes. Please check back shortly.</p>
    </main>
</body>
</html>
