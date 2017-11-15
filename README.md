# Marvin Temp-Humidity KPNLoRa
Sending humidity en temperature data from Marvin through the lora network of KPN (Dutch cellphone compony)
In this example, I'm receiving this information on a simple php server and will store the data in a database and send it with the use of a telegram bot to a specified user as well

For this to function you need 3 pieces of hardware
* [Marvin: the LoRa development board](https://www.kickstarter.com/projects/688158475/marvin-the-lora-development-board) - The Marvin board with LoRa compatibility
* [Grove - Temperature and Humidity Sensor Pro](http://wiki.seeed.cc/Grove-Temperature_and_Humidity_Sensor_Pro/) - The humidity and temperature sensor from grove. Others will work too, but you will have to alter the code
* [A Web-server](https://m.do.co/c/5307d376ecef) - A php server to handle the php post request send by the KPN network. I'm using a ubuntu vps from [DigitalOcean](https://m.do.co/c/5307d376ecef)

Futhermore, you need three pieces of software/accounts
* [Arduino IDE](https://www.arduino.cc/en/Main/Software) For uploading code to your Marvin
* [A Account on KPN LORA](https://loradeveloper.mendixcloud.com/login.html) A trail account is available for 90 days
* [A telegram account](https://telegram.org) For sending telegram message to a user

## Installing

### First step: Installing software
First of all, clone this repository to a folder
`Git clone https://github.com/Casburggraaf/Marvin_Temp-Humidity_kpnLoRa`

Secondly, install the the Arduino IDE
Try to upload the first ino "blink.ino" to the Marvin board. For the arduino setting, see the screenshot below (this example is based on a mac configuration)

![Screenshot](../master/images/screenshot_arduino.png)

Finally, make a account on [Kpn Lora](https://loradeveloper.mendixcloud.com/login.html)

### Second step: Getting the keys for the LoRa network
You need three unique keys that need to be remembered
* Device EUI - Open the MarvinMultiSerial.ino and upload it to your Marvin. Open the serial monitor and type
'sys get hweui'
The result is your device EUI.
* Apps Key - This is a random generated key. An example to generate one is:
'openssl enc -aes-128-cbc -k secret -P -md sha1'
* nwkskey - This key can be obtained by the KPN LoRa portal after entering the two keys above

### Thirt step: Connect sensor to the Marvin

![marvin setup](../master/images/marvin_sensor.jpg)

Connect the sensor to A3. See the pin overview below to see the available pin numbers.

![marvin pinview](../master/images/marvin_pins.jpeg)

### Forth step: Config the marvin
Open the Temp-Humidity_lora.ino and change the following settings before uploading.
* String 27-29 - See step 2 for this information
* String 36 - Edit the pin number of the connected sensor

Upload the sketch to your Marvin and check on the portal debug page if the data is coming through

### Fifth Step: Setting op the Telegram chatbot
Open your telegram messenger and send the following to the user "BotFather"
`/newbot`
Follow the remaining steps and write down the name and the api code.
For more help visit [this link](https://core.telegram.org/bots)

You will also need the chat id, you can obtain this by starting a conversation with "get_id_bot" and type:
'/start'

### Sixth Step: Config your server
First create a database, and make a table with two fields: info and timestamp. Info is a string and timestamp is an automatic field that attaches the date and time when you add an entry to the database.
Write down the following:
* Server IP
* user
* password
* Database Name

Open the "recieve.php" and edit these lines
* 4-5 with the information from step 5
* 18-21 with your database information from this step
* 55 here you can change the string formatting for the telegram bot.

Finally upload this php file to your server.

### Final Step: DEBUGGGGINGG
Test if it works accordingly.
If it doesn't work, you can check multiple things that could solve the problem
* Telegram - Check if there is an entry created in your database. If that's the case, make sure to check your telegram settings
* Recieve.php - If there is no entry created. Check in the debug page on KPN LoRa if there is data coming through
* KPN connection - If there is no data coming trough, check if the keys are entered correctly


## Authors
[Cas Burggraaf](https://www.casburggraaf.com) - Student of [Amsterdam University of Applied Sciences](http://www.amsterdamuas.com) in Amsterdam

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Sources
Images are made by my self or are from this [github repo](https://github.com/iotacademy/marvin/tree/master/Software)
Arduino code is based on [MarvinBase_temp_humid_sensor/](https://github.com/iotacademy/marvin/tree/master/Software/MarvinBase_temp_humid_sensor) and dth is used from [adafruit](https://github.com/adafruit/DHT-sensor-library)
