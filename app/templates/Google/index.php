<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding-bottom: 100px;
        }
        .logo {
            font-size: 90px;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .logo span:nth-child(1) { color: #4285F4; }
        .logo span:nth-child(2) { color: #EA4335; }
        .logo span:nth-child(3) { color: #FBBC05; }
        .logo span:nth-child(4) { color: #4285F4; }
        .logo span:nth-child(5) { color: #34A853; }
        .logo span:nth-child(6) { color: #EA4335; }
        .search-box {
            width: 580px;
            max-width: 90%;
            margin-bottom: 30px;
            position: relative;
        }
        .search-input {
            width: 100%;
            height: 44px;
            border: 1px solid #dfe1e5;
            border-radius: 24px;
            padding: 0 50px;
            font-size: 16px;
            outline: none;
        }
        .search-input:hover, .search-input:focus {
            box-shadow: 0 1px 6px rgba(32,33,36,.28);
            border-color: rgba(223,225,229,0);
        }
        .search-icon {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #9aa0a6;
        }
        .buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        .button {
            background-color: #f8f9fa;
            border: 1px solid #f8f9fa;
            border-radius: 4px;
            color: #3c4043;
            font-size: 14px;
            padding: 10px 16px;
            cursor: pointer;
        }
        .button:hover {
            box-shadow: 0 1px 1px rgba(0,0,0,.1);
            border: 1px solid #dadce0;
            color: #202124;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <span>G</span><span>o</span><span>o</span><span>g</span><span>l</span><span>e</span>
        </div>
        <div class="search-box">
            <div class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <input type="text" class="search-input" autofocus>
        </div>
        <div class="buttons">
            <button class="button">Google 検索</button>
            <button class="button">I'm Feeling Lucky</button>
        </div>
    </div>
</body>
</html>
