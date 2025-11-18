<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EduDeadline</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .phone-container {
            background: #1a1a1a;
            border-radius: 40px;
            padding: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 375px;
            position: relative;
        }
        
        .phone-container::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 25px;
            background: #1a1a1a;
            border-radius: 0 0 20px 20px;
            z-index: 10;
        }
        
        .phone-container::after {
            content: '';
            position: absolute;
            top: 22px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 6px;
            background: #333;
            border-radius: 3px;
            z-index: 11;
        }
        
        .screen {
            background: white;
            border-radius: 30px;
            overflow: hidden;
            height: 650px;
            display: flex;
            flex-direction: column;
        }
        
        /* HEADER */
        .header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .header-title {
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .header-title a {
            color: white;
            text-decoration: none;
        }
        
        .header-icons {
            display: flex;
            gap: 15px;
            font-size: 20px;
        }
        
        .header-icons a {
            color: white;
            text-decoration: none;
        }
        
        /* CONTENT */
        .content {
            flex: 1;
            padding: 20px;
            background: #f5f5f5;
            overflow-y: auto;
        }
        
        /* BUTTON */
        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #f0f0f0;
            color: #666;
        }
        
        .btn-danger {
            background: #ff4757;
            color: white;
        }
        
        .btn-success {
            background: #2ed573;
            color: white;
        }
        
        /* INPUT */
        .input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            transition: border 0.3s;
        }
        
        .input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        /* CARD */
        .card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        
        /* LOGIN SPECIFIC */
        .login-screen {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            height: 100%;
        }
        
        .logo {
            font-size: 70px;
            margin-bottom: 15px;
        }
        
        .app-name {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 40px;
        }
        
        /* UTILITY */
        .mb-15 { margin-bottom: 15px; }
        .mb-20 { margin-bottom: 20px; }
        .text-center { text-align: center; }
        .flex { display: flex; }
        .gap-10 { gap: 10px; }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .phone-container {
                max-width: 100%;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="phone-container">
        <div class="screen">
            @yield('content')
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>