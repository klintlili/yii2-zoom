<?php

use PHPUnit\Framework\TestCase;
use yii\base\Component;
use x1ankun\Zoom\ZoomApi;
use GuzzleHttp\Client;

class ZoomApiTest extends TestCase
{
    /** @const string ZOOM基本URL */
    const ZOOM_BASE_URL = "https://api.zoom.us/v1/";

    /** @const string 创建一个用户的URI */
    const ZOOM_CREATE_USER_URI = "user/create";
    
    /** @const string 免验证创建用户的URI */
    const ZOOM_AUTO_CREATE_USER_URI = "user/autocreate";

    /** @const string */
    const ZOOM_CUST_CREATE_USER_URI = "user/custcreate";

    /** @const string 删除一个用户的URI */
    const ZOOM_DELETE_USER_URI = "user/delete";

    /** @const string 列出所有用户的URI */
    const ZOOM_LIST_USER_URI = "user/list";

    /** @const string 列出ZOOM上所有待定用户的URI */
    const ZOOM_PENDING_USER_URI = "user/pending";

    /** @const string 根据用户id获取用户信息的URI */
    const ZOOM_GET_USER_URI = "user/get";

    /** @const string 根据用户email获取用户信息的URI */
    const ZOOM_GETBYEMAIL_USER_URI = "user/getbyemail";

    /** @const string 更新用户信息的URI */
    const ZOOM_UPDATE_USER_URI = "user/update";

    /** @const string 通过用户id更改用户密码的URI */
    const ZOOM_UPDATEPASSWORD_USER_URI = "user/updatepassword";

    /** @const string 设置可为他安排的助理的URI */
    const ZOOM_SET_ASSISTANT_USER_URI = "user/assistant/set";

    /** @const string 删除助理的URI */
    const ZOOM_DELETE_ASSISTANT_USER_URI = "user/assistant/delete";

    /** @const string 删除用户sso令牌的URI */
    const ZOOM_REVOKETOKEN_USER_URI = "user/revoketoken";

    /** @const string 永久从zoom系统删除用户的URI */
    const ZOOM_PERMANENTDELETE_USER = "user/permanentdelete";

    /** @const string 创建一个会议的URI */
    const ZOOM_CREATE_MEETING = "meeting/create";

    /** @const string 删除一个会议的URI */
    const ZOOM_DELETE_MEETING_URI = "meeting/delete";

    /** @const string 列出会议的URI */
    const ZOOM_LIST_MEETING = "meeting/list";

    /** @const string 列出在线的会议的URI */
    const ZOOM_LIVE_MEETING_URI = "meeting/live";

    /** @const string 获取会议详情的URI */
    const ZOOM_GET_MEETING_URI = "meeting/get";

    /** @const string 更新会议详情的URI */
    const ZOOM_UPDATE_MEETING_URI = "meeting/update";

    /** @const string 结束一个会议的URI */
    const ZOOM_END_MEETING_URI = "meeting/end";

    /** @const string 获取一个月的每日报告，只能获取最近3个月的每日报告的URI */
    const ZOOM_GETDAILYREPORT_REPORT_URI = "report/getdailyreport";

    /** @const string 获取指定时间段的帐户报告的URI */
    const ZOOM_GETACCOUNTREPORT_REPORT_URI = "report/getaccountreport";

    /** @const string 获取指定时间段的用户报告的URI */
    const ZOOM_GETUSERREPORT_REPORT_URI = "report/getuserreport";

    public function setUp()
    {
        $this->zoom = Yii::$app->zoom;
    }

    /**
     * 测试类之间的继承关系
     */
    public function testSmserInstanceOfClass()
    {
        $this->assertInstanceOf(ZoomApi::class, $this->zoom);
        $this->assertInstanceOf(Component::class, $this->zoom);
    }

	/**
     * 测试类中必要成员参数是否存在
     */
    public function testClassHasAttribute()
    {
        $this->assertClassHasAttribute('api_key', ZoomApi::class);
        $this->assertClassHasAttribute('api_secret', ZoomApi::class);
        $this->assertClassHasAttribute('data_type', ZoomApi::class);
    	$this->assertClassHasAttribute('_guzzle_client', ZoomApi::class);
    }

    /**
     * 测试对象中必要成员属性是否存在
     */
    public function testObjectHasAttribute()
    {
        $this->assertObjectHasAttribute('api_key', $this->zoom);
        $this->assertObjectHasAttribute('api_secret', $this->zoom);
        $this->assertObjectHasAttribute('data_type', $this->zoom);
        $this->assertObjectHasAttribute('_guzzle_client', $this->zoom);
    }

    /**
     * 测试对象中成员属性值是否正确
     */
    public function testObjectAttributeValueEquals()
    {
        $this->assertEquals(self::ZOOM_BASE_URL, ZoomApi::ZOOM_BASE_URL);
        $this->assertEquals(self::ZOOM_CREATE_USER_URI, ZoomApi::ZOOM_CREATE_USER_URI);
        $this->assertEquals(self::ZOOM_AUTO_CREATE_USER_URI, ZoomApi::ZOOM_AUTO_CREATE_USER_URI);
        $this->assertEquals(self::ZOOM_CUST_CREATE_USER_URI, ZoomApi::ZOOM_CUST_CREATE_USER_URI);
        $this->assertEquals(self::ZOOM_DELETE_USER_URI, ZoomApi::ZOOM_DELETE_USER_URI);
        $this->assertEquals(self::ZOOM_LIST_USER_URI, ZoomApi::ZOOM_LIST_USER_URI);
        $this->assertEquals(self::ZOOM_PENDING_USER_URI, ZoomApi::ZOOM_PENDING_USER_URI);
        $this->assertEquals(self::ZOOM_GET_USER_URI, ZoomApi::ZOOM_GET_USER_URI);
        $this->assertEquals(self::ZOOM_GETBYEMAIL_USER_URI, ZoomApi::ZOOM_GETBYEMAIL_USER_URI);
        $this->assertEquals(self::ZOOM_UPDATE_USER_URI, ZoomApi::ZOOM_UPDATE_USER_URI);
        $this->assertEquals(self::ZOOM_UPDATEPASSWORD_USER_URI, ZoomApi::ZOOM_UPDATEPASSWORD_USER_URI);
        $this->assertEquals(self::ZOOM_SET_ASSISTANT_USER_URI, ZoomApi::ZOOM_SET_ASSISTANT_USER_URI);
        $this->assertEquals(self::ZOOM_DELETE_ASSISTANT_USER_URI, ZoomApi::ZOOM_DELETE_ASSISTANT_USER_URI);
        $this->assertEquals(self::ZOOM_REVOKETOKEN_USER_URI, ZoomApi::ZOOM_REVOKETOKEN_USER_URI);
        $this->assertEquals(self::ZOOM_PERMANENTDELETE_USER, ZoomApi::ZOOM_PERMANENTDELETE_USER);
        $this->assertEquals(self::ZOOM_CREATE_MEETING, ZoomApi::ZOOM_CREATE_MEETING);
        $this->assertEquals(self::ZOOM_DELETE_MEETING_URI, ZoomApi::ZOOM_DELETE_MEETING_URI);
        $this->assertEquals(self::ZOOM_LIST_MEETING, ZoomApi::ZOOM_LIST_MEETING);
        $this->assertEquals(self::ZOOM_LIVE_MEETING_URI, ZoomApi::ZOOM_LIVE_MEETING_URI);
        $this->assertEquals(self::ZOOM_GET_MEETING_URI, ZoomApi::ZOOM_GET_MEETING_URI);
        $this->assertEquals(self::ZOOM_UPDATE_MEETING_URI, ZoomApi::ZOOM_UPDATE_MEETING_URI);
        $this->assertEquals(self::ZOOM_END_MEETING_URI, ZoomApi::ZOOM_END_MEETING_URI);
        $this->assertEquals(self::ZOOM_GETDAILYREPORT_REPORT_URI, ZoomApi::ZOOM_GETDAILYREPORT_REPORT_URI);
        $this->assertEquals(self::ZOOM_GETACCOUNTREPORT_REPORT_URI, ZoomApi::ZOOM_GETACCOUNTREPORT_REPORT_URI);
        $this->assertEquals(self::ZOOM_GETUSERREPORT_REPORT_URI, ZoomApi::ZOOM_GETUSERREPORT_REPORT_URI);
    }
    
    /**
     * 测试不填写api_key的异常是否符合预期
     * @expectedException \yii\base\InvalidParamException
     */
    public function testApiKeyException()
    {
        Yii::createObject([
            'class' => 'x1ankun\Zoom\ZoomApi',
            'api_key' => '',
            'api_secret' => '123123',
            'data_type' => 'json'
        ]);
    }

    /**
     * 测试不填写api_secret的异常是否符合预期
     * @expectedException \yii\base\InvalidParamException
     */
    public function testApiSecretException()
    {
        Yii::createObject([
            'class' => 'x1ankun\Zoom\ZoomApi',
            'api_key' => '123123',
            'api_secret' => '',
            'data_type' => 'json'
        ]);
    }

    /**
     * 测试不填写date_type的异常是否符合预期
     * @expectedException \yii\base\InvalidParamException
     */
    public function testDateTypeException()
    {
        Yii::createObject([
            'class' => 'x1ankun\Zoom\ZoomApi',
            'api_key' => '123123',
            'api_secret' => '123123',
            'data_type' => ''
        ]);
    }

    /**
     * 测试Guzzle客户端是否正确
     */
    public function testGetGuzzleClient()
    {
        $method = new ReflectionMethod('x1ankun\Zoom\ZoomApi', 'getClient');
        $method->setAccessible(true);
        $guzzleClient = $method->invoke(null);
        $this->assertInstanceOf(Client::class, $guzzleClient);
    }
}