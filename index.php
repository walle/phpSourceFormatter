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

$formatter = new Formatter();

print $formatter->formatString($source);