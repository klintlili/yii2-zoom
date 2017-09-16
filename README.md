# yii2-zoom

## What is zoom?

> Zoom unifies cloud video conferencing, simple online meetings, group messaging, and a software-defined conference room solution into one easy-to-use platform. Our solution offers the best video, audio, and wireless screen-sharing experience across Windows, Mac, iOS, Android, Blackberry, Linux, Zoom Rooms, and H.323/SIP room systems. Founded in 2011, Zoom's mission is to develop a people-centric cloud service that transforms the real-time collaboration experience and improves the quality and effectiveness of communications forever. 

> Official website [https://zoom.us/](https://zoom.us/)

## Install
`composer require x1ankun/yii2-zoom 1.0.0 -vvv`

## Configuration
```
//zoom应用组件
'zoom' => [
    'class' => 'x1ankun\Zoom\ZoomApi',
    "api_key" => "",
    "api_secret" => "",
    "data_type" => "JSON"
]
```

## Usage example
```
//创建zoom用户
$zoom = Yii::$app->zoom;
$resource = $zoom->createUser('test1101@test.com');        
```
