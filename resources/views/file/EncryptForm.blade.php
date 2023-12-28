<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Encryptor</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 40%;
            width: 100%;
            text-align: center;
        }

        input[type="file"] {
            display: none;
        }

        select {
            width: 80%; /* Adjust the width as needed */
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        label {
            cursor: pointer;
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
            display: inline-block;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        label:hover {
            background-color: #2980b9;
        }

        #fileDetails {
            margin-top: 20px;
            text-align: left;
        }

        button {
            background-color: #2ecc71;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <form action="{{ route('file.process') }}" method="post" enctype="multipart/form-data">
        @csrf

        @error('file')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <label for="file">Select file</label>
        <input type="file" name="file" id="file" onchange="displayFileDetails()">

        <div id="fileDetails"></div>

        @error('operation')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <label for="operation">Operation:</label>
        <select name="operation">
            <option value="encrypt">Encrypt</option>
            <option value="decrypt">Decrypt</option>
        </select>

        @error('output_name')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <label for="output_name">Output Name:</label>
        <input type="text" name="output_name" value="">

        @error('output_path')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <label for="output_path">Output Path</label>
        <input type="text" name="output_path" value="">

        <button type="submit">Submit</button>
    </form>

    <script>
        function displayFileDetails() {

            console.log("hello")
            const fileInput = document.getElementById('file');
            const fileDetailsDiv = document.getElementById('fileDetails');

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSizeKB = Math.round(file.size / 1024);

                fileDetailsDiv.innerHTML = `
                    <p><strong>File Details:</strong></p>
                    <ul>
                        <li><strong>Name:</strong> ${file.name}</li>
                        <li><strong>Size:</strong> ${fileSizeKB} KB</li>
                        <li><strong>Type:</strong> ${file.type}</li>
                    </ul>
                `;
            } else {
                fileDetailsDiv.innerHTML = ''; // Clear file details if no file selected
            }
        }
    </script>
</body>
</html>
