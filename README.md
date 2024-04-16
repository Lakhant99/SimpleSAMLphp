# SimpleSAMLphp https://mystudyhub99.blogspot.com/2024/01/installing-simplesamlphp-library-and.html
SAML stands for Security Assertion Markup Language, which is an XML-based data format for exchanging authentication and authorization data between an IDP (Identity Provider) and SP (Service Provider).
# There are two main parts to SSO
The Identity Provider: The SAML authority that provides the identity assertion to authenticate a user.
The Service Provider: The SAML consumer that provides the service for users.
# Requirements to set up SSO
SimpleSAMLphp Library
Drupal (Latest Version).
SimpleSAMLphp_auth Drupal module

# SIMPLESAMLPHP LIBRARY CONFIGURATIONS:

THERE ARE TWO WAYS TO CONFIGURE THE LIBRARY:-
# MANUAL
# USING DRUPAL SIMPLESAMLPHP PROVIDED (VENDOR FOLDER)

# STEP:- 1
# MANUAL
# Step 1:- Download the SimpleSAMLphp:-

There are two ways to download the library
Download the SimpleSAMLphp library from (https://simplesamlphp.org/download).

Use Command-Line Interface (CLI) for Version-Specific Download for Windows git bash:

curl -O -L "https://github.com/simplesamlphp/simplesamlphp/releases/download/X.Y.Z/simplesamlphp-X.Y.Z.tar.gz"

Replace X.Y.Z with the desired version number. For example, to download version 1.14.8, the command would be:

curl -O -L "https://github.com/simplesamlphp/simplesamlphp/releases/download/v1.14.8/simplesamlphp-1.14.8.tar.gz"

# Step 2:- Put the folder in the level of your docroot.
For example, I have created one folder on the root like private, and inside the private folder placed the SimpleSAMLphp Library which I downloaded via command and manual.

# Step 3:- In the docroot directory, 
create a symbolic link (named simplesaml) that points to the simplesamlphp-1.14.8/www directory in the DRUPAL_ROOT directory.

# Step 4: The command to create a symbolic link is :
ln -s ../private/simplesamlphp/www web/simplesaml (here my version is simplesamlphp-1.14.8)

# Step 5: To generate certificates, 
create a cert folder inside the simplesamlphp folder as (DRUPAL_ROOT/simplesamlphp/cert):

# Step 6: Run the following command inside the cert folder from the terminal:

openssl req -new -x509 -days 3652 -nodes -out saml.crt -keyout saml.pem

# Step 7: It will create two files saml.crt and saml.pem.

# Step 8: The configuration templates are present in the `private/simplesamlphp/config-templates` directory.
Create your config.php file using the available file in the config-templates directory using the command:

cp private/simplesamlphp/config-templates/config.php private/simplesamlphp/config/config.php

Create the new config folder and copy the `config.php` (holds SimpleSAMLphp configuration) file to the `private/simplesamlphp/config` folder and update the following values in the `$config` array:

# Step 9: At the bottom of the config.php file, add the following:
For receiving IDP requests change enable.saml20-idp’ => true in config/config.php
Change the store.type as sql
store.sql.dsn as mysql:host=localhost;dbname=db_name (change the host & db_name according to your values)
Store.sql.username as Drupal database user_name
Store.sql.password as Drupal database password
Change the admin password of the simplesaml setup auth.adminpassword
Add this line to end of the config.php file ($config[‘baseurlpath’] = ‘http://'. $_SERVER[‘HTTP_HOST’] .’/simplesaml/’;)

# IF YOU ARE PUSHING YOUR CODE ON THE PANTHEON SERVER.
Non-Composer Implementations Must Add The Following Lines To The Settings.Php File To Allow The Drupal Module To Locate SimpleSAMLphp:
# Provide A Universal Absolute Path To The Installation.
$Conf['Simplesamlphp_auth_installdir'] = $_ENV['HOME'] .'/Code/Private/Simplesamlphp';

# Step 10: Create your authsources.php file using the available file in the config-templates directory see the screenshot on step no 8.
Create your config.php file using the available file in the config-templates directory using the command:
cp private/simplesamlphp/config-templates/authsources.php private/simplesamlphp/config/authsources.php

# Step 11: Open the authsources.php you just created and add the following line at the very bottom of the file:
$config['default-sp']['entityID'] = '[UNIQUE-ID-OFTEN-A-DOMAIN-NAME]';

# Apache server

# Step 12: On the local need to update the virtual host (httpd-vhosts.config) file 

# Step 13: To configure the web server using Apache, you can edit the .htaccess file found in the Drupal root directory. Right after the line:

RewriteCond %{REQUEST_URI} !/core/modules/statistics/statistics.php$

Add the following lines:

# Allow access to simplesaml paths

RewriteCond %{REQUEST_URI} !^/simplesaml

# Step 14: Test the URL 
To confirm that the URL for your application is working, navigate to:
http://loca.stag/simplesaml
You should see the web interface for the SAML library:

# STEP:- 2 We completed the manual download library steps now using the Drupal internal library you can follow anyone.

Using Drupal SimpleSAMLphp provided (vendor folder):-
# Step 13: Install the simpleSAMLphp modules 
Use the following command to install the simpleSAMLphp and simplesamlphp_custom_attributes modules using Composer:
composer require drupal/simplesamlphp_auth:4.x-dev drupal/simplesamlphp_custom_attributes --prefer-dist
You should now see the simpleSAMLphp library in [root]/vendor/simplesamlphp.

# Step 14:  See Step 4 to create a symbolic link.

 Command is the same only change the relevant path

ln -s ../vendor/simplesamlphp/www web/simplesaml (here my version is simplesamlphp-1.14.8)

# Step 15:  Create the config folder and meta folder which is a private folder using the composer.

Add this symlink as a post-update script to composer.json. This allows the symlink to be recreated if you update or re-install SimpleSAMLphp using Composer:
"scripts": {
      "post-install-cmd": [
           "cp -r private/simplesamlphp/config vendor/simplesamlphp/simplesamlphp",
           "cp -r private/simplesamlphp/metadata vendor/simplesamlphp/simplesamlphp"
       ],
     "post-update-cmd": [
          "cp -r private/simplesamlphp/config vendor/simplesamlphp/simplesamlphp",
          "cp -r private/simplesamlphp/metadata vendor/simplesamlphp/simplesamlphp"
     ],
 },

ex:- The symlink folder path should be:- docroot/web/simplesaml/_include.php

SIMPLESAMLPHP LIBRARY CONFIGURATIONS IS DONE FOR BOTH LIBRARY INTERNAL AND EXTERNAL NOW NEXT STEP IS:-

# STEP 16:- EXCHANGE XML DATA WITH YOUR IDENTITY PROVIDER (IDP) ADMINISTRATOR (CLIENT).
To complete the connection between your Drupal developer portal service provider and your IdP, you must exchange XML data with your IdP.
Find the metadata for your Drupal developer portal at https://[portal.com]/simplesaml/module.php/saml/sp/metadata.php/default-sp, where [portal.com] is the URL of your Drupal developer portal.

Copy the XML document found there, you can just click on the which is screenshot and send it to the administrator of your IDP.

Ask your IDP for their metadata XML. You should specifically request the name of the attributes used by the IdP for the following:
email
first name
last name
user name
unique identifier.
Each of these attributes must be included in the SAML response from the IDP to your Drupal developer portal.

# STEP 17:- YOU GET THE XML FROM THE CLIENT END AND CONVERT THE XML RESPONSE FROM YOUR IDP, USING THE CONVERTER TOOL AVAILABLE AT SIMPLESAML/ADMIN/METADATA-CONVERTER.PHP
Paste the XML response from your idP into the tool.
Click Parse.
cp vendor/simplesamlphp/simplesamlphp/metadata-templates/saml20-idp-remote.php vendor/simplesamlphp/simplesamlphp/metadata/saml20-idp-remote.

If the parsed file does not say saml20-idp-remote, run the command above using the appropriate template filename that matches.

Open the saml20-idp-remote.php (or appropriate file) and paste in the parsed XML response from the IdP.

Note: You can see that the key of the $metadata array is the entityID of the idP. For example, if the line is:

$metadata['https://openidp.feide.no']
the key is 'https://openidp.feide.no'.

Open authsources.php once again, and add this line at the bottom, where [METADATA-KEY]is the entityID or the IdP:

    $config['default-sp']['idp'] = '[METADATA-KEY]';
    
Check the parsed file. If the file says saml20-idp-remote at the top, use the following command to create a metadata/saml20-idp-remote.php file in your SimpleSAMLphp directory:

# STEP 18:- ENABLE AND CONFIGURE YOUR SIMPLESAMLPHP MODULES
GOTO-> ADMIN->CONFIG
NOW OPEN THE MODULE CONFIG >  SIMPLESAMLPHP_CUSTOM_ATTRIBUTES
CLICK ADD MAPPING.
SELECT “USERNAME” FROM THE AVAILABLE DROPDOWN AND ENTER THE ATTRIBUTE NAME PROVIDED BY YOUR IDP.
CLICK SAVE.
CLICK ADD MAPPING.
SELECT “MAIL” FROM THE AVAILABLE DROPDOWN AND ENTER THE ATTRIBUTE NAME PROVIDED BY YOUR IDP.
CLICK SAVE.
NOW OPEN THE MODULE CONFIG > SIMPLESAMLPHP_AUTH

OPTIONAL:-  IF YOU SET THE CONFIGURATION THOUGH THE CODE YOU CAN JUST PAST THE CODE SETTING.PHP

// SIMPLESAMLPHP CONFIGURATION
# PROVIDE UNIVERSAL ABSOLUTE PATH TO THE INSTALLATION.
IF (ISSET($_ENV['AH_SITE_NAME']) && IS_DIR('/VAR/WWW/HTML/' . $_ENV['AH_SITE_NAME'] . '/SIMPLESAMLPHP-1.14.8')) {
  $SETTINGS['SIMPLESAMLPHP_DIR'] = '/VAR/WWW/HTML/' . $_ENV['AH_SITE_NAME'] . '/SIMPLESAMLPHP-1.14.8';
}
ELSE {
  // LOCAL SAML PATH.
  IF (IS_DIR(DRUPAL_ROOT . '/../SIMPLESAMLPHP-1.14.8')) {
    $SETTINGS['SIMPLESAMLPHP_DIR'] = DRUPAL_ROOT . '/../SIMPLESAMLPHP-1.14.8';
  }
}
// SIMPLESAMLPHP_AUTH MODULE SETTINGS
$CONFIG['SIMPLESAMLPHP_AUTH.SETTINGS'] = [
 // BASIC SETTINGS.
    'ACTIVATE'                => TRUE, // ENABLE OR DISABLE SAML LOGIN.
    'AUTH_SOURCE'             => 'DEFAULT-SP',
    'LOGIN_LINK_DISPLAY_NAME' => 'LOGIN WITH YOUR SSO ACCOUNT',
    'REGISTER_USERS'          => TRUE,
    'DEBUG'                   => FALSE,
 // LOCAL AUTHENTICATION.
    'ALLOW' => ARRAY(
      'DEFAULT_LOGIN'         => TRUE,
      'SET_DRUPAL_PWD'        => TRUE,
      'DEFAULT_LOGIN_USERS'   => '',
      'DEFAULT_LOGIN_ROLES'   => ARRAY(
        'AUTHENTICATED' => FALSE,
        'ADMINISTRATOR' => 'ADMINISTRATOR',
      ),
    ),
    'LOGOUT_GOTO_URL'         => '',
 // USER INFO AND SYNCING.
 // 'UNIQUE_ID' THE VALUE WHICH IS UNIQUE IN THE SAML RESPONSE COMING FROM IDP.
    'UNIQUE_ID'               => 'MAIL',
    'USER_NAME'               => 'USERNAME',
    'MAIL_ATTR'               => 'MAIL',
    'SYNC' => ARRAY(
        'MAIL'      => TRUE,
        'USER_NAME' => TRUE,
    ),
];

# STEP 19:- NOW WE CAN CHECK WITH OUR LOCAL ENVIRONMENT.
# STEP 1:- GOTO THE CONFIG.PHP FILE AND INSIDE THE CODE UNCOMMENT THE CODE.

# STEP 2:- GOTO THE AUTHSOURCES.PHP AND UNCOMMENT THE LINE WHICH IS IN THE SCREENSHOT.


 'example-userpass' => [
        'exampleauth:UserPass',
        'student:studentpassword' => [
        'uid' => ['student'],
        'eduPersonAffiliation' => ['member', 'student'],
        'email' => 'student@example.com'
        ],
        'employee:employeepassword' => [
        'uid' => ['employee'],
        'eduPersonAffiliation' => ['member', 'employee'],
        'email' => 'employee@example.com'
        ],
    ],

# STEP 3:- YOU CAN CHECK ADFS-IDP-HOSTED.PHP FILE ALREADY THERE INSIDE YOUR META FOLDER. 

# STEP 4:- NOW WE NEED TO CREATE THE CERTIFICATE FOR CONFIGURING IDP, CREATE SSL SELF-SIGNED CERTIFICATE. RUN FOLLOWING COMMAND INSIDE CERT FOLDER.

OPENSSL REQ -NEWKEY RSA:3072 -NEW -X509 -DAYS 3652 -NODES -OUT SERVER.CRT -KEYOUT SERVER.PEM

# STEP 5:- IDP NEEDS TO BE CONFIGURED BY THE METADATA STORED IN METADATA/SAML20-IDP-HOSTED.PHP

# CONFIGURING IDP WITH THE SP
Exchange the metadata between the Identity Provider & Service Provider.

Copy IDP metadata to the metadata/saml20-idp-remote.php file of the Service Provider. IDP metadata can be found in the “SAML 2.0 IdP Metadata” section of the Federation tab of IDP application.

Copy SP metadata to the metadata/saml20-sp-remote.php file of the Identity Provider. SP metadata can be found in the “SAML 2.0 SP Metadata” section of the Federation tab of SP application.

Log in to ‘default-sp’ by clicking on “Test configured authentication source” link of the Authentication tab of the SP.
username: student
password: studentpassword





