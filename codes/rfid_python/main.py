#!/usr/bin/env python

import RPi.GPIO as GPIO
import SimpleMFRC522
import requests
import time

reader = SimpleMFRC522.SimpleMFRC522()
url = "http://localhost/rfid/public/card-read/"
card_id = 0
new_card_id = 1

while True:
        card_id, text = reader.read()
        if card_id != new_card_id:
                new_card_id = card_id
                r = requests.get(url+str(card_id))
                print('card ID : ')
                print(card_id)
                time.sleep(5)
                card_id = 0
                new_card_id = 1
                print('clear')

