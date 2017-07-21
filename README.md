# Zoom-yii2

## What is zoom?

> Zoom unifies cloud video conferencing, simple online meetings, group messaging, and a software-defined conference room solution into one easy-to-use platform. Our solution offers the best video, audio, and wireless screen-sharing experience across Windows, Mac, iOS, Android, Blackberry, Linux, Zoom Rooms, and H.323/SIP room systems. Founded in 2011, Zoom's mission is to develop a people-centric cloud service that transforms the real-time collaboration experience and improves the quality and effectiveness of communications forever. 

> Official website [https://zoom.us/](https://zoom.us/)

## Install
`composer require xiankun/zoom-yii2 "@dev" -vvv`

## Configuration
- yii2
```
//zoom应用组件
'zoom' => [
    'class' => 'xiankun\Zoom\ZoomApi',
    "api_key" => "",
    "api_secret" => "",
    "data_type" => "JSON"
]
```

## Usage example
- yii2
```
//创建zoom用户
$zoom = Yii::$app->zoom;
$resource = $zoom->createUser('test1101@test.com');        
```
