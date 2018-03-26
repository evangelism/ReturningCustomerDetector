# Returning Customer Detector

Example project working with Face API from MSFT Azure. Created on MSFT Hackfest in Prague, 2018.

## What does it do?

This project works with webcamera (real life application will be for CCTV). It sends picture to Azure every 3 seconds and detects if some VIP / returning customer appears in the store.
 
## What do I need for this to work?
 
You need you Subscription Key  for MSFT Azure. It can be created here: https://portal.azure.com

## Configuration

Simply copy config.php.sample to config.php and put here your key. Application should now work.

## 3rd party libraries

For client Face detection we use:

http://facedetection.jaysalvat.com/

For working with Webcam:

http://github.com/jhuckaby/webcamjs