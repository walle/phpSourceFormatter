<?php

namespace PhpSourceFormatter;

/**
 * Abstract class that contains all the logic for indention
 * Childs sets the $character and $charsPerIndention variables to make specific classes
 *
 * @package PhpSourceFormatter
 * @author Fredrik Wallgren <fredrik@wallgren.me>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Indenter
{
  /**
   *
   * @var String The strinc to use as indenter
   * @access protected
   */
  protected $character;

  /**
   *
   * @var int The number of $character that should be used in one indention
   * @access protected
   */
  protected $charsPerIndention;

  /**
   *
   * @var int A simple counter to keep track of at what indention level we are
   * @access protected
   */
  protected $indention;

  /**
   * Uses all the variable to determine the correct indention string
   *
   * @return string Returns the indention
   * @access public
   */
  public function getIndention()
  {
    $str = '';
    
    for ($i = 0; $i < $this->indention; $i++)
    {
      for ($j = 0; $j < $this->charsPerIndention; $j++)
      {
        $str .= $this->character;
      }
    }
    
    return $str;
  }

  /**
   * Increments the counter for indention, used to make all following indention one more indented
   */
  public function indent()
  {
    $this->indention++;
  }

  /**
   * Decrement the counter for indention, used to make all following indention one less indented
   */
  public function outdent()
  {
    if ($this->indention > 0)
    {
      $this->indention--;
    }
  }
}