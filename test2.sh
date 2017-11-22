#!/bin/bash

#SDO validation
SLEEP_TIME=240

VM=$( virsh list | grep trcd1 | awk '{print $2 }')

echo "VIRSH VM NAME: $VM"

echo "Aspetto $SLEEP_TIME secondi"
sleep $SLEEP_TIME

echo "Notifico la disponibilita' di sole 2 CPU $VM"
date +%s
php up.php 2

echo "Aspetto $SLEEP_TIME secondi"
sleep $SLEEP_TIME

echo "Notifico la disponibilita' di 10 CPU $VM"
date +%s
php up.php 10

echo "Aspetto $SLEEP_TIME secondi"
sleep $SLEEP_TIME
