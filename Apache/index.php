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
// test attack XSS
echo "Bonjour ".$_POST['pseudo']." !";


// Gain DB user and password from Vault
$token_managedidentity=trim(`curl 'http://169.254.169.254/metadata/identity/oauth2/token?api-version=2018-02-01&resource=https%3A%2F%2Fvault.azure.net' -H Metadata:true | jq -r .access_token`);
$userDB=trim(`curl https://akvterraform.vault.azure.net//secrets/DBUser?api-version=2016-10-01 -H "Authorization: Bearer {$token_managedidentity}" | jq -r .value`);
$pwdDB=trim(`curl https://akvterraform.vault.azure.net//secrets/DBpwd?api-version=2016-10-01 -H "Authorization: Bearer {$token_managedidentity}" | jq -r .value`);


// IaaS DB with credentials into the code source :
//$mysqli = new mysqli('10.0.2.50', 'userweb', 'userweb@123', 'dbtest'); // connexion IaaS Mysql
// IaaS DB with credentials into the Vault :
$mysqli = new mysqli('10.0.2.50', $userDB, $pwdDB, 'dbtest'); // connexion IaaS Mysql
// PaaS instead of IaaS DB :
//$mysqli = new mysqli('testpaasmysql.mysql.database.azure.com', 'adminmysql@testpaasmysql', 'lab1234!', 'dbtest'); // connexion PaaS Mysql




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
