<?php 
//проверка введенных данных
function array_get($array, $key, $default = '')
{
  if (isset($array[$key]))
  {
    return $array[$key];
  }
  else
  {
    return $default;
  }
}


function array_get_cont_session($array, $key)
{
  if (isset($array[$key]))
  {
     $_SESSION['cont_'.$key.''] = 1;
  }
  else
  {
     unset($_SESSION['cont_'.$key.'']);
  }
}

function array_get_contr_session($array, $key)
{
  if (isset($array[$key]))
  {
     $_SESSION['contr_'.$key.''] = 1;
  }
  else
  {
     unset($_SESSION['contr_'.$key.'']);
  }
}


function make_safe_html($array)
{
    global $convert_encoding;
    if (is_array($array))
    {  
        foreach ($array as $key=>$value)   
        {
	       $array[$key]=htmlentities($value, ENT_QUOTES, "$convert_encoding");   
        }
    }
    else
    {
        $array=htmlentities($array, ENT_QUOTES, "$convert_encoding"); 
    }
    return $array;
}

function empty_get($array)
{
    if(empty($array))
    {
        $array='';
    }
    
    return $array;
}
