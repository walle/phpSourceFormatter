<?php

include_once('Formatter.php');

use PhpSourceFormatter\Formatter;

$source = '<?php

namespace MyNamespace;

class course
{
 /**
  * @var sstring Description
  * @access public
  */
  public $uniktId;

 /**
  * @var sstring Description
  * @access public
  */
  public $kursKod;

 /**
  * @var sstring Description
  * @access public
  */
  public $benamning;

 /**
  * @var sstring Description
  * @access public
  */
  public $poang;

 /**
  * @var sstring Description
  * @access public
  */
  public $institution;

 /**
  * @var sstring Description
  * @access public
  */
  public $omfattning;

 /**
  * @var sstring Description
  * @access public
  */
  public $sprak;

  /**
   * @var sstring Description
   * @access public
  */
  public $undervisningsSprak;

  /**
   * @var sstring Description
   * @access public
  */
  public $undervisningsForm;

  /**
   * @var ArrayOfError Description
   * @access public
  */
  public $errors;
}';

$service = '<?php
class KursInfoWebServiceextends SoapClient
{
  /**
 * @var array $classmap The defined classes
 * @access private
 */private static$classmap = array ("GetListCourses" => "GetListCourses","kursSokData" => "kursSokData","utbildningsForm" => "utbildningsForm","takt" => "takt","niva" => "niva","kursTid" => "kursTid","GetListCoursesResponse" => "GetListCoursesResponse","kurs" => "kurs","kursTillfalle" => "kursTillfalle","error" => "error","GetCourseDetails" => "GetCourseDetails","GetCourseDetailsResponse" => "GetCourseDetailsResponse","GetPeriodsWithCourses" => "GetPeriodsWithCourses","GetPeriodsWithCoursesResponse" => "GetPeriodsWithCoursesResponse","termin" => "termin");
  /**
 * @param string $wsdl The wsdl file to use
 * @param array $config A array of config values
 * @access public
 */public function __construct ($wsdl = \'https://test.kursinfo.hj.se:444/webService/KursInfoWebService.asmx?wsdl\',$options = array ())
  {
    foreach ( self::$classmap as $key => $value)
    {
      if (!isset ($options[\'classmap\'][$key]))
      {
        $options[\'classmap\'][$key] = $value;
      }
    } parent:: __construct ($wsdl,$options);
  }
  /**
 * @param GetListCourses $$parameters
 * @access public
 */public
  function GetListCourses ( GetListCourses$parameters)
  { return $this->__soapCall (\'GetListCourses\',array ($parameters));
  }
  /**
 * @param GetCourseDetails $$parameters
 * @access public
 */public
  function GetCourseDetails ( GetCourseDetails$parameters)
  { return $this->__soapCall (\'GetCourseDetails\',array ($parameters));
  }
  /**
 * @param GetPeriodsWithCourses $$parameters
 * @access public
 */public
  function GetPeriodsWithCourses ( GetPeriodsWithCourses$parameters)
  { return $this->__soapCall (\'GetPeriodsWithCourses\',array ($parameters));
  }
}';

$formatter = new Formatter();

print $formatter->formatString($source);

print PHP_EOL.'-----'.PHP_EOL;

print $formatter->formatString($service);