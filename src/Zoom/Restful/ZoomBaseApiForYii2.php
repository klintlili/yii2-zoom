<?php
namespace Zoom\Restful;

use GuzzleHttp\Client;

/**
 * ZoomBaseApi for Yii2
 * @property object $_instance singleton
 * @property object $_guzzleClient cache the Guzzle client
 * @property string $url zoom basic access link
 * @property string $api_key Provided by zoom
 * @property string $api_secret Provided by zoom
 * @property string $date_type Zoom The format in which the data is returned: JSON/XML
 *
 * @author xiankun.geng <ge2x3k2@gmail.com>
 * @date 2017-06-24 04:11 PM
 * @version 1.0
 */
class ZoomBaseApiForYii2
{
    private static $_instance;
    private static $_guzzleClient;

    private static $url;
    private static $api_key;
    private static $api_secret;
    private static $data_type;

    /**
     * Prevents classes from being instantiated
     */
    private function __construct()
    {
        // Yii2 parmas-local
        self::$url = \Yii::$app->params['zoom']['api_url'];
        self::$api_key = \Yii::$app->params['zoom']['api_key'];
        self::$api_secret = \Yii::$app->params['zoom']['api_secret'];
        self::$data_type = \Yii::$app->params['zoom']['data_type'];
    }

    /**
     * Prevent the class from being cloned
     */
    private function __clone()
    {}

    /**
     * Get a single instance
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * cache the Guzzle client
     * @return Client
     */
    private static function getClient()
    {
        if (null == self::$_guzzleClient) {
            self::$_guzzleClient = new Client([
                // Base URI is used with relative requests
                'base_uri' => self::$url,
                'timeout'  => 2.0,
            ]);
        }
        return self::$_guzzleClient;
    }

    /**
     * Function to send HTTP POST Requests
     * Used by every function below to make HTTP POST call
     * @param  string $calledFunction uri
     * @param  array $data           post data
     * @return array                 zoom return
     */
    private function sendRequest($calledFunction, $data)
    {
        //Adds the Key, Secret, & Datatype to the passed array
        $data['api_key'] = self::$api_key;
        $data['api_secret'] = self::$api_secret;
        $data['data_type'] = self::$data_type;

        // Used Guzzle get the data in JSON format
        $client = self::getClient();
        $response = $client->request('POST', $calledFunction, [
            'form_params' => $data
        ]);
        $body = $response->getBody();
        $contents = $body->getContents();

        if(!$response){
            return false;
        }

        // Return array data
        return json_decode(contents);
    }

    /*Functions for management of users*/
    /**
     * 创建一个用户
     * @param $userEmail
     * @param $userType default 2 专业用户
     * @return json
     */
    public function createUser($userEmail, $userType = '2')
    {
        $createAUserArray = array();
        $createAUserArray['email'] = $userEmail;
        $createAUserArray['type'] = $userType;
        return $this->sendRequest('user/create', $createAUserArray);
    }

    /**
     * 免验证创建用户
     * @param $userEmail
     * @param $userType
     * @param $userPassword
     */
    public function autoCreateUser($userEmail, $userPassword, $userType = '2')
    {
        $autoCreateAUserArray = array();
        $autoCreateAUserArray['email'] = $userEmail;
        $autoCreateAUserArray['type'] = $userType;
        $autoCreateAUserArray['password'] = $userPassword;
        return $this->sendRequest('user/autocreate', $autoCreateAUserArray);
    }

    /**
     * @param $userEmail
     * @param $userType
     */
    public function custCreateUser($userEmail, $userType = '2', $password = null)
    {
        $custCreateAUserArray = array();
        $custCreateAUserArray['email'] = $userEmail;
        $custCreateAUserArray['type'] = $userType;
        $custCreateAUserArray['password'] = $password;
        return $this->sendRequest('user/custcreate', $custCreateAUserArray);
    }

    /**
     * 删除一个用户
     * @param $userId
     */
    public function deleteUser($userId)
    {
        $deleteUserArray = array();
        $deleteUserArray['id'] = $userId;
        return $this->sendRequest('user/delete', $deleteUserArray);
    }

    /**
     * 列出所有用户
     */
    public function listUsers()
    {
        $listUsersArray = array();
        return $this->sendRequest('user/list', $listUsersArray);
    }

    /**
     * 列出zoom上所有待定用户
     */
    public function listPendingUsers()
    {
        $listPendingUsersArray = array();
        return $this->sendRequest('user/pending', $listPendingUsersArray);
    }

    /**
     * 根据用户id获取用户信息
     * @param $userId
     */
    public function getUserInfo($userId)
    {
        $getUserInfoArray = array();
        $getUserInfoArray['id'] = $userId;
        return $this->sendRequest('user/get',$getUserInfoArray);
    }

    /**
     * 根据用户email获取用户信息
     * @param $userEmail
     * @param $userLoginType 电子邮件的登录类型：SNS_FACEBOOK = 0;SNS_GOOGLE = 1;SNS_API = 00;SNS_ZOOM = 100;SNS_SSO =101;
     */
    public function getUserInfoByEmail($userEmail, $userLoginType = '100')
    {
        $getUserInfoByEmailArray = array();
        $getUserInfoByEmailArray['email'] = $userEmail;
        $getUserInfoByEmailArray['login_type'] = $userLoginType;
        return $this->sendRequest('user/getbyemail',$getUserInfoByEmailArray);
    }

    /**
     * 更新用户信息
     */
    public function updateUserInfo($userId)
    {
        $updateUserInfoArray = array();
        $updateUserInfoArray['id'] = $userId;
        return $this->sendRequest('user/update',$updateUserInfoArray);
    }

    /**
     * 通过用户id更改用户密码
     */
    public function updateUserPassword($userId, $userNewPassword)
    {
        $updateUserPasswordArray = array();
        $updateUserPasswordArray['id'] = $userId;
        $updateUserPasswordArray['password'] = $userNewPassword;
        return $this->sendRequest('user/updatepassword', $updateUserPasswordArray);
    }

    /**
     * 设置可为他安排的助理
     */
    public function setUserAssistant($userId, $userEmail, $assistantEmail)
    {
        $setUserAssistantArray = array();
        $setUserAssistantArray['id'] = $userId;
        $setUserAssistantArray['host_email'] = $userEmail;
        $setUserAssistantArray['assistant_email'] = $assistantEmail;
        return $this->sendRequest('user/assistant/set', $setUserAssistantArray);
    }

    /**
     * 删除助理
     */
    public function deleteUserAssistant($userId, $userEmail, $assistantEmail)
    {
        $deleteUserAssistantArray = array();
        $deleteUserAssistantArray['id'] = $userId;
        $deleteUserAssistantArray['host_email'] = $userEmail;
        $deleteUserAssistantArray['assistant_email'] = $assistantEmail;
        return $this->sendRequest('user/assistant/delete',$deleteUserAssistantArray);
    }

    /**
     * 删除用户sso令牌
     */
    public function revokeSSOToken($userId, $userEmail)
    {
        $revokeSSOTokenArray = array();
        $revokeSSOTokenArray['id'] = $userId;
        $revokeSSOTokenArray['email'] = $userEmail;
        return $this->sendRequest('user/revoketoken', $revokeSSOTokenArray);
    }

    /**
     * 永久从zoom系统删除用户
     */
    public function deleteUserPermanently($userId, $userEmail)
    {
        $deleteUserPermanentlyArray = array();
        $deleteUserPermanentlyArray['id'] = $userId;
        $deleteUserPermanentlyArray['email'] = $userEmail;
        return $this->sendRequest('user/permanentdelete', $deleteUserPermanentlyArray);
    }

    /*Functions for management of meetings*/
    /**
     * 创建一个会议
     * @param $userId 	必填
     * @param $meetingTopic 会议主题。最多300个字符 	必填
     * @param $meetingType 会议类型  必填
     * @param $start_time 开始时间如2012-11-23T12：00：00Z
     * @param $duration 会议时长
     * @param $timezone 时区
     * @param $password 会议密码
     * @param $option_jph 是否在会议开始之前允许进入
     */
    public function createMeeting($userId, $meetingTopic, $meetingType = '2', $start_time = null, $duration = null, $timezone = null, $password = null, $option_jbh = false)
    {
        $createAMeetingArray = array();
        $createAMeetingArray['host_id'] = $userId;
        $createAMeetingArray['topic'] = $meetingTopic;
        $createAMeetingArray['type'] = $meetingType;
        $createAMeetingArray['start_time'] = $start_time;
        $createAMeetingArray['duration'] = $duration;
        $createAMeetingArray['timezone'] = $timezone;
        $createAMeetingArray['password'] = $password;
        $createAMeetingArray['option_jbh'] = $option_jbh;
        return $this->sendRequest('meeting/create', $createAMeetingArray);
    }

    /**
     * 删除一个会议
     */
    public function deleteMeeting($meetingId, $userId)
    {
        $deleteAMeetingArray = array();
        $deleteAMeetingArray['id'] = $meetingId;
        $deleteAMeetingArray['host_id'] = $userId;
        return $this->sendRequest('meeting/delete', $deleteAMeetingArray);
    }

    /**
     * 列出会议
     */
    public function listMeetings($userId)
    {
        $listMeetingsArray = array();
        $listMeetingsArray['host_id'] = $userId;
        return $this->sendRequest('meeting/list',$listMeetingsArray);
    }

    /**
     * 列出在线的会议
     */
    public function listLiveMeetings()
    {
        $listLiveMeetingArray = array();
        return $this->sendRequest('meeting/live',$listLiveMeetingArray);
    }

    /**
     * 获取会议详情
     */
    public function getMeetingInfo($meetingId, $userId)
    {
        $getMeetingInfoArray = array();
        $getMeetingInfoArray['id'] = $meetingId;
        $getMeetingInfoArray['host_id'] = $userId;
        return $this->sendRequest('meeting/get', $getMeetingInfoArray);
    }

    /**
     * 更新会议详情
     */
    public function updateMeetingInfo($meetingId, $userId)
    {
        $updateMeetingInfoArray = array();
        $updateMeetingInfoArray['id'] = $meetingId;
        $updateMeetingInfoArray['host_id'] = $userId;
        return $this->sendRequest('meeting/update', $updateMeetingInfoArray);
    }

    /**
     * 结束一个会议
     */
    public function endMeeting($meetingId, $userId)
    {
        $endAMeetingArray = array();
        $endAMeetingArray['id'] = $meetingId;
        $endAMeetingArray['host_id'] = $userId;
        return $this->sendRequest('meeting/end', $endAMeetingArray);
    }

    /*Functions for management of reports*/
    /**
     * 	获取一个月的每日报告，只能获取最近3个月的每日报告
     */
    public function getDailyReport($year, $month)
    {
        $getDailyReportArray = array();
        $getDailyReportArray['year'] = $year;
        $getDailyReportArray['month'] = $_POST['month'];
        return $this->sendRequest('report/getdailyreport', $getDailyReportArray);
    }

    /**
     * 	获取指定时间段的帐户报告
     */
    public function getAccountReport($from, $to)
    {
        $getAccountReportArray = array();
        $getAccountReportArray['from'] = $from;
        $getAccountReportArray['to'] = $to;
        return $this->sendRequest('report/getaccountreport', $getAccountReportArray);
    }

    /**
     * 获取指定时间段的用户报告
     */
    public function getUserReport($userId, $from, $to)
    {
        $getUserReportArray = array();
        $getUserReportArray['user_id'] = $userId;
        $getUserReportArray['from'] = $from;
        $getUserReportArray['to'] = $to;
        return $this->sendRequest('report/getuserreport', $getUserReportArray);
    }
}
/** End of file for ZoomBaseApi.php */
