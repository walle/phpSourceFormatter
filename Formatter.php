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

    $result = '';
    $tokens = token_get_all ($code);
    foreach ($tokens as $token)
    {
      if (is_string ($token))
      {
        $token = trim ($token);
        if ($token == '{')
        {
          $result = rtrim ($result) . PHP_EOL . $this->indenter->getIndention();
          $this->indenter->indent();
          $result .= $token . PHP_EOL . $this->indenter->getIndention();
        }
        elseif ($token == '}')
        {
          $this->indenter->outdent();
          $result = rtrim ($result) . PHP_EOL . $this->indenter->getIndention() . $token . PHP_EOL . $this->indenter->getIndention();
        }
        elseif ($token == ';')
        {
          $result .= $token . PHP_EOL . $this->indenter->getIndention();
        }
        elseif ($token == ':')
        {
          $result .= $token . PHP_EOL . $this->indenter->getIndention();
        }
        elseif ($token == '(')
        {
          $result .= ' ' . $token;
        }
        elseif ($token == ')')
        {
          $result .= $token;
        }
        elseif ($token == '@')
        {
          $in_at = true;
          $result .= $token;
        }
        elseif ($token == '.')
        {
          $result .= ' ' . $token . ' ';
        }
        elseif ($token == '=')
        {
          $result .= ' ' . $token . ' ';
        }
        else
        {
          $result .= $token;
        }
      }
      else
      {
        list ($id, $text) = $token;
        switch ($id)
        {
          case T_OPEN_TAG:
          case T_OPEN_TAG_WITH_ECHO:
            $in_php = true;
            $result .= trim ($text);
            break;
          case T_CLOSE_TAG:
            $in_php = false;
            $result .= trim ($text);
            break;
          case T_OBJECT_OPERATOR:
            $result .= trim ($text);
            $in_object = true;
            break;
          case T_STRING:
            if ($in_object)
            {
              $result = rtrim ($result) . trim ($text);
              $in_object = false;
            }
            elseif ($in_at)
            {
              $result = rtrim ($result) . trim ($text);
              $in_ = false;
            }
            else
            {
              $result = rtrim ($result) . ' ' . trim ($text);
            }
            break;
          case T_ENCAPSED_AND_WHITESPACE:
          case T_WHITESPACE:
            $result .= trim ($text);
            break;
          case T_RETURN:
          case T_ELSE:
          case T_ELSEIF:
            $result = rtrim ($result) . ' '  . trim ($text) . ' ';
            break;
          case T_CASE:
          case T_DEFAULT:
            $result = rtrim ($result) . PHP_EOL . $this->indenter->getIndention() . trim ($text) . ' ';
            break;
          case T_FUNCTION:
          case T_CLASS:
            $result .= PHP_EOL . $this->indenter->getIndention() . trim ($text) . ' ';
            break;
          case T_AND_EQUAL:
          case T_AS:
          case T_BOOLEAN_AND:
          case T_BOOLEAN_OR:
          case T_CONCAT_EQUAL:
          case T_DIV_EQUAL:
          case T_DOUBLE_ARROW:
          case T_IS_EQUAL:
          case T_IS_GREATER_OR_EQUAL:
          case T_IS_IDENTICAL:
          case T_IS_NOT_EQUAL:
          case T_IS_NOT_IDENTICAL:
          // case T_SMALLER_OR_EQUAL: // undefined constant ???
          case T_LOGICAL_AND:
          case T_LOGICAL_OR:
          case T_LOGICAL_XOR:
          case T_MINUS_EQUAL:
          case T_MOD_EQUAL:
          case T_MUL_EQUAL:
          case T_OR_EQUAL:
          case T_PLUS_EQUAL:
          case T_SL:
          case T_SL_EQUAL:
          case T_SR:
          case T_SR_EQUAL:
          case T_START_HEREDOC:
          case T_XOR_EQUAL:
            $result = rtrim ($result) . ' ' . trim ($text) . ' ';
            break;
          case T_COMMENT:
            $result = rtrim ($result) . PHP_EOL . $this->indenter->getIndention() . trim ($text) . ' ';
            break;
          case 'T_ML_COMMENT':
            $result = rtrim ($result) . PHP_EOL;
            $lines = explode (PHP_EOL, $text);
            foreach ($lines as $line)
            {
              $result .= $this->indenter->getIndention() . trim ($line);
            }
            $result .= PHP_EOL;
            break;
          case T_INLINE_HTML:
            $result .= $text;
            break;
          default:
            $result .= trim ($text);
            break;
        }
      }
    }

    return $result;
  }
}
