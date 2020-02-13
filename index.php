<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
  <title>test website</title>
</head>

<body>
<img src="axa.png">

<h1><?php echo "Server '".gethostname()."' - private IP address = ".$_SERVER["SERVER_ADDR"]." / public IP = ".$_SERVER["SERVER_NAME"]; ?></h1>

<form method="post" action="index.php">
        <input type="texte" name="pseudo" />
        <input type="submit" value="Connection" />
</form>


<?php
//error_reporting(E_ALL); ini_set('display_errors', '1');

// Gain DB user and password from Vault
$token_managedidentity=`curl 'http://169.254.169.254/metadata/identity/oauth2/token?api-version=2018-02-01&resource=https%3A%2F%2Fvault.azure.net' -H Metadata:true | jq -r .access_token`;

$userdb=`curl https://akvterraform.vault.azure.net//secrets/MySql-User?api-version=2016-10-01 -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6IkhsQzBSMTJza3hOWjFXUXdtak9GXzZ0X3RERSIsImtpZCI6IkhsQzBSMTJza3hOWjFXUXdtak9GXzZ0X3RERSJ9.eyJhdWQiOiJodHRwczovL3ZhdWx0LmF6dXJlLm5ldCIsImlzcyI6Imh0dHBzOi8vc3RzLndpbmRvd3MubmV0L2Q5NzJjOTc3LTM0YmEtNGI5Zi1iMWViLTMxNDJiMTA2ZWM0ZS8iLCJpYXQiOjE1ODE0MzAzMjIsIm5iZiI6MTU4MTQzMDMyMiwiZXhwIjoxNTgxNDU5NDIyLCJhaW8iOiI0Mk5nWUpnZmNXV2F3K3hWVEVxL0MyZHFOcDY5Q0FBPSIsImFwcGlkIjoiYzdjNDI5NDgtOTI3Zi00ZmM4LTk2MzMtMWZkNTZmMjUwNWU5IiwiYXBwaWRhY3IiOiIyIiwiaWRwIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvZDk3MmM5NzctMzRiYS00YjlmLWIxZWItMzE0MmIxMDZlYzRlLyIsIm9pZCI6IjM4NmJlY2RjLTRhZTItNGFkYy1hOGI3LTEyMTQ5NWVkYTQzMCIsInN1YiI6IjM4NmJlY2RjLTRhZTItNGFkYy1hOGI3LTEyMTQ5NWVkYTQzMCIsInRpZCI6ImQ5NzJjOTc3LTM0YmEtNGI5Zi1iMWViLTMxNDJiMTA2ZWM0ZSIsInV0aSI6IlpDYTdiS2FFUkVXLWJSZXp0aW5WQUEiLCJ2ZXIiOiIxLjAiLCJ4bXNfbWlyaWQiOiIvc3Vic2NyaXB0aW9ucy82NmM1MGI4ZS00NDQ2LTQzOGItODFlOC1kOTk2ZGYzYmExNTIvcmVzb3VyY2Vncm91cHMvT0NELVJHLVRlc3RGb3JtYXRpb24vcHJvdmlkZXJzL01pY3Jvc29mdC5Db21wdXRlL3ZpcnR1YWxNYWNoaW5lcy9ETVoxLVZNIn0.LnQrEfSjgh5XYvCTg5imSc07YwDyq93VY13w63B5Wn33qneMzYAPeMDb1wa-pycHHMfDgoqwmq6N-xQZw6PKbfnel7wyE9UCbDIsBlZVtoDq-Gk6WNo05QlOHvZqQtgNYnvrw5SeB1wP835dzuMeXDlmZuJFgGDS7j9WJ02BziF_hiBQ7n0IWYzmjgf-qq2vly_zljJI6jHynvJIeKwA34Y4LEb4lUf2-1_AnWWTFBPk1VAyUwRGCFd4p08GSV8SSVQD1-cIlDjUeO2uZHkXe0wpF7Rw9V8JtssMEmpOeuhyKAtSP-44_va9vMn_U3RKWaOr9PLF36_Yg17-d44aEA" | jq -r .value`;


$mdpdb=`curl https://akvterraform.vault.azure.net//secrets/MySql-MDP?api-version=2016-10-01 -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6IkhsQzBSMTJza3hOWjFXUXdtak9GXzZ0X3RERSIsImtpZCI6IkhsQzBSMTJza3hOWjFXUXdtak9GXzZ0X3RERSJ9.eyJhdWQiOiJodHRwczovL3ZhdWx0LmF6dXJlLm5ldCIsImlzcyI6Imh0dHBzOi8vc3RzLndpbmRvd3MubmV0L2Q5NzJjOTc3LTM0YmEtNGI5Zi1iMWViLTMxNDJiMTA2ZWM0ZS8iLCJpYXQiOjE1ODE0MzAzMjIsIm5iZiI6MTU4MTQzMDMyMiwiZXhwIjoxNTgxNDU5NDIyLCJhaW8iOiI0Mk5nWUpnZmNXV2F3K3hWVEVxL0MyZHFOcDY5Q0FBPSIsImFwcGlkIjoiYzdjNDI5NDgtOTI3Zi00ZmM4LTk2MzMtMWZkNTZmMjUwNWU5IiwiYXBwaWRhY3IiOiIyIiwiaWRwIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvZDk3MmM5NzctMzRiYS00YjlmLWIxZWItMzE0MmIxMDZlYzRlLyIsIm9pZCI6IjM4NmJlY2RjLTRhZTItNGFkYy1hOGI3LTEyMTQ5NWVkYTQzMCIsInN1YiI6IjM4NmJlY2RjLTRhZTItNGFkYy1hOGI3LTEyMTQ5NWVkYTQzMCIsInRpZCI6ImQ5NzJjOTc3LTM0YmEtNGI5Zi1iMWViLTMxNDJiMTA2ZWM0ZSIsInV0aSI6IlpDYTdiS2FFUkVXLWJSZXp0aW5WQUEiLCJ2ZXIiOiIxLjAiLCJ4bXNfbWlyaWQiOiIvc3Vic2NyaXB0aW9ucy82NmM1MGI4ZS00NDQ2LTQzOGItODFlOC1kOTk2ZGYzYmExNTIvcmVzb3VyY2Vncm91cHMvT0NELVJHLVRlc3RGb3JtYXRpb24vcHJvdmlkZXJzL01pY3Jvc29mdC5Db21wdXRlL3ZpcnR1YWxNYWNoaW5lcy9ETVoxLVZNIn0.LnQrEfSjgh5XYvCTg5imSc07YwDyq93VY13w63B5Wn33qneMzYAPeMDb1wa-pycHHMfDgoqwmq6N-xQZw6PKbfnel7wyE9UCbDIsBlZVtoDq-Gk6WNo05QlOHvZqQtgNYnvrw5SeB1wP835dzuMeXDlmZuJFgGDS7j9WJ02BziF_hiBQ7n0IWYzmjgf-qq2vly_zljJI6jHynvJIeKwA34Y4LEb4lUf2-1_AnWWTFBPk1VAyUwRGCFd4p08GSV8SSVQD1-cIlDjUeO2uZHkXe0wpF7Rw9V8JtssMEmpOeuhyKAtSP-44_va9vMn_U3RKWaOr9PLF36_Yg17-d44aEA" | jq -r .value`;
echo $mdpdb;


// test attack XSS
echo "Bonjour ".$_POST['pseudo']." !";

// PaaS instead of IaaS DB
$mysqli = new mysqli('testpaasmysql.mysql.database.azure.com', 'adminmysql@testpaasmysql', 'lab1234!', 'dbtest'); // connexion PaaS Mysql
//$mysqli = new mysqli('10.0.2.50', 'userweb', 'userweb@123', 'dbtest'); // connexion IaaS Mysql

if ($mysqli->connect_errno) {
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit;
}

$res = $mysqli->query("SELECT * FROM clients;");

echo "<h2>Clients list :</h2>";
echo "<table>";
echo "<tr><td><b>Client name</td><td><b>Contract number</td><td><b>Subscription date</td></tr>";
while ($data = mysqli_fetch_array($res)) {
echo "<tr><td>".$data['name']."</td><td>".$data['numcontract']."</td><td>".$data['date-subscription']."</td></tr>";
}
echo "</table>";



$res2 = $mysqli->query("SELECT * FROM clients,commands WHERE commands.id_client = clients.id_client;");

echo "<br><H2>Commands list :</h2><table>";
echo "<tr><td><b>Client name</td><td><b>Date</td><td><b>Price</td></tr>";
while ($data = mysqli_fetch_array($res2)) {
echo "<tr><td>".$data['name']."</td><td>".$data['date_command']."</td><td>".$data['price']." $</td></tr>";
}
echo "</table>";

?>

<h1>Client research :</h1>
<form method="get" action="index.php">
        <input type="texte" name="clientname" />
        <input type="submit" value="Search" />
</form>

<?php
// test attack MYSQL injection

$res3 = $mysqli->query("SELECT * FROM clients WHERE name='".$_GET['clientname']."';");

echo "<h2>Clients detail :</h2>";
echo "<table>";
echo "<tr><td><b>Client name</td><td><b>Contract number</td><td><b>Subscription date</td></tr>";
while ($data = mysqli_fetch_array($res3)) {
echo "<tr><td>".$data['name']."</td><td>".$data['numcontract']."</td><td>".$data['date-subscription']."</td></tr>";
}
echo "</table>";

mysqli_close($conn);
?>
</body>
</html>
