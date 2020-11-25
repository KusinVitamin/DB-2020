<html>

<head>
    <style>

        form {
            background-color:yellow;
            width:400px;
            border:2px solid black;
            margin:10px;
            padding:10px;



        }

    </style>

</head>

<body>
<div data-include="Header"></div>
<form method="get" action="Start.php">
    <button type="submit">Start Page</button>
</form>
<form method="POST" action="EmployeeCreated.php">
    First Name      <input type="text" name ="FnameInput" required> <br>
    Last Name       <input type="text" name ="LnameInput" required> <br>
    Password  		<input type="password" name ="PasswordInput" required> <br>
    Company         <input type ="tel" name ="CompanyInput" > <br>
    Company Password <input type="password" name ="CPasswordInput" required> <br>
    Email           <input type="text" name ="EmailInput" > <br>

    <button type ="submit">Create account</button>
</form>
</body>
</html>