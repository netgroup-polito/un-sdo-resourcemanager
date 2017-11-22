#!/bin/bash

SLEEP_TIME=240

VM=$( virsh list | grep trcd1 | awk '{print $2 }')

echo "VIRSH VM NAME: $VM"

echo "Aspetto $SLEEP_TIME secondi"
sleep $SLEEP_TIME

echo "Riduco a 2 CPU $VM "
date +%s

virsh setvcpus --live --guest $VM 2

echo "Aspetto $SLEEP_TIME secondi"
sleep $SLEEP_TIME

echo "Ripristino 4 CPU $VM"
date +%s
virsh setvcpus --live --guest $VM 4

echo "Aspetto $SLEEP_TIME secondi"
sleep $SLEEP_TIME
