<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>403 - Access Denied</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            width: 500px;
            max-width: 90%;

            padding: 50px 35px;

            border-radius: 15px;

            text-align: center;

            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .error-code {
            font-size: 90px;
            font-weight: bold;
            color: #dc3545;

            margin-bottom: 10px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 15px;

            color: #222;
        }

        p {
            color: #666;
            font-size: 16px;

            line-height: 1.6;

            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;

            padding: 12px 25px;

            background: #007bff;
            color: white;

            text-decoration: none;

            border-radius: 7px;

            transition: 0.3s;
        }

        .btn:hover {
            background: #0056b3;
        }

    </style>

</head>

<body>

    <div class="container">

        <div class="error-code">
            403
        </div>

        <h1>
            Access Denied
        </h1>

        <p>
            You do not have permission to access this page.
            Please contact the administrator if you think this is a mistake.
        </p>

        <a href="{{ url('/dashboard') }}" class="btn">
            Go To Dashboard
        </a>

    </div>

</body>

</html>