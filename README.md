# Zoom-restful-api

## What is zoom?

> Zoom unifies cloud video conferencing, simple online meetings, group messaging, and a software-defined conference room solution into one easy-to-use platform. Our solution offers the best video, audio, and wireless screen-sharing experience across Windows, Mac, iOS, Android, Blackberry, Linux, Zoom Rooms, and H.323/SIP room systems. Founded in 2011, Zoom's mission is to develop a people-centric cloud service that transforms the real-time collaboration experience and improves the quality and effectiveness of communications forever. 

> Official website [https://zoom.us/](https://zoom.us/)

## Install
`composer require xiankun/zoom-restful-api "@dev" -vvv`

## Configuration
- yii2
```
"zoom" => [
	"api_key" => "",
	"api_secret" => "",
	"data_type" => "JSON",
	"api_url"=>"https://api.zoom.us/v1/"
]
```

## Usage example
- yii2
```
use Zoom\Restful\ZoomServiceHelpers;
// Automatically create users
ZoomServiceHelpers::autoCreateUser($userEmail, $userPassword);
```

## Scalable

> The factory model tool class can scale different frames of zoomapi, in fact, the most important need to change the call of different frame configuration files, follow-up will update more frames
