<?php
namespace enoola_Citrix_Client;

require_once('./class/Xenmobile_RESTWS_Exception.php');
require_once('./class/Xenmobile_RESTWS_Authentication.php');

error_reporting(E_ALL);

/**
 * Use as an object to leverage webservices inherant to Device in Xenmobile
 * can be use alone
 *
 * @method mixed AuthorizeAListOfDevices(array $arSequentialID)
 * @method mixed ApplyActivationLockBypassOnAListOfDevices(array $arSequentialID)
 * @method mixed ApplyAppLockOnAListOfDevices(array $arSequentialID)
 * @method mixed ApplyAppWipeOnAListOfDevices(array $arSequentialID)
 * @method mixed ApplyContainerLockOnAListOfDevices(array $arSequentialID)
 * @method mixed CancelContainerLockOnAListOfDevices(array $arSequentialID)
 * @method mixed ApplyContainerUnlockOnAListOfDevices(array $arSequentialID)
 * @method mixed CancelContainerUnlockOnAListOfDevices(array $arSequentialID)
 * @method mixed ResetContainerPasswordOnAListOfDevices(array $arSequentialID)
 * @method mixed CancelResetContainerPasswordOnAListOfDevices(array $arSequentialID)
 * @method mixed DisownAListOfDevices(array $arSequentialID)
 * @method mixed LocateAListOfDevices(array $arSequentialID)
 * @method mixed CancelLocateAListOfDevices(array $arSequentialID)
 * @method mixed ApplyGPSTrackingOnAListOfDevices(array $arSequentialID)
 * @method mixed CancelGPSTrackingOnAListOfDevices(array $arSequentialID)
 * @method mixed LockAListOfDevices(array $arSequentialID)
 * @method mixed CancelLockAListOfDevices(array $arSequentialID)
 * @method mixed LockAListOfDevices(array $arSequentialID)
 * @method mixed DeployAListOfDevices(array $arSequentialID)
 * @method mixed RequestForAirPlayMirroringOnAListOfDevices(array $arSequentialID)
 * @method mixed CancelRequestForAirPlayMirroringOnAListOfDevices(array $arSequentialID)
 * @method mixed StopAirPlayMirroringOnAListOfDevices(array $arSequentialID)
 * @method mixed CancelStopAirPlayMirroringOnAListOfDevices(array $arSequentialID)
 * @method mixed ClearAllRestrictionsOnAListOfDevices(array $arSequentialID)
 * @method mixed CancelClearAllRestrictionsOnAListOfDevices(array $arSequentialID)
 * @method mixed RevokeAListOfDevices(array $arSequentialID)
 * @method mixed RingAListOfDevices(array $arSequentialID)
 * @method mixed CancelRingAListOfDevices(array $arSequentialID)
 * @method mixed WipeAListOfDevices(array $arSequentialID)
 * @method mixed CancelWipeAListOfDevices(array $arSequentialID)
 * @method mixed SelectivelyWipeAListOfDevices(array $arSequentialID)
 * @method mixed CancelSelectivelyWipeAListOfDevices(array $arSequentialID)
 * @method mixed WipeTheSDCardsOnAListOfDevices(array $arSequentialID)
 * @method mixed CancelWipeTheSDCardsOnAListOfDevices(array $arSequentialID)
 *
 */
class Xenmobile_RESTWS_Device extends Xenmobile_RESTWS_Authentication
{
  const SZ_WS_CLASSNAME = 'device';

  private $_arImplementedMethod = array();
  protected $_arMethodMatrix = array(
    array('AuthorizeAListOfDevices','authorize') );

  /**
   * Constructor to define fqdn ports ...
   *
   * @param string $szFQDN FQDN of the server (xenmobile.contoso.com)
   * @param int $nPort Port to access the server Xenmobile_RESTWS_Abstract::PORT_DEFAULT_HTTPS (4443)
   * @param string $szProtocol https or https Xenmobile_RESTWS_Abstract::PROTOCOL_HTTPS (https)
   * @param boolean $bVerifySSL shall we verify https certificate (false)
   *
   * @return void
   */
  public function __construct($szFQDN, $nPort = parent::PORT_DEFAULT_HTTPS, $szProtocol = parent::PROTOCOL_HTTPS, $bVerifySSL = false)
  {
    $this->log('in', __METHOD__);
    $this->log(self::SZ_WS_CLASSNAME, __METHOD__);
    parent::__construct( $szFQDN, $nPort = parent::PORT_DEFAULT_HTTPS, $szProtocol = parent::PROTOCOL_HTTPS, $bVerifySSL = false);
    parent::_setClassname( self::SZ_WS_CLASSNAME );

    $this->_addVirtualMethod( 'AuthorizeAListOfDevices', 'authorize' );
    $this->_addVirtualMethod( 'ApplyActivationLockBypassOnAListOfDevices', 'activationLockBypass' );
    $this->_addVirtualMethod( 'ApplyAppLockOnAListOfDevices', 'appLock' );
    $this->_addVirtualMethod( 'ApplyAppWipeOnAListOfDevices', 'appWipe' );
    $this->_addVirtualMethod( 'ApplyContainerLockOnAListOfDevices', 'containerLock' );
    $this->_addVirtualMethod( 'CancelContainerLockOnAListOfDevices', 'containerLock', 'cancel' );
    $this->_addVirtualMethod( 'ApplyContainerUnlockOnAListOfDevices', 'containerUnlock' );
    $this->_addVirtualMethod( 'CancelContainerUnlockOnAListOfDevices', 'containerUnlock', 'cancel' );
    $this->_addVirtualMethod( 'ResetContainerPasswordOnAListOfDevices', 'containerPwdReset' );
    $this->_addVirtualMethod( 'CancelResetContainerPasswordOnAListOfDevices', 'containerPwdReset', 'cancel' );
    $this->_addVirtualMethod( 'DisownAListOfDevices', 'disown', 'cancel' );
    $this->_addVirtualMethod( 'LocateAListOfDevices', 'locate' );
    $this->_addVirtualMethod( 'CancelLocateAListOfDevices', 'locate', 'cancel' );
    $this->_addVirtualMethod( 'ApplyGPSTrackingOnAListOfDevices', 'track' );
    $this->_addVirtualMethod( 'CancelGPSTrackingOnAListOfDevices', 'track', 'cancel');
    /**
    * Lock a List of Devices
    *
    * @param array arSequentialID
    * @return mixed
    * @notes : from citrix doc we need those in the query
    *      dstName – destination name, as either destination name or destination device ID
    *      dstDevId – MAC address for destination device, as either destination name or destination device ID
    *      scanTime – number of seconds to scan
    *      screenSharingPwd – password for screen sharing
    * need to be tested
    */
    $this->_addVirtualMethod( 'LockAListOfDevices', 'lock' );
    $this->_addVirtualMethod( 'CancelLockAListOfDevices', 'lock', 'cancel' );
    $this->_addVirtualMethod( 'LockAListOfDevices', 'unlock' );
    $this->_addVirtualMethod( 'DeployAListOfDevices', 'refresh' );
    $this->_addVirtualMethod( 'RequestForAirPlayMirroringOnAListOfDevices', 'requestMirroring' );
    $this->_addVirtualMethod( 'CancelRequestForAirPlayMirroringOnAListOfDevices', 'requestMirroring', 'cancel' );
    $this->_addVirtualMethod( 'StopAirPlayMirroringOnAListOfDevices', 'stopMirroring' );
    $this->_addVirtualMethod( 'CancelStopAirPlayMirroringOnAListOfDevices', 'stopMirroring', 'cancel' );
    $this->_addVirtualMethod( 'ClearAllRestrictionsOnAListOfDevices', 'restrictions', 'clear' );
    $this->_addVirtualMethod( 'CancelClearAllRestrictionsOnAListOfDevices', 'restrictions', 'clear/cancel' );
    $this->_addVirtualMethod( 'RevokeAListOfDevices', 'revoke' );
    $this->_addVirtualMethod( 'RingAListOfDevices', 'ring' );
    $this->_addVirtualMethod( 'CancelRingAListOfDevices', 'ring', 'cancel' );
    $this->_addVirtualMethod( 'WipeAListOfDevices', 'wipe' );
    $this->_addVirtualMethod( 'CancelWipeAListOfDevices', 'wipe', 'cancel' );
    $this->_addVirtualMethod( 'SelectivelyWipeAListOfDevices', 'selwipe' );
    $this->_addVirtualMethod( 'CancelSelectivelyWipeAListOfDevices', 'selwipe', 'cancel' );
    $this->_addVirtualMethod( 'WipeTheSDCardsOnAListOfDevices', 'sdcardwipe' );
    $this->_addVirtualMethod( 'CancelWipeTheSDCardsOnAListOfDevices', 'sdcardwipe', 'cancel' );

  }

  public function __destruct()
  {
    $this->log('in', __METHOD__);
    parent::__destruct();
  }


  /**
   * Get device By Filters
   *
   * @param array arQuery ['start'=>0-999, 'limit'=>0-999, "sortOrder":"ASC,DESC,DSC","sortColumn":"ID,SERIAL,IMEI...","enableCount":"false]
   *
   * @return StdClass arQuery  {(int)status,(string)message,(objStdClass)currentFilter->(array)detail}
   *
   * @note : https://docs.citrix.com/en-us/xenmobile/10-3/xenmobile-rest-api-reference-main.html
   */
  public function GetDeviceByFilters( $arQuery )
  {
    $this->log('in', __METHOD__);

    $retValue = $this->_doRequest('filter', null, $arQuery, 'post');

    if ( $retValue == true )
    {
      if ( $this->getLastRequestResult() && is_object($this->getLastRequestResult()) )
        {
          if ( isset( $this->getLastRequestResult()->status ) )
            {
              return ( $this->getLastRequestResult() );
            }
        }
    }
    elseif ($this->getLastHttpReturn()['http_code'] == 403)
    {
      throw new Xenmobile_RESTWS_Exception( $this->getLastRequestResult() );
    }
    if ($this->getLastRequestResult()->status != 0)
    {
        $this->log( $this->getLastRequestResult(), __METHOD__ );
    }

    throw new Xenmobile_RESTWS_Exception( $this->getLastRequestResult()->message, $this->getLastRequestResult()->status );
  }

  /**
   * Get Device by Filters made easy
   *
   * @param string szSearch
   * @param int nLimit
   * @param array arFilterIds
   *
   * @return StdClass arQuery {(int)status,(string)message,(objStdClass)currentFilter->(array)detail}
   */
  public function GetDeviceByFilters_EasySearch( $szSearch, $arFilterIds = null, $nLimit = 9 )
  {
    if (!is_null($arFilterIds) && !is_array($arFilterIds))
      throw new Xenmobile_RESTWS_Exception( 'Second argument arFilterIds shall be an sequential array',__METHOD__ );
    if ( !is_numeric($nLimit) )
      throw new Xenmobile_RESTWS_Exception( 'Third argument nLimit shall be a number',__METHOD__ );
    $arQuery = array('start' => 0, 'limit' => $nLimit, 'sortOrder' => 'ASC','sortColumn'=>'ID','enableCount'=>'false','search'=>$szSearch);
    if (!is_null($arFilterIds) )
      $arQuery['filterIds'] = $arFilterIds;

    return ( self::GetDeviceByFilters($arQuery) );
  }

  /**
   * Get available filterIds,
   *
   * @return array ar[nodename][]->(string)displayName
   *                              ->(array)arFilters[]->(string)displayName
   *                                                  ->(string)name
   */
  public function GetAvailableFilterIds()
  {
    //we send a "fake query" to ONLY get the content of : currentFiler
    $arCurrentFilters = array();
    $arQuery = array('start' => 0, 'limit' => 0, 'sortOrder' => 'ASC','sortColumn'=>'ID','enableCount'=>'false',
                    'search'=>'__NOT_TO_BE_FOUND__');

    $oReturn = self::GetDeviceByFilters( $arQuery );
    if ( isset ($oReturn->currentFilter) )
    {
      foreach ($oReturn->currentFilter->detail as $oneDetail)
      {
        $arCurrentFilters[ $oneDetail->name ] = new \StdClass;
        $arCurrentFilters[ $oneDetail->name ]->displayName = $oneDetail->displayName;
        $arCurrentFilters[ $oneDetail->name ]->arFilters = array();

        $idx = 0;
        foreach ($oneDetail->nodes as $key => $oneEntry)
        {
          $arCurrentFilters[ $oneDetail->name ]->arFilters[$idx] = new \StdClass;
          $arCurrentFilters[ $oneDetail->name ]->arFilters[$idx]->displayName = $oneEntry->displayName;
          $arCurrentFilters[ $oneDetail->name ]->arFilters[$idx]->name = $oneEntry->name;
          $idx++;
        }
      }
      return ( $arCurrentFilters );
    }
    return ( null );
  }

  /**
   * Get Device Information by ID,
   *
   * @params deviceID
   *
   * @return mixed see _handleResponse()
   */
  public function GetDeviceInformationByID( $nDeviceID )
  {
    $this->log(__METHOD__);

    $retValue = $this->_doRequest($nDeviceID, null, null, 'get');

    return ( $this->_handleResponse() );
  }

  /**
   * Display available filters,
   * show what value are authrorized in search field 'filterIds' ;)
   *
   * @return void
  */
  public function DisplayAvailableFilterIds()
  {

    $arCurrentFilters = self::GetAvailableFilterIds();

    if (!is_null($arCurrentFilters))
    {
      foreach ( $arCurrentFilters as $oneDetailName => $oneArDetail )
      {
        echo 'Node Name : '. $oneArDetail->displayName . PHP_EOL;
        echo 'Available Filter in this Node : '. PHP_EOL;

        foreach ($oneArDetail->arFilters as $key => $oneEntry)
        {
          echo ' '.$oneEntry->displayName . ':' . $oneEntry->name. PHP_EOL;
        }
      }
    }
    return (null) ;
  }

  /**
   * Get device apps by device ID,
   *
   * @param int[0-999] nDevice
   *
   * @return mixed application[]->(string)name, status,...
   */
   public function GetAppsByDeviceID( $nDeviceID )
   {
     return ( $this->_getInformationByDeviceID('apps', $nDeviceID) );
   }

   /**
    * Get device actions by device ID,
    *
    * @param int[0-999] nDevice
    *
    * @return StdClass actions[]->(string)ressourceType, ressourceTypeLabel,...
    */
    public function GetActionsByDeviceID( $nDeviceID )
    {
      return ( $this->_getInformationByDeviceID('actions', $nDeviceID) );
    }

    /**
     * Get device delivery groups by device ID,
     *
     * @param int[0-999] nDevice
     *
     * @return StdClass deliveryGroups[]->(string)statuslabel, linkey, status,...
     */
     public function GetDeliveryGroupsByDeviceID( $nDeviceID )
     {
       return ( $this->_getInformationByDeviceID('deliverygroups', $nDeviceID) );
     }


    /**
     * Get device Managed Software Inventory by device ID,
     *
     * @param int[0-999] nDevice
     *
     * @return StdClass softwareInventory[]->(string)version, blacklistCompliant, suggestedListCompliant,...
     */
     public function GetManagedSoftwareInventoryByDeviceID( $nDeviceID )
     {
       return ( $this->_getInformationByDeviceID('managedswinventory', $nDeviceID) );
     }


    /**
     * Get device Policies by Device ID,
     *
     * @param int[0-999] nDevice
     *
     * @return StdClass policies[]->(string)version, ressourceType, ressourceTypeLabel,...
     */
     public function GetPoliciesByDeviceID( $nDeviceID )
     {
       return ( $this->_getInformationByDeviceID('policies', $nDeviceID) );
     }


     /**
      * Get device Software Inventory by device ID,
      *
      * @param int[0-999] nDevice
      *
      * @return StdClass softwareInventory[]->(string)version, blacklistCompliant, suggestedListCompliant,...
      */
      public function GetSoftwareInventoryByDeviceID( $nDeviceID )
      {
        return ( $this->_getInformationByDeviceID('softwareinventory', $nDeviceID) );
      }

    /**
     * Get device Software Inventory by device ID,
     *
     * @param int[0-999] nDevice
     *
     * @return StdClass softwareInventory[]->(string)version, blacklistCompliant, suggestedListCompliant,...
     */
     public function GetGPSCoordinateByDeviceID( $nDeviceID )
     {
       return ( $this->_getInformationByDeviceID($nDeviceID, 'locations') );
     }


   /**
    * internal get information by device id,
    * made to ease implementation of different methods Get***ByDeviceID()
    *
    * @param string szMethod
    * @param string szPath
    * @return (StdClass|null)
    *
    */
   private function _getInformationByDeviceID( $szPath, $szMethod )
   {
     $this->log(__METHOD__);

     if ( is_string( $szMethod ) )
      {
        if (!is_numeric($szPath))
           throw new Xenmobile_RESTWS_Exception( 'argument $szPath must be numeri if $szMethod is not string. value given :'.$szPath  );
      }
      if ( is_numeric( $szMethod ) )
       {
         if (!is_string($szPath))
           throw new Xenmobile_RESTWS_Exception( 'argument $szPath must be string if $szMethod is numeric. value given :'.$szPath  );
       }

     $retValue = $this->_doRequest($szMethod, $szPath, null, 'get');

     return ($this->_handleResponse());
   }

  /**
  * Send a notification to a list of devices or users
  *
  * @param array $arQuery an array containing a representation of the query body
  *
  * @example
  *{
  *  "smtpFrom": "Test",
  *  "to": [
  *    {
  *      "deviceId": "1",
  *      "email": "user@test.com",
  *      "osFamily": "iOS",
  *      "serialNumber": "F7NLX6WDF196",
  *      "smsTo": "+123456676",
  *      "token": {
  *        "type": "apns",
  *        "value": "dfb2fb351a4fb068e40858ecad572e317e6c39b4fa7de6fb29ea1ad7e2254499"
  *      }
  *    }
  *  ],
  *  "smtpSubject": "This is test subject",
  *  "smtpMessage": "This is test message",
  *  "smsMessage": "This is test message",
  *  "agentMessage": "This is test message",
  *  "sendAsBCC": "true",
  *  "smtp": "true",
  *  "sms": "true",
  *  "agent": "true",
  *  "templateId": "-1",
  *  "agentCustomProps": {
  *    "sound": "Casino.wav"
  *  }
  */
  public function SendNotificationToAListOfDevicesOrUsers( $arQuery )
  {
    $this->log(__METHOD__);


    $retValue = $this->_doRequest('notify', null, $arQuery, 'post');

    return ($this->_handleResponse());
  }



  /**
  * Send a Mail notification to a list of users mail
  * Extra function
  *
  * @param string szFrom : From content
  * @param array arMailRecipient
  * @param string szSubject
  * @param string szBody
  * @param bool bSendAsBCC : send the email as bcc to expeditor
  *
  */
  public function SendMailToAListOfUserMail( $szFrom, $arMailRecipient, $szSubject, $szBody, $bSendAsBCC )
  {
    $this->log(__METHOD__);
    if ( !is_array( $arMailRecipient ) )
           throw new Xenmobile_RESTWS_Exception( 'Bad argument' );

    $arMailTo = array();
    foreach ($arMailRecipient as $oneMail)
    {
      $arMailTo[] = array('email' => $oneMail);
    }
    $arQueryNotification = array ( 'smtpFrom' => $szFrom,
      'to'          =>  $arMailTo ,
      'smtpSubject' => $szSubject,
      'smtpMessage' => $szBody,
      'sendAsBCC'   => $bSendAsBCC,
      'smtp'        => 'true',
      'sms'         => 'false',
      'agent'       => 'false',
      'templateId'  => -1);

    $retValue = $this->_doRequest( 'notify', null, $arQueryNotification, 'POST');

    return ($this->_handleResponse());
  }

  /**
  * Send a SMS notification ausers (Simplified method)
  * Query are weird if I only put a device ID it won't send it
  * I need to put the number too
  * Extra function
  *
  * @param array $arNumbersToSMS sequential array containing IDs
  * @param string $szMessage unique message to send to all numbers
  *
  * @return mixed _handleResponse()
  */
  public function SendSMSToAListOfPhoneNumbers( $arNumbersToSMS, $szMessage )
  {
    $this->log(__METHOD__);
    if ( !is_array( $arNumbersToSMS ) )
           throw new Xenmobile_RESTWS_Exception( 'Bad argument' );

    $arSMSTo = array();
    foreach ($arNumbersToSMS as $oneNumber)
    {
      $arSMSTo[] = array('smsTo' => $oneNumber);
    }
    $arQueryNotification = array (
      'to'          =>  $arSMSTo ,
      'smsMessage'  => $szMessage,
      'smtp'        => 'false',
      'sms'         => 'true',
      'agent'       => 'false',
      'templateId'  => -1);

    $retValue = $this->_doRequest( 'notify', null, $arQueryNotification, 'POST');

    return ($this->_handleResponse());
  }


  /**
  * Sends a Push notification to a list of device
  * I don't know how to implement it YET
  *
  * @param integer $nDeviceID id of the device to send the push notification to
  * @param string $szDeviceToken token of the device to send to
  * @param string $szMessage message to send
  * @param string $szDeviceType type (Could be Android, iOS, MaxOSX ....)
  *
  * @return mixed see _handleResponse()
  */
  public function SendPushNotificationToAListOfDevice( $nDeviceID, $szDeviceToken, $szMessage, $szDeviceType = 'Android' )
  {
    $this->log(__METHOD__);

    $arShtp = array ('value' => $szDeviceToken);
    $arShtp['type'] = 'apns';
    if (strcmp('Android', $szDeviceType ) == 0)
      $arShtp['type'] = 'shtp';

    $arQueryNotification = array (
      'to'          => array ( array(
                              'deviceId' => $nDeviceID ,
                              //'osFamily'      => $szDeviceType, //==> GET BUGGY When using this (for mail and SMS and Notification)
                              'token' => $arShtp
                        ) ),
      'smtp'        => 'false',
      'sms'         => 'false',
      'agent'       => 'true',
      'templateId'  => -1);

    $retValue = $this->_doRequest( 'notify', null, $arQueryNotification, 'POST');

    return ($this->_handleResponse());
  }

  /**
   * Get all know properties of a device
   *
   * @param integer $nID device id we want properties from
   *
   * @return mixed see _handleResponse()
   */
  public function GetAllKnownPropertiesOnADevice( $nID )
  {
    $this->log(__METHOD__);

    $this->_doRequest('knownProperties', null, $nID, 'GET');

    return ( $this->_handleResponse() );
  }

  /**
   * Get all used properties of a device
   *
   * @param integer $nID device id we want properties from
   *
   * @return mixed see _handleResponse()
   */

  public function GetAllUsedPropertiesOnADevice( $nID )
  {
    $this->log(__METHOD__);

    $this->_doRequest('usedProperties', null, $nID, 'GET');

    return ( $this->_handleResponse() );
  }



  /**
  * Get All Device Properties by Device ID
  *
  * @param string szFrom : From content
  *
  * @return mixed see self::_handleResponse
  */
  public function GetAllDevicePropertiesByDeviceID( $nDeviceID )
  {
    $this->log(__METHOD__);

    $this->_doRequest($nDeviceID, null, null, 'GET');

    return ( $this->_handleResponse() );
  }

  /**
  * Update All Device Properties by Device ID
  * /!\ Be carefull it updates ALL (so remind to get properties then modify
  *     then put them all back ...)
  *
  * @notes unable to make it work with XM 10.3x return 500 json
  * @param int nDeviceID
  * @param array arAllProperties key(name, value)
  *
  * @return mixed see self::_handleResponse
  */
  public function UpdateAllDevicePropertiesByDeviceID( $nDeviceID, $arAllProperties )
  {
    $this->log(__METHOD__);

    $this->_doRequest('properties', $nDeviceID, array('properties'=>$arAllProperties), 'PUT');

    return ( $this->_handleResponse() );
  }

  /**
  * Add or Update a Device Property by Device ID
  * /!\ Not Working
  *
  * @notes unable to make it work with XM 10.3x return 500 jsoncode : 1000
  * @param int nDeviceID
  * @param array arProperties name, value
  *
  * @return mixed see self::_handleResponse
  */
  public function AddOrUpdateADevicePropertyByDeviceID( $nDeviceID, $arOneProperty )
  {
    $this->log(__METHOD__);
    throw new Xenmobile_RESTWS_Exception('Not Working with XM10.3!');

    $this->_doRequest('properties', $nDeviceID, $arOneProperty, 'POST');

    return ( $this->_handleResponse() );
  }

  /**
  * Add or Update a Device Property by Device ID
  * Extra Method /!\ Not Working
  *
  * @notes unable to make it work with XM 10.3x return 500 jsoncode : 1000
  * @param int nDeviceID
  * @param array arProperties name, value
  *
  * @return mixed see self::_handleResponse
  */
  public function AddOrUpdateADevicePropertyByDeviceID_Easy( $nDeviceID, $szNameProp, $szNameValue )
  {
    $this->log(__METHOD__);
    throw new Xenmobile_RESTWS_Exception('Not Working with XM10.3!');

    $arQuery = array('name'=>$szNameProp, 'value'=>$szNameValue );

    $this->AddOrUpdateADevicePropertyByDeviceID($nDeviceID, $arQuery);


    return ( $this->_handleResponse() );
  }


  /**
  * Delete a Device Property by Device ID
  * /!\ Not working
  *
  * @notes unable to make it work with XM 10.3x return 500 jsoncode : 1000
  *        even id, name, value.. (doesn't behave as expected)
  * @param int nDeviceID
  * @param array arProperties name, value
  *
  * @return mixed see self::_handleResponse
  */
  public function DeleteADevicePropertyByDeviceID( $nDeviceID, $arOneProperty )
  {
    $this->log(__METHOD__);

    throw new Xenmobile_RESTWS_Exception('Not Working with XM10.3!');
    $this->_doRequest('properties', $nDeviceID, $arOneProperty, 'DELETE');

    return ( $this->_handleResponse() );
  }

  /**
  * Get iOS Device MDM Status by Device ID
  *
  * @notes unable to make it work with XM 10.3x return 500 jsoncode : 1000
  *        even id, name, value.. (doesn't behave as expected)
  * @param int nDeviceID
  * @param array arProperties name, value
  *
  * @return mixed see self::_handleResponse
  */
  public function GetiOSDeviceMDMStatusbyDeviceID( $nDeviceID )
  {
    $this->log(__METHOD__);

    $this->_doRequest('mdmStatus', $nDeviceID, null, 'GET');

    return ( $this->_handleResponse() );
  }

  /**
  * Generate Pin Code
  *
  * @notes Query Parameters: pinCodeLength – the length of the requested pin code
  *        the pincode size doesn't work as expected (it always return pincode of 4 digit)
  * @param int nLength
  *
  * @return mixed see self::_handleResponse
  */
  public function GeneratePinCode( $nLength )
  {
    $this->log(__METHOD__);

    $this->_doRequest('pincode', 'generate', array( 'pinCodeLength' => $nLength ), 'GET');

    return ( $this->_handleResponse() );
  }

  /**
  * Get Device Last Location By Device ID only with XM 10.4 I assume
  *
  * @todo Query Parameters: pinCodeLength – the length of the requested pin code
  *        unable to make it work with XM 10.3x return 500 jsoncode : 1000
  * @param int nDeviceID
  * @param array arProperties name, value
  *
  * @return mixed see self::_handleResponse
  */
  public function GetDeviceLastLocationByDeviceID( $nDeviceID )
  {
    $this->log(__METHOD__);

    $this->_doRequest('lastLocation', $nDeviceID, null, 'GET');

    return ( $this->_handleResponse() );
  }




  protected function _addVirtualMethod( $szVirtualName, $szMethod, $szPath = null )
  {
    //$this->_arMethodMatrix = array($szVirtualName);
    $oEntry = new \StdClass;
    $oEntry->szMethod = $szMethod;
    $oEntry->szPath = $szPath;
    $this->_arMethodMatrix[ $szVirtualName ] = $oEntry;
  }


  /**
  * Throw an exception if parameter is not an array
  *
  * @param array arSequentialID
  * @return mixed
  */
  protected function _throwExceptionIfNotArray( $arSequentialID )
  {
    if (!is_array( $arSequentialID ) )
    {
      throw new Xenmobile_RESTWS_Exception('Invalid argument expected array.');
    }
  }


    /**
    * handle response of Xenmobile
    *
    * @return mixed : return _oRequestLastReturn
    *                         Xenmobile_RESTWS_Exception if an error occurs
    */
   public function _handleResponse( )
   {
     if ($this->getLastHttpReturn()['http_code'] == 403)
     {
       throw new Xenmobile_RESTWS_Exception( $this->getLastRequestResult() );
     }
     else
     {
       if ( $this->getLastRequestResult() && is_object($this->getLastRequestResult()) )
         {
           if ( isset( $this->getLastRequestResult()->status ) )
             {
               return ( $this->getLastRequestResult() );
             }
         }
     }

     if ($this->getLastRequestResult()->status != 0)
     {
         $this->log( $this->getLastRequestResult(), __METHOD__ );
     }

     throw new Xenmobile_RESTWS_Exception( $this->getLastRequestResult()->message, $this->getLastRequestResult()->status );
   }

   /**
    * Implementation of 'virtual methods here :)'
    *
   */
   public function __call( $szName, $arAguments )
   {
     if ( array_key_exists($szName, $this->_arMethodMatrix) != true)
     {
       throw new Xenmobile_RESTWS_Exception( 'oups method '.$szName."doesn't exist." );
     }

     return ( $this->_myCallback_DoByAListOfDevices($this->_arMethodMatrix[$szName]->szMethod,
                         $this->_arMethodMatrix[$szName]->szPath,
                         $arAguments[0]));
   }

   /**
   * Generic callback for all method only requiring an array of IDS as parameters
   *
   * @param string szMethod webservice methodtocall
   * @param string szPath webservice urlpath completion
   * @param array arSequentialID an array containing devices' ids
   *
   * @return mixed see self::_handleResponse
   */
   private function _myCallback_DoByAListOfDevices( $szMethod, $szPath, $arSequentialID )
   {
       $this->log('required : '.$szMethod, __METHOD__);

       $this->_throwExceptionIfNotArray( $arSequentialID );
       $this->_doRequest($szMethod, $szPath, $arSequentialID, 'POST');

       return ( $this->_handleResponse());
   }


 }

?>
