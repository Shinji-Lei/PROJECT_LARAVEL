<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <style>
        /* --- Global Styles --- */
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #222;
            /* Background Image with Dark Overlay */
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/images/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* --- Header --- */
        header {
            background: #1a202c;
            color: #fff;
            padding: 20px 32px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            border-bottom: 1px solid rgba(229, 62, 62, 0.3);
        }

        /* --- Main Content Area --- */
        .main-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 16px;
        }

        .container {
            max-width: 900px;
            width: 100%;
        }

        /* --- Glassmorphism Card --- */
        .card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(229, 62, 62, 0.4);
            box-shadow: 
                0 4px 6px rgba(0,0,0,0.1),
                0 0 15px rgba(229, 62, 62, 0.25),
                inset 0 0 5px rgba(229, 62, 62, 0.15);
            padding: 40px;
        }

        /* --- Footer --- */
        footer {
            background: #1a202c;
            color: #a0aec0;
            padding: 16px 32px;
            text-align: center;
            font-size: 14px;
            border-top: 1px solid rgba(229, 62, 62, 0.3);
        }

        /* --- Table & Form Elements --- */
        table { width: 100%; border-collapse: collapse; color: #e2e8f0; margin-top: 20px; }
        th, td { text-align: left; padding: 12px 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        th { background: rgba(26, 32, 44, 0.8); color: #fff; }
        
        /* --- NEW: Unified Glowing Buttons --- */
        .btn {
            display: inline-block; 
            padding: 8px 16px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 600;
            border: 1px solid rgba(229, 62, 62, 0.4);
            background: rgba(26, 32, 44, 0.6);
            color: #fff;
            cursor: pointer; 
            transition: all 0.25s ease-in-out;
        }

        /* Button Red Glow on Hover & Click */
        .btn:hover, .btn:active {
            background: rgba(229, 62, 62, 0.2);
            border-color: #e53e3e;
            box-shadow: 0 0 12px rgba(229, 62, 62, 0.6), inset 0 0 4px rgba(229, 62, 62, 0.4);
            transform: translateY(-1px);
        }

        /* Specific variant overrides if you want color distinction */
        .btn-primary { background: rgba(49, 130, 206, 0.4); border-color: rgba(49, 130, 206, 0.6); }
        .btn-primary:hover { background: rgba(49, 130, 206, 0.6); border-color: #63b3ed; box-shadow: 0 0 12px rgba(99, 179, 237, 0.6); }

        .btn-edit { background: rgba(236, 201, 75, 0.4); border-color: rgba(236, 201, 75, 0.6); color: #fff; }
        .btn-edit:hover { background: rgba(236, 201, 75, 0.6); border-color: #f6e05e; box-shadow: 0 0 12px rgba(246, 224, 94, 0.6); }

        .btn-delete { background: rgba(229, 62, 62, 0.4); border-color: rgba(229, 62, 62, 0.6); }
        .btn-delete:hover { background: rgba(229, 62, 62, 0.6); border-color: #fc8181; box-shadow: 0 0 12px rgba(252, 129, 129, 0.6); }

        .btn-status { background: rgba(56, 161, 105, 0.4); border-color: rgba(56, 161, 105, 0.6); }
        .btn-status:hover { background: rgba(56, 161, 105, 0.6); border-color: #68d391; box-shadow: 0 0 12px rgba(104, 211, 145, 0.6); }

        .status-pending { color: #f6ad55; font-weight: bold; }
        .status-completed { color: #68d391; font-weight: bold; }
        
        form.inline { display: inline; }
        
        input[type=text], textarea, input[type=date], select {
            width: 100%; padding: 12px; margin-top: 6px; margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 6px; 
            background: rgba(26, 32, 44, 0.7); color: #e2e8f0;
            transition: all 0.2s;
        }

        /* Input field red glow when clicking/typing */
        input[type=text]:focus, textarea:focus, input[type=date]:focus, select:focus {
            outline: none;
            border-color: #e53e3e;
            box-shadow: 0 0 10px rgba(229, 62, 62, 0.4);
        }

        label { font-weight: 600; font-size: 14px; color: #e2e8f0; }
        
        .alert-success {
            background: rgba(104, 211, 145, 0.2); color: #9ae6b4;
            padding: 16px; border-radius: 8px; margin-bottom: 24px;
            border: 1px solid #48bb78; font-weight: 600; text-align: center;
        }

        h1, h2 { color: #fff; text-align: center; margin-top: 0; }
    </style>
</head>
<body>
    <header>SHINJI"S TASK MANAGER</header>

    <div class="main-wrapper">
        <div class="container">
            {{-- Flash message shown after actions --}}
            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Page-specific content goes here --}}
            @yield('content')
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Task Manager Pro. All rights reserved.
    </footer>
</body>
</html>