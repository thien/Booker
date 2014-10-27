<?php
include('../includes/connection.php'); 
   
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $forename = $_POST['forename'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $email_confirm = $_POST['email_confirm'];
        $phoneno = $_POST['phoneno'];
    
        if (empty($username) or empty($password)) {
            $error = 'All fields are required!';
        }  elseif ($password != $password_confirm) {
            $error = 'All fields are required!';
        }
          elseif ($email != $email_confirm) {
            $error = 'All fields are required!';
        }
         else {
        $query = $pdo->prepare('INSERT INTO client (username, password, forename, surname, email, phoneno, activated) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $query->bindValue(1, $username);
        $query->bindValue(2, $password);
        $query->bindValue(3, $forename);
        $query->bindValue(4, $surname);
        $query->bindValue(5, $email);
        $query->bindValue(6, $phoneno);
        $query->bindValue(7, '0');
        $query->execute();
        header('Location: confirmation.php');
        }

?>

<html>
<head>
<title>Register</title>
</head>
<body>

<?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
            <?php }?>

<form method="post" action="index.php" autocomplete="on"> 
    <h1> Sign up </h1> 
    <p> 
         <label>First Name:</label>
         <input name="forename" required="required" type="text" placeholder="First" />
    </p>
    <p> 
         <label>Last Name:</label>
         <input name="surname" required="required" type="text" placeholder="Last" />
    </p>

<hr>

    <p> 
         <label>Username:</label>
         <input name="username" type="text" placeholder="Username" />
    </p>
    <p> 
         <label>Password:</label>
         <input name="password" type="password" placeholder="Password"/>
    </p>
    <p> 
         <label>Confirm Password:</label>
         <input name="password_confirm" type="password" placeholder="Password"/>
    </p>

    <hr>

    <p> 
         <label>Email:</label>
         <input id="email" name="email" type="email" placeholder="example@domain.com"/> 
    </p>
        <p> 
         <label>Email:</label>
         <input id="email_confirm" name="emailsignup_confirm" type="email" placeholder="example@domain.com"/> 
    </p>
            <p> 
         <label>Phone Number:</label>
         <input name="phoneno" type="number" placeholder=""/> 
    </p>
    <p> 
         <label>Date of Birth:</label>
         <select name="month" onChange="changeDate(this.options[selectedIndex].value);">
         <option value="na">Month</option>
         <option value="1">January</option>
         <option value="2">February</option>
         <option value="3">March</option>
         <option value="4">April</option>
         <option value="5">May</option>
         <option value="6">June</option>
         <option value="7">July</option>
         <option value="8">August</option>
         <option value="9">September</option> 
         <option value="10">October</option>
         <option value="11">November</option>
         <option value="12">December</option>
         </select>
         <select name="day" id="day">
         <option value="na">Day</option>
         </select>
         <select name="year" id="year">
         <option value="na">Year</option>
         </select>
         <script type="text/javascript">
         function changeDate(i){
         var e = document.getElementById('day');
         while(e.length>0)
         e.remove(e.length-1);
         var j=-1;
         if(i=="na")
         k=0;
         else if(i==2)
         k=28;
         else if(i==4||i==6||i==9||i==11)
         k=30;
         else
         k=31;
         while(j++<k){
         var s=document.createElement('option');
         var e=document.getElementById('day');
         if(j==0){
         s.text="Day";
         s.value="na";
         try{
         e.add(s,null);}
         catch(ex){
         e.add(s);}}
         else{
         s.text=j;
         s.value=j;
         try{
         e.add(s,null);}
         catch(ex){
         e.add(s);}}}}
         y = 1998;
         while (y-->1908){
         var s = document.createElement('option');
         var e = document.getElementById('year');
         s.text=y;
         s.value=y;
         try{
         e.add(s,null);}
         catch(ex){
         e.add(s);}}
         </script> 
    </p>
    <input type="submit" value="Register"/> 
</form>


</body>
</html>