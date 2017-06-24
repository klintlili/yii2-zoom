<?php
namespace Zoom\Restful;

/**
 * @class ZoomServiceHelpers
 * @property object $service
 *
 * @author xiankun.geng <ge2x3k2@gmail.com>
 * @date 2017-06-24 04:47 PM
 * @version 1.0
 */
class ZoomServiceHelpers
{
	private static $service;

	/**
	 * @return ZoomService
	 */
	private static function getService()
	{
		if (null == self::$service) {
			self::$service = ZoomRestApi::getInstance();
		}
		return self::$service;
	}

	/*Functions for management of users*/
	/**
	 * 创建一个用户
	 * @param $userEmail
	 * @param $userType default 2 专业用户
	 * @return json
	 */
	public static function createUser($userEmail, $userType = '2')
	{
		$service = self::getService();
		return $service->createUser($userEmail, $userType);
	}

	/**
	 * 免验证创建用户
	 * @param $userEmail
	 * @param $userType
	 * @param $userPassword
	 */
	public static function autoCreateUser($userEmail, $userPassword, $userType = '2', $enable_auto_recording = 'true'){
	  	$service = self::getService();
		return $service->autoCreateUser($userEmail, $userPassword, $userType, $enable_auto_recording);
	}

	/**
	 * @param $userEmail
	 * @param $userType
	 */
	public static function custCreateUser($userEmail, $userType = '2', $password = null){
		$service = self::getService();
		return $service->custCreateUser($userEmail, $userType, $password);
	}

	/**
	 * 删除一个用户
	 * @param $userId
	 */
	public static function deleteUser($userId){
		$service = self::getService();
		return $service->deleteUser($userId);
	}

	/**
	 * 列出所有用户
	 */
	public static function listUsers(){
		$service = self::getService();
		return $service->listUsers();
	}

	/**
	 * 列出zoom上所有待定用户
	 */
	public static function listPendingUsers(){
		$service = self::getService();
		return $service->listPendingUsers();
	}    

	/**
	 * 根据用户id获取用户信息
	 * @param $userId
	 */
	public static function getUserInfo($userId){
		$service = self::getService();
		return $service->getUserInfo($userId);
	}   

	/**
	 * 根据用户email获取用户信息
	 * @param $userEmail
	 * @param $userLoginType 电子邮件的登录类型：SNS_FACEBOOK = 0;SNS_GOOGLE = 1;SNS_API = 00;SNS_ZOOM = 100;SNS_SSO =101;
	 */
	public static function getUserInfoByEmail($userEmail, $userLoginType = '100'){
		$service = self::getService();
		return $service->getUserInfoByEmail($userEmail, $userLoginType = '100');
	}  

	/**
	 * 更新用户信息
	 */
	public static function updateUserInfo($userId){
		$service = self::getService();
		return $service->updateUserInfo($userId);
	}  

	/**
	 * 通过用户id更改用户密码
	 */
	public static function updateUserPassword($userId, $userNewPassword){
		$service = self::getService();
		return $service->updateUserPassword($userId, $userNewPassword);
	}

	/**
	 * 设置可为他安排的助理
	 */
	public static function setUserAssistant($userId, $userEmail, $assistantEmail){
		$service = self::getService();
		return $service->setUserAssistant($userId, $userEmail, $assistantEmail);
	}     

	/**
	 * 删除助理
	 */
	public static function deleteUserAssistant($userId, $userEmail, $assistantEmail){
		$service = self::getService();
		return $service->deleteUserAssistant($userId, $userEmail, $assistantEmail);
	}   

	/**
	 * 删除用户sso令牌
	 */
	public static function revokeSSOToken($userId, $userEmail){
		$service = self::getService();
		return $service->revokeSSOToken($userId, $userEmail);
	}      

	/** 
	 * 永久从zoom系统删除用户
	 */
	public static function deleteUserPermanently($userId, $userEmail){
		$service = self::getService();
		return $service->deleteUserPermanently($userId, $userEmail);
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
	public static function createMeeting($userId, $meetingTopic, $meetingType = '2', $start_time = null, $duration = null, $timezone = null, $password = null, $option_jbh = false){
        $service = self::getService();
		return $service->createMeeting($userId, $meetingTopic, $meetingType, $start_time, $duration, $timezone, $password, $option_jbh);
	}

	/**
	 * 删除一个会议
	 */
	public static function deleteMeeting($meetingId, $userId){
	 	$service = self::getService();
		return $service->deleteMeeting($meetingId, $userId);
	}

	/**
	 * 列出会议
	 */
	public static function listMeetings($userId){
	  	$service = self::getService();
		return $service->listMeetings($userId);
	}

	/**
	 * 列出在线会议
	 */
	public static function listLiveMeetings(){
		$service = self::getService();
		return $service->listLiveMeetings();
	}

	/**
	 * 获取会议详情
	 */
	public static function getMeetingInfo($meetingId, $userId){
      	$service = self::getService();
		return $service->getMeetingInfo($meetingId, $userId);
	}

	/**
	 * 更新会议详情
	 */
	public static function updateMeetingInfo($meetingId, $userId){
	  	$service = self::getService();
		return $service->updateMeetingInfo($meetingId, $userId);
	}

	/**
	 * 结束一个会议
	 */
	public static function endMeeting($meetingId, $userId){
      	$service = self::getService();
		return $service->endMeeting($meetingId, $userId);
	}

	/*Functions for management of reports*/
	/**
	 * 	获取一个月的每日报告，只能获取最近3个月的每日报告
	 */
	public static function getDailyReport($year, $month){
	  	$service = self::getService();
		return $service->getDailyReport($year, $month);
	}

	/**
	 * 	获取指定时间段的帐户报告
	 */
	public static function getAccountReport($from, $to){
	  	$service = self::getService();
		return $service->getAccountReport($from, $to);
	}

	/**
	 * 获取指定时间段的用户报告
	 */
	public static function getUserReport($userId, $from, $to){
	  	$service = self::getService();
		return $service->getUserReport($userId, $from, $to);
	}
}
/** end of file */