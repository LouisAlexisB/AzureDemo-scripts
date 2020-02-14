# Tuto : https://docs.microsoft.com/fr-fr/azure/key-vault/tutorial-python-linux-virtual-machine
# Install before : apt-get install python-mysql.connector

# importing the requests library
import requests
import mysql.connector

# Step 1: Fetch an access token from an MSI-enabled Azure resource
# Note that the resource here is https://vault.azure.net for the public cloud, and api-version is 2018-02-01
MSI_ENDPOINT = "http://169.254.169.254/metadata/identity/oauth2/token?api-version=2018-02-01&resource=https%3A%2F%2Fvault.azure.net"
r = requests.get(MSI_ENDPOINT, headers = {"Metadata" : "true"})
#print(r)
# Extracting data in JSON format
# This request gets an access token from Azure Active Directory by using the local MSI endpoint
data = r.json()
#print(data)
# Step 2: Pass the access token received from the previous HTTP GET call to the key vault
KeyVaultURL = "https://akvterraform.vault.azure.net//secrets/DBUser?api-version=2016-10-01"
secret = requests.get(url = KeyVaultURL, headers = {"Authorization": "Bearer " + data["access_token"]})
dbuser=(secret.json()["value"])

print(dbuser)

KeyVaultURL = "https://akvterraform.vault.azure.net//secrets/DBpwd?api-version=2016-10-01"
secret = requests.get(url = KeyVaultURL, headers = {"Authorization": "Bearer " + data["access_token"]})
dbpwd=(secret.json()["value"])
print(dbpwd)

cnx = mysql.connector.connect(user=dbuser, password=dbpwd,
                              host='10.0.2.50',
                              database='dbtest')
print(cnx)

mycursor = cnx.cursor()

mycursor.execute("SELECT * FROM clients")

myresult = mycursor.fetchall()

for x in myresult:
  print(x)

cnx.close()
