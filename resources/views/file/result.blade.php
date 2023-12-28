<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Encryptor Result</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1, h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>File Details:</h1>
    <ul>
        <li>Name: {{ $fileDetails['name'] }}</li>
        <li>Size: {{ $fileDetails['size'] }} bytes</li>
        <li>Extension: {{ $fileDetails['extension'] }}</li>
    </ul>

    <h1>Operation: {{ ucfirst($operation) }}</h1>

    <h2>Output File: <a href="{{ asset($outputFilePath) }}" download>{{ $outputFilePath }}</a></h2>
</body>
</html>
