# youtube-channel-downloder

## Features
+ Download all video for youtube channel
+ Support asynchronous download of video
+ Support downloading for audio only

## Requirement
* docker 18.09.2 or higher

## Getting Started
1. You must create youtube data v3 api key on [Google Developer Console](https://console.developers.google.com/)
2. Edit envfile
```bash
$ git clone git@github.com:Osushi/youtube-channel-downloder.git
$ cd youtube-channel-downloder
$ cp envfile.sample envfile
$ emacs envfile
===
YOUTUBE_DATA_API_KEY=
YOUTUBE_CHANNEL_ID=

# Ymd
CHECK_DATE_FROM=

ASYNC_DOWNLOAD_NUM=2

AUDIO_ONLY=false
===
```
### YOUTUBE_DATA_API_KEY
Set your api key

### YOUTUBE_CHANNEL_ID
Set youtube channel id

### CHECK_DATE_FROM
Your preferred download duration, the format is Ymd

### ASYNC_DOWNLOAD_NUM
Parallel number

### AUDIO_ONLY
If it is true, you will get audio file from video

## Run
```bash
$ make setup
$ docker-compose up run --rm run
-> See youtube-channel-downloder/data directories!
```
