<?php
namespace x1ankun\Zoom;

use GuzzleHttp\Client;
use yii\base\Component;
use yii\web\HttpException;
use yii\base\InvalidParamException;

/**
 * ZoomBaseApiForYii2
 * @author x1ankun <ge2x3k2@gmail.com>
 * @time 2017-07-20
 * @version 2.0
 */
class ZoomApi extends Component
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

    /** @var string ZOOM API KEY */
    public $api_key;

    /** @var string ZOOM API SECRET */
    public $api_secret;

    /** @var string ZOOM DATE FORMAT */
    public $data_type;

    /** @var object Guzzle客户端 */
    private static $_guzzle_client;

    public function init()
    {
        if ($this->api_key == null) {
            throw new InvalidParamException("api_key does not exist.");
        }

        if ($this->api_secret == null) {
            throw new InvalidParamException("api_secret does not exist.");
        }

        if ($this->data_type == null) {
            throw new InvalidParamException("data_type does not exist.");
        }
    }

    /**
     * cache the Guzzle client
     * @return Client
     */
    private static function getClient()
    {
        if (null == self::$_guzzle_client) {
            self::$_guzzle_client = new Client([
                // Base URI is used with relative requests
                'base_uri' => self::ZOOM_BASE_URL,
                'timeout'  => 2.0,
            ]);
        }
        return self::$_guzzle_client;
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
        $data['api_key'] = $this->api_key;
        $data['api_secret'] = $this->api_secret;
        $data['data_type'] = $this->data_type;

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
        return json_decode($contents);
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
        return $this->sendRequest(self::ZOOM_CREATE_USER_URI, $createAUserArray);
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
        return $this->sendRequest(self::ZOOM_AUTO_CREATE_USER_URI, $autoCreateAUserArray);
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
        return $this->sendRequest(self::ZOOM_CUST_CREATE_USER_URI, $custCreateAUserArray);
    }

    /**
     * 删除一个用户
     * @param $userId
     */
    public function deleteUser($userId)
    {
        $deleteUserArray = array();
        $deleteUserArray['id'] = $userId;
        return $this->sendRequest(self::ZOOM_DELETE_USER_URI, $deleteUserArray);
    }

    /**
     * 列出所有用户
     */
    public function listUsers()
    {
        $listUsersArray = array();
        return $this->sendRequest(self::ZOOM_LIST_USER_URI, $listUsersArray);
    }

    /**
     * 列出zoom上所有待定用户
     */
    public function listPendingUsers()
    {
        $listPendingUsersArray = array();
        return $this->sendRequest(self::ZOOM_PENDING_USER_URI, $listPendingUsersArray);
    }

    /**
     * 根据用户id获取用户信息
     * @param $userId
     */
    public function getUserInfo($userId)
    {
        $getUserInfoArray = array();
        $getUserInfoArray['id'] = $userId;
        return $this->sendRequest(self::ZOOM_GET_USER_URI,$getUserInfoArray);
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
        return $this->sendRequest(self::ZOOM_GETBYEMAIL_USER_URI, $getUserInfoByEmailArray);
    }

    /**
     * 更新用户信息
     */
    public function updateUserInfo($userId)
    {
        $updateUserInfoArray = array();
        $updateUserInfoArray['id'] = $userId;
        return $this->sendRequest(self::ZOOM_UPDATE_USER_URI, $updateUserInfoArray);
    }

    /**
     * 通过用户id更改用户密码
     */
    public function updateUserPassword($userId, $userNewPassword)
    {
        $updateUserPasswordArray = array();
        $updateUserPasswordArray['id'] = $userId;
        $updateUserPasswordArray['password'] = $userNewPassword;
        return $this->sendRequest(self::ZOOM_UPDATEPASSWORD_USER_URI, $updateUserPasswordArray);
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
        return $this->sendRequest(self::ZOOM_SET_ASSISTANT_USER_URI, $setUserAssistantArray);
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
        return $this->sendRequest(self::ZOOM_DELETE_ASSISTANT_USER_URI, $deleteUserAssistantArray);
    }

    /**
     * 删除用户sso令牌
     */
    public function revokeSSOToken($userId, $userEmail)
    {
        $revokeSSOTokenArray = array();
        $revokeSSOTokenArray['id'] = $userId;
        $revokeSSOTokenArray['email'] = $userEmail;
        return $this->sendRequest(self::ZOOM_REVOKETOKEN_USER_URI, $revokeSSOTokenArray);
    }

    /**
     * 永久从zoom系统删除用户
     */
    public function deleteUserPermanently($userId, $userEmail)
    {
        $deleteUserPermanentlyArray = array();
        $deleteUserPermanentlyArray['id'] = $userId;
        $deleteUserPermanentlyArray['email'] = $userEmail;
        return $this->sendRequest(self::ZOOM_PERMANENTDELETE_USER, $deleteUserPermanentlyArray);
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
        return $this->sendRequest(self::ZOOM_CREATE_MEETING, $createAMeetingArray);
    }

    /**
     * 删除一个会议
     */
    public function deleteMeeting($meetingId, $userId)
    {
        $deleteAMeetingArray = array();
        $deleteAMeetingArray['id'] = $meetingId;
        $deleteAMeetingArray['host_id'] = $userId;
        return $this->sendRequest(self::ZOOM_DELETE_MEETING_URI, $deleteAMeetingArray);
    }

    /**
     * 列出会议
     */
    public function listMeetings($userId)
    {
        $listMeetingsArray = array();
        $listMeetingsArray['host_id'] = $userId;
        return $this->sendRequest(self::ZOOM_LIST_MEETING, $listMeetingsArray);
    }

    /**
     * 列出在线的会议
     */
    public function listLiveMeetings()
    {
        $listLiveMeetingArray = array();
        return $this->sendRequest(self::ZOOM_LIVE_MEETING_URI, $listLiveMeetingArray);
    }

    /**
     * 获取会议详情
     */
    public function getMeetingInfo($meetingId, $userId)
    {
        $getMeetingInfoArray = array();
        $getMeetingInfoArray['id'] = $meetingId;
        $getMeetingInfoArray['host_id'] = $userId;
        return $this->sendRequest(self::ZOOM_GET_MEETING_URI, $getMeetingInfoArray);
    }

    /**
     * 更新会议详情
     */
    public function updateMeetingInfo($meetingId, $userId)
    {
        $updateMeetingInfoArray = array();
        $updateMeetingInfoArray['id'] = $meetingId;
        $updateMeetingInfoArray['host_id'] = $userId;
        return $this->sendRequest(self::ZOOM_UPDATE_MEETING_URI, $updateMeetingInfoArray);
    }

    /**
     * 结束一个会议
     */
    public function endMeeting($meetingId, $userId)
    {
        $endAMeetingArray = array();
        $endAMeetingArray['id'] = $meetingId;
        $endAMeetingArray['host_id'] = $userId;
        return $this->sendRequest(self::ZOOM_END_MEETING_URI, $endAMeetingArray);
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
        return $this->sendRequest(self::ZOOM_GETDAILYREPORT_REPORT_URI, $getDailyReportArray);
    }

    /**
     * 	获取指定时间段的帐户报告
     */
    public function getAccountReport($from, $to)
    {
        $getAccountReportArray = array();
        $getAccountReportArray['from'] = $from;
        $getAccountReportArray['to'] = $to;
        return $this->sendRequest(self::ZOOM_GETACCOUNTREPORT_REPORT_URI, $getAccountReportArray);
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
        return $this->sendRequest(self::ZOOM_GETUSERREPORT_REPORT_URI, $getUserReportArray);
    }
}
/** End of file for ZoomApi.php */
