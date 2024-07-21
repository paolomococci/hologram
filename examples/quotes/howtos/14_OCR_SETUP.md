# OCR (Optical Character Recognition) engine setup

First I installed the program that will take care of the optical recognition of the characters detectable in an image.

```bash
apt search tesseract-ocr
sudo -s
apt install tesseract-ocr tesseract-ocr-eng
apt install libtesseract-dev
tesseract --version
tesseract --list-langs
updatedb
exit
locate tesseract
cd /var/www/html/quotes
composer require thiagoalessio/tesseract_ocr
```
