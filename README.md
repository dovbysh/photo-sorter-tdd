# photo_sorter
## Installation
https://github.com/dovbysh/photo-sorter-tdd/releases/download/v0.1/photo_sorter_tdd.phar - compiled all-in-one

##From source:

Clone or download. Install phar-composer https://github.com/clue/phar-composer.
```
make
```

### Docker
```
docker run -it -v SOURCE_DIRECTORY:/psrc -v DESTINATION_DIR:/pdst --user $UID photo_sorter_tdd
```

### Ubuntu
```
sudo apt install mediainfo libimage-exiftool-perl php7.0-xml php7.0-cli php7.0-xsl php7.0-zip php7.0-tidy php7.0-simplexml php7.0-pgsql php7.0-posix php7.0-exif php7.0-exif php7.0-fileinfo php7.0-bz2 php7.0-bcmath php7.0-gd php7.0-mbstring
```
