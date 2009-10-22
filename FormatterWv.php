<?php

namespace PhpSourceFormatter;

include_once('SpaceIndenter.php');

/**
 * Class that contains functionality for making php source code look pretty
 *
 * @package PhpSourceFormatter
 * @author Fredrik Wallgren <fredrik@wallgren.me>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Formatter
{
  private $indenter;

  public function  __construct()
  {
    $this->indenter = new SpaceIndenter(2);
  }

  public function formatString($code)
  {
    $t_count = 0;
    $in_object = false;
    $in_at = false;
    $in_php = false;

    $code = preg_replace('/[ \t]+/', ' ', $code);
    $code = preg_replace('/['.PHP_EOL.']+/', PHP_EOL, $code);

    $result = '';
    $tokens = token_get_all ($code);

    foreach ($tokens as $token)
    {
      $str = '';

      if (is_string ($token))
      {
        $token = trim($token);

        if ($token == '{')
        {
          $str = $this->startLine($token);
          $this->indenter->indent();
        }
        elseif ($token == '}')
        {
          $this->indenter->outdent();
          $str = $this->endLine($token);
        }
        elseif ($token == ';')
        {
          $str = $token.PHP_EOL;
        }
        elseif ($token == '@')
        {
          $in_at = true;
          $str = $token;
        }
        elseif ($token == '=')
        {
          $str = ' ' . $token . ' ';
        }
        else
        {
          $str = $token;
        }
      }
      else
      {
        list ($id, $text) = $token;

        $text = trim($text);

        switch ($id)
        {
          case T_OPEN_TAG:
          case T_OPEN_TAG_WITH_ECHO:
            $in_php = true;
            $str = $this->endLine($text);
            break;
          case T_CLOSE_TAG:
            $in_php = false;
            $str = $this->startLine($text);
            break;
          case T_OBJECT_OPERATOR:
            $str = $text;
            $in_object = true;
            break;
          case T_STRING:
            if ($in_object)
            {
              $str = $text;
              $in_object = false;
            }
            elseif ($in_at)
            {
              $str = $text;
              $in_ = false;
            }
            else
            {
              $str = ' ' . $text;
            }
            break;
          case T_ENCAPSED_AND_WHITESPACE:
          case T_WHITESPACE:
            $text = preg_replace('/[ \t]+/', ' ', $text);
            $text = preg_replace('/['.PHP_EOL.']+/', PHP_EOL, $text);
            $str .= $text;
            break;
          case T_DOC_COMMENT:
            $lines = explode (PHP_EOL, $text);
            $i = 0;
            foreach ($lines as $line)
            {
              if ($i++ > 0)
              {
                $str.= ' ';
              }
              else
              {
                $str .= PHP_EOL;
              }
              $str .= $this->endLine($line);

            }
            break;
          case T_CLASS:
          case T_NAMESPACE:
            $str = $this->startLine($text);
            break;
          case T_VARIABLE:
            $str = ' '.$text;
            break;
          default:
            $str = $this->indenter->getStr(trim($text));
            break;
        }
      }

      $result .= $str;
    }

    return $result;
  }

  private function startLine($str, $double = false)
  {
    $ret = '';
    if ($double) 
    {
      $ret .= PHP_EOL;
    }
    
    $ret .= PHP_EOL . $this->indenter->getStr(trim($str));
    
    return $ret;
  }
  
  private function endLine($str, $double = false)
  {
    $ret = '';
    
    $ret .= $this->indenter->getStr(trim($str)) . PHP_EOL;
    
    if ($double) 
    {
      $ret .= PHP_EOL;
    }
    
    return $ret;
  }

  private function ownLine($str)
  {
    return PHP_EOL.$this->indenter->getStr($str).PHP_EOL;
  }
}
