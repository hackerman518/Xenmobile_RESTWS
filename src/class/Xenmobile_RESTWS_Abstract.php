<?Php
/**
 * @author John PIGERET <github@mobilutils.com>
 */

namespace enoola_Citrix_Client;
require_once('./class/Xenmobile_RESTWS_Exception.php');
require_once('./class/IXenmobile_RESTWS_Authentication.php');


/*
 * The Abstract class being the one of the start point
 *
*/
abstract class Xenmobile_RESTWS_Abstract
{

  const PROTOCOL_HTTP = 'http';
  const PROTOCOL_HTTPS = 'https';
  const PORT_DEFAULT_HTTP = 80;
  const PORT_DEFAULT_HTTPS = 4443;
  const CONNECT_TIMEOUT = 10000; // 10s

  private $_szProtocol = self::PROTOCOL_HTTP;
  private $_nPort = self::PORT_DEFAULT_HTTP;
  private $_szFQDN = '';

  private $_szClassName = null; //contains the classname
  /*
   * debug change to true if you want to see a what's going on
   */
  private $_debug = false;
  private $_bVerifySSL = false;
  protected $_szAuthToken = null;
  protected $_oRequestLastReturn = null;
  protected $_arLastHttpReturn = array();
  protected $_szLastJsonRequest = null;
  protected $_szLastRequestCurlError = null;

  private $_errorCodes = array();

  /**
   * Setup API since this is an Abstract class we set constructor as
   * protected for child to call it
   *
   * @param string $szClassName {certificates, licenses, ldap, netscaler, notificationserver,deliverygroups, user,localusergroups, groups, serverproperties,application..}
   * @param string $szFQDN
   * @param int $nPort
   * @param string $szProtocol
   * @param boolean $bVerifySSL
   *
   * @return void
   */
  protected function __construct( $szClassName, $szFQDN, $nPort = self::PORT_DEFAULT_HTTPS, $szProtocol = self::PROTOCOL_HTTPS, $bVerifySSL = false)
  {
    $this->_szClassName = $szClassName;
    $this->_szFQDN = $szFQDN;
    $this->_bVerifySSL = $bVerifySSL;
    $this->_nPort = $nPort;
    $this->_szProtocol = $szProtocol;

    if (! empty($nPort) && is_numeric($nPort))
    {
        $this->_nPort = (int) $nPort;
    }
    if (! empty($szProtocol))
    {
        $this->_szProtocol = $szProtocol;
    }

  }

  public function __destruct()
  {
    //disconnect
    $this->log('end',__METHOD__);
  }

  /**
  * Get the base URL
  *
  * @return string
  */
  protected function _getBaseUrl()
  {
     return $this->_szProtocol . '://' . $this->_szFQDN . ':' . $this->_nPort . '/xenmobile/api/v1/' . $this->_szClassName;
  }

  /**
  * Set classname
  *
  * @param string classname
  * @return void
  */
  protected function _setClassname( $szClassName )
  {
    $this->_szClassName = $szClassName;
  }


  /**
  * get classname
  *
  * @return string
  */
  protected function _getClassname( )
  {
    return ( $this->_szClassName );
  }

  /**
  * do a Web Request to Xenmobile Server
  *
  * @param string szMethod
  * @param string szPath
  * @param string arParams
  * @param string classname
  * @return void
  */
  protected function _doRequest($szMethod, $szPath, $arParams = array(), $httpMethod = 'get', $arNewHeaders = null )
  {
    $this->log(__METHOD__);
    //if (!is_array($arParams))
    //{
    //    $arParams = array(
    //          $arParams
    //        );
    //}

    $szURL = $this->_getBaseUrl() . '/' . $szMethod;
    if (!empty($szPath) && !is_null($szPath) )
       $szURL .= '/' .$szPath ;

    // create a new cURL resource
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $szURL);
    if ( strcasecmp($httpMethod, 'get') == 0 ) //HTTP GET expected
    {
      if (isset($arParams) && !is_null($arParams) && is_array($arParams) && (count($arParams) > 0))
        $szURL .= '?' . http_build_query($arParams);

      $this->log($szURL, 'Requested Url (GET)');
    }
    elseif ( ( strcasecmp($httpMethod, 'post') == 0 )
              || ( strcasecmp($httpMethod, 'PUT') == 0 )
              || ( strcasecmp($httpMethod, 'DELETE') == 0 ) ) //HTTP POST expected
    {
      $this->log($szURL, __METHOD__ . ' Requested Url ('. strtoupper($httpMethod) .')');

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($httpMethod));
      if (isset($arParams) && !is_null($arParams) && is_array($arParams))
      {
        $jsonParams = json_encode($arParams);
        //die ($jsonParams);
        /*
         * Little ugly patch
         *
         * Indeed sequential array parsed with : json_encode wddx_serialize_value
         * filterIds = array ('device.platform#5.1.1@_fn_@device.platform.android.version')
         * jsonencode ($filterIds) = "filterIds": "["device.platform#5.1.1@_fn_@device.platform.android.version"]"
         * XenMobile Expects : "filterIds": "['device.platform#5.1.1@_fn_@device.platform.android.version']"
         *
         */
        $jsonParamsPatched = str_replace('["',"\"['", $jsonParams);
        $jsonParams = str_replace('"]',"']\"", $jsonParamsPatched);

        curl_setopt($ch, CURLOPT_POSTFIELDS,  $jsonParams );
      }
      elseif (isset($arParams) && is_string($arParams))
      {
        $jsonParams = $arParams;
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $jsonParams );
      }
    }
    else {
      throw new Xenmobile_RESTWS_Exception('httpMethod : '.$httpMethod.' NOT IMPLEMENTED');
    }

    if ($arNewHeaders == null)
    {
      $arHeaders = array('Content-Type: application/json');
      if ($this->_szAuthToken != null)
      {
        $arHeaders[] = 'auth_token:'.$this->_szAuthToken ;
      }
    }
    else
    {
      $arHeaders = $arNewHeaders;
    }
    if ( isset($jsonParams) )
      $arHeaders[] = 'Content-length:'.strlen($jsonParams);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $arHeaders );

    //So far no need to get information back
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //We want the body in the result of curl_exec
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, self::CONNECT_TIMEOUT);

    // Verify SSL or not
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->_bVerifySSL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->_bVerifySSL);

    //execute query
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);

    if ($info['http_code'] != 200) //an error (bad fqdn for example..
      $this->_szLastRequestCurlError = curl_error ( $ch );

    curl_close($ch);

    if (isset($jsonParams))
    {
      $this->log($jsonParams, __METHOD__.' Body');
      self::_setLastJsonRequest( $jsonParams );
    }
    $this->log($info['http_code'], __METHOD__.' Response code');

    self::_setLastRequestResult( $result );
    self::_setLastHttpReturn( $info );

    switch ($info['http_code'])
    {
      case 0:
        return (false);
      case 403 : //bad request
        $this->log('returned 403', __METHOD__);
        return ( false );
        break;
      default : // we assume it is OK (indeed) could be 200, 400, 500.... (as long as they have json format which 403 doesn't)
        return ( true );
        break;
    }
    if ($info['total_time'] >= (self::CONNECT_TIMEOUT / 1000))
    {
      throw new Xenmobile_RESTWS_Exception( 'Connection Timeout' );
    }
    $this->log($result, 'Result');
    throw new Xenmobile_RESTWS_Exception( 'Connection Error' );
  }




/*
* ---------------------- ICI --------------------------
*/
  abstract protected function _setAuthToken( $szAuthToken );

  /**
   * Return last request array http information
   *
   * @return mixed : array with last request return can be null
   */
  protected function _setLastHttpReturn( $arLastHttpReturn )
  {
    $this->_arLastHttpReturn = $arLastHttpReturn;
  }

  protected function _setLastJsonRequest( $szLastJsonRequest )
  {
    $this->_szLastJsonRequest = $szLastJsonRequest;
    return;
  }

  protected function _setLastRequestCurlError( $szLastRequestCurlError )
  {
    $this->_szLastRequestCurlError = $szLastRequestCurlError;
    return ;
  }

  protected function _setLastRequestResult( $oRequestLastReturn )
  {
    $this->_oRequestLastReturn = $oRequestLastReturn;
    if (is_string($oRequestLastReturn))
    {
      $this->_oRequestLastReturn = json_decode( $oRequestLastReturn );
    }
  }


  /**
   * Display information on standard output 1 when _debug is set to true
   * Logs
   * @todo needs to be improved with a dedicated object maybe ?
   * @param mixed $value
   * @param string $key
   *
   * @return void
   */
  protected function log($value, $key = null)
  {
      if ($this->_debug) {
          if ($key != null) {
              echo $key . ': ';
          }
          if (is_object($value) || is_array($value)) {
              $value = PHP_EOL . print_r($value, true);
          }
          echo $value . PHP_EOL;
      }
  }


  /*
  * handle response of Xenmobile
  *
  * @return mixed : return _oRequestLastReturn
  *                         Xenmobile_RESTWS_Exception if an error occurs
  */
 protected function _handleResponse( )
 {
   if ($this->_arLastHttpReturn['http_code'] == 403)
   {
     throw new Xenmobile_RESTWS_Exception( $this->_oRequestLastReturn );
   }
   else
   {
     if ( $this->_oRequestLastReturn && is_object( $this->_oRequestLastReturn ) )
       {
         if ( isset( $this->_oRequestLastReturn->status ) )
           {
             return ( $this->_oRequestLastReturn );
           }
       }
   }

   throw new Xenmobile_RESTWS_Exception( $this->_oRequestLastReturn->message, $this->_oRequestLastReturn->status );
 }


  /*
  * we shall be able to autogenerate some code, but since editor dev are lazy we can't.
  * <https://abhirockzz.wordpress.com/2015/07/10/jax-rs-and-http-options/>,
  * <https://jersey.java.net/documentation/latest/wadl.html>
  *
  *
  protected function GetOptions()
  {
    //shall we make a query with OPTION parameter or force the implementation ?
  }
  */
  /*
   *
  */
//  abstract protected function GetImplementedMethods();

}


?>
