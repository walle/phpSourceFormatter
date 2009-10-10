<?php

namespace PhpSourceFormatter;

include_once('Indenter.php');

/**
 * Implemention of Indenter that uses the tab character as indenter
 *
 * @package PhpSourceFormatter
 * @author Fredrik Wallgren <fredrik@wallgren.me>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @see Indenter
 */
class TabIndenter extends Indenter
{
  public function  __construct($charsPerIndent)
  {
    $this->character = "\t";
    $this->charsPerIndention = $charsPerIndent;
    $this->indention = 0;
  }
}