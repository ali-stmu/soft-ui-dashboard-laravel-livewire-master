<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New ORIC Form Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f4f4f4;
            border-radius: 5px;
        }

        strong {
            color: #34495e;
        }

        .cta {
            margin-top: 20px;
            text-align: center;
        }

        .cta a {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .cta a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>New ORIC Form Created</h1>
        <p>A new ORIC form has been created with the following details:</p>
        <ul>
            <li><strong>Project Title:</strong> {{ $formData['project_title'] }}</li>
            <li><strong>Expected Start Date:</strong> {{ $formData['expected_start_date'] }}</li>
            <li><strong>Duration of Project:</strong> {{ $formData['duration_of_project'] }} months</li>
            <li><strong>Total Fund Requested:</strong> Rs.{{ $formData['total_fund_requested'] }}</li>
            <li><strong>Principal Investigator Name:</strong> {{ $formData['pi_name'] }}</li>
            <!-- Add other relevant fields here -->
        </ul>
        <div class="cta">
            <p>Please log in to your account for further details:</p>
            <a href="https://cms.stmu.edu.pk/" target="_blank">Login to Your Account</a>
        </div>
    </div>
</body>

</html>
